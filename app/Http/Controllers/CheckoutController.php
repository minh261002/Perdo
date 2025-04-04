<?php

namespace App\Http\Controllers;

use App\Enums\Transaction\PaymentStatus;
use App\Http\Request\Order\OrderStoreRequest;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Services\Order\OrderServiceInterface;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected $repository;
    protected $service;

    public function __construct(
        OrderRepositoryInterface $repository,
        OrderServiceInterface $service
    ) {
        $this->repository = $repository;
        $this->service = $service;
    }


    public function index()
    {
        $cart = session()->get('cart', []);
        $subTotal = $cart ? array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart)) : 0;
        $totalPrice = $subTotal;
        return view('client.checkout.index', compact('cart', 'subTotal', 'totalPrice'));
    }

    public function store(OrderStoreRequest $request)
    {
        $this->service->store($request);
    }

    public function review($order_code)
    {
        $order = $this->repository->getByQueryBuilder([
            'order_code' => $order_code
        ])->first();
        return view('client.checkout.review', compact('order'));
    }

    public function vnpayCallback(Request $request)
    {
        $order = $this->service->vnpayCallback($request);
        if ($order) {
            return redirect()->route('checkout.review', $order->order_code)->with(
                $order->transaction->payment_status == PaymentStatus::Completed->value ? 'success' : 'error',
                $order->transaction->payment_status == PaymentStatus::Completed->value ? 'Thanh toán thành công' : 'Thanh toán thất bại'
            );
        }
    }

    public function momoCallback(Request $request)
    {
        $order = $this->service->momoCallback($request);
        if ($order) {
            return redirect()->route('checkout.review', $order->order_code)->with(
                $order->transaction->payment_status == PaymentStatus::Completed->value ? 'success' : 'error',
                $order->transaction->payment_status == PaymentStatus::Completed->value ? 'Thanh toán thành công' : 'Thanh toán thất bại'
            );
        }
    }

    public function payosCallback(Request $request)
    {
        $order = $this->service->payosCallback($request);
        if ($order) {
            return redirect()->route('checkout.review', $order->order_code)->with(
                $order->transaction->payment_status == PaymentStatus::Completed->value ? 'success' : 'error',
                $order->transaction->payment_status == PaymentStatus::Completed->value ? 'Thanh toán thành công' : 'Thanh toán thất bại'
            );
        }
    }
}
