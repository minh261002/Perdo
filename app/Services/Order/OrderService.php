<?php

namespace App\Services\Order;

use App\Enums\Order\OrderStatus;
use App\Enums\Transaction\PaymentMethod;
use App\Enums\Transaction\PaymentStatus;
use App\Models\DiscountApplication;
use App\Models\Product;
use App\Repositories\Order\OrderItemRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PayOS\PayOS;

class OrderService implements OrderServiceInterface
{
    protected $repository;
    protected $itemRepository;
    protected $statusRepository;
    protected $transactionRepository;

    public function __construct(
        OrderRepositoryInterface $repository,
        OrderItemRepositoryInterface $itemRepository,
        TransactionRepositoryInterface $transactionRepository
    ) {
        $this->repository = $repository;
        $this->itemRepository = $itemRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function store(Request $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $orderData = $data['order'];

            $orderData['address'] = $data['address'];
            $orderData['lat'] = $data['lat'];
            $orderData['lng'] = $data['lng'];
            $orderData['user_id'] = Auth::guard('web')->id() ?? null;
            $orderData['order_code'] = 'DH' . time();
            $order = $this->repository->create($orderData);

            $cart = session()->get('cart', []);
            foreach ($cart as $item) {
                $this->itemRepository->create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                $product = Product::find($item['id']);
                $product->update([
                    'stock' => $product->stock - $item['quantity']
                ]);
            }

            if (!empty($data['discount_id'])) {
                DiscountApplication::where('discount_id', $data['discount_id'])->where('user', Auth()->guard('web')->id())->update([
                    'order_id' => $order->id
                ]);
            }

            $order->status()->create([
                'order_id' => $order->id,
                'status' => OrderStatus::Pending->value
            ]);

            $transactionData = $data['transaction'];
            $transactionData['order_id'] = $order->id;
            $transactionData['transaction_code'] = 'GD' . time();
            $transactionData['amount'] = $order->total;
            $this->transactionRepository->create($transactionData);

            DB::commit();

            // session()->forget('cart');
            $paymentMethod = $transactionData['payment_method'];
            if ($paymentMethod == PaymentMethod::VNPAY->value) {
                $this->paymentVnPay($order);
            } elseif ($paymentMethod == PaymentMethod::MOMO->value) {
                $this->paymentMomo($order);
            } elseif ($paymentMethod == PaymentMethod::QRCODE->value) {
                $this->paymentQrCode($order);
            } else {
                echo "<script>window.location.href='" . route('checkout.review', $order->order_code) . "';</script>";
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
        }
    }


    public function paymentMomo($order)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        if (!empty($order)) {
            $partnerCode = 'MOMOBKUN20180529';
            $accessKey = 'klm05TvNBzhg7h7j';
            $serectkey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
            $orderId = time() . rand(1000000, 9999999);
            $orderInfo = "Thanh toán qua MoMo";
            $amount = (float) $order->total;
            $redirectUrl = route('checkout.momo.callback', [
                'order_code' => $order->order_code
            ]);
            $ipnUrl = "https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b";
            $extraData = "";

            $requestId = time() . "";
            $requestType = "captureWallet";
            //before sign HMAC SHA256 signature
            $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
            $signature = hash_hmac("sha256", $rawHash, $serectkey);
            $data = array(
                'partnerCode' => $partnerCode,
                'partnerName' => "Test",
                "storeId" => "MomoTestStore",
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature
            );
            $result = $this->execPostRequest($endpoint, json_encode($data));
            $jsonResult = json_decode($result, true);  // decode json

            echo "<script>window.location.href='" . $jsonResult['payUrl'] . "';</script>";
        }
    }

