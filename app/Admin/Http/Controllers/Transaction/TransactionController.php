<?php

namespace App\Admin\Http\Controllers\Transaction;

use App\Admin\DataTables\Transaction\TransactionDataTable;
use App\Enums\Transaction\PaymentMethod;
use App\Enums\Transaction\PaymentStatus;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use Illuminate\Http\Request;
class TransactionController
{
    protected $repository;

    public function __construct(
        TransactionRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function index(TransactionDataTable $dataTable)
    {
        return $dataTable->render('admin.transaction.index');
    }

    public function edit($id)
    {
        $transaction = $this->repository->findOrFail($id);
        $paymentMethods = PaymentMethod::asSelectArray();
        $paymentStatuses = PaymentStatus::asSelectArray();
        return view('admin.transaction.edit', compact('transaction', 'paymentMethods', 'paymentStatuses'));
    }

    public function update(Request $request)
    {
        $data = $request->only([
            'id',
            'payment_status'
        ]);

        $transaction = $this->repository->findOrFail($data['id']);
        $transaction->update($data);

        return redirect()->back()->with('success', 'Cập nhật trạng thái thanh toán thành công');
    }
}