<?php

namespace App\Admin\Http\Controllers\Order;

use App\Admin\DataTables\Order\OrderDataTable;
use App\Enums\Order\OrderStatus;
use App\Enums\Transaction\PaymentMethod;
use App\Enums\Transaction\PaymentStatus;
use App\Enums\Transport\TransportMethod;
use App\Enums\Transport\TransportStatus;
use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;

class OrderController
{
    protected $repository;
    protected $statusRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
    ) {
        $this->repository = $orderRepository;
    }

    public function index(OrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.index');
    }

    public function edit($id)
    {
        $order = $this->repository->findOrFail($id);
        $orderStatus = OrderStatus::asSelectArray();
        $paymentMethods = PaymentMethod::asSelectArray();
        $paymentStatus = PaymentStatus::asSelectArray();
        $deliveryMethod = TransportMethod::asSelectArray();
        $deliveryStatus = TransportStatus::asSelectArray();


        return view('admin.order.edit', compact('order', 'orderStatus', 'paymentMethods', 'paymentStatus', 'deliveryMethod', 'deliveryStatus'));
    }

    public function update(Request $request)
    {
        $data = $request->only([
            'status',
            'id',
            'cancel_reason',
        ]);

        $order = $this->repository->findOrFail($data['id']);
        $order->update([
            'cancel_reason' => $data['cancel_reason'],
        ]);
        $order->statuses()->create([
            'order_id' => $order->id,
            'status' => $data['status'],
        ]);

        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công');
    }

    public function invoice($id)
    {
        $order = $this->repository->findOrFail($id);
        return view('admin.order.invoice', compact('order'));
    }

    public function printInvoice($id)
    {
        $order = $this->repository->findOrFail($id);

        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $data = [
            'order' => $order,
        ];
        $html = view('admin.order.invoice_template', $data)->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait'); // 80mm ~ 226.77 điểm
        $dompdf->render();
        $file = $dompdf->output();
        $fileName = 'invoice_' . $order->order_code . '.pdf';

        return response()->streamDownload(
            fn() => print ($file),
            $fileName,
            ['Content-Type' => 'application/pdf']
        )->send();
    }
}