    function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception('CURL Error: ' . curl_error($ch));
        }

        curl_close($ch);
        return $result;
    }

    public function momoCallback(Request $request)
    {
        $data = $request->all();

        $orderCode = $data['order_code'];
        $status = $data['resultCode'];

        $order = $this->repository->getByQueryBuilder([
            'order_code' => $orderCode
        ])->first();

        $transaction = $order->transaction;

        if ($transaction) {
            if ($status == 0) {
                $transaction->update([
                    'payment_status' => PaymentStatus::Completed->value
                ]);
            } else {
                $transaction->update([
                    'payment_status' => PaymentStatus::Cancelled->value
                ]);
                $order->update([
                    'cancel_reason' => 'Khách hàng hủy thanh toán'
                ]);
                $order->status()->create([
                    'order_id' => $order->id,
                    'status' => OrderStatus::Cancelled->value
                ]);
            }
        }

        return $order;
    }

    public function paymentQrCode($order)
    {
        $payOSClientId = '4ba91acb-2493-44c3-8bcd-72bab955f3ef';
        $payOSApiKey = '7e8266eb-ec81-4265-b304-c7b1eb21a470';
        $payOSChecksumKey = '34fda33ae365caed70340a634a2cee273ed468bfbcf5eb4513300199623d410f';
        $payosPartnerCode = 'MINH';

        $payOS = new PayOS($payOSClientId, $payOSApiKey, $payOSChecksumKey, $payosPartnerCode);

        $data = [
            "orderCode" => intval(substr(strval(microtime(true) * 10000), -6)),
            "amount" => (float) $order->total,
            "description" => "Thanh toán đơn hàng",
            "returnUrl" => route('checkout.payos.callback', [
                'order_code' => $order->order_code
            ]),
            "cancelUrl" => route('checkout.payos.callback', [
                'order_code' => $order->order_code
            ]),
        ];

        $response = $payOS->createPaymentLink($data);

        echo "<script>window.location.href='" . $response['checkoutUrl'] . "';</script>";
    }

    public function payosCallback(Request $request)
    {
        $data = $request->all();

        Log::info('PayOS Callback', $data);

        $orderCode = $data['order_code'];
        $status = $data['status'];

        $order = $this->repository->getByQueryBuilder([
            'order_code' => $orderCode
        ])->first();

        $transaction = $order->transaction;

        if ($transaction) {
            if ($status == 'PAID') {
                $transaction->update([
                    'payment_status' => PaymentStatus::Completed->value
                ]);
            } else {
                $transaction->update([
                    'payment_status' => PaymentStatus::Cancelled->value
                ]);
                $order->update([
                    'cancel_reason' => 'Khách hàng hủy thanh toán'
                ]);
                $order->status()->create([
                    'order_id' => $order->id,
                    'status' => OrderStatus::Cancelled->value
                ]);
            }
        }

        return $order;

    }

    public function paymentVnPay($order)
    {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('checkout.vnpay.callback');
        $vnp_TmnCode = 'GMYSB70W';
        $vnp_HashSecret = 'M3FQ4G54IGVU983AHQTIXTKVJJVI76ES';

        $vnp_TxnRef = $order->order_code;
        $vnp_OrderInfo = 'Thanh toán hóa đơn';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = (float) $order->total * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = '';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        $vnp_ExpireDate = date('YmdHis', strtotime(date("YmdHis")) + 86400);

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $vnp_ExpireDate,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        echo "<script>window.location.href='" . $vnp_Url . "';</script>";
    }

    public function vnpayCallback(Request $request)
    {
        $orderCode = $request->vnp_TxnRef;
        $status = $request->vnp_ResponseCode;

        $order = $this->repository->getByQueryBuilder([
            'order_code' => $orderCode
        ])->first();
        $transaction = $order->transaction;

        if ($transaction) {
            if ($status == '00') {
                $transaction->update([
                    'payment_status' => PaymentStatus::Completed->value
                ]);
            } else {
                $transaction->update([
                    'payment_status' => PaymentStatus::Cancelled->value
                ]);
                $order->update([
                    'cancel_reason' => 'Khách hàng hủy thanh toán'
                ]);
                $order->status()->create([
                    'order_id' => $order->id,
                    'status' => OrderStatus::Cancelled->value
                ]);
            }
        }

        return $order;
    }
}
