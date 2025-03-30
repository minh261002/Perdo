<?php

namespace App\Admin\Http\Controllers\Transport;

use App\Admin\DataTables\Transport\TransportDataTable;
use App\Admin\Http\Requests\Transport\TransportRequest;
use App\Admin\Services\Transport\TransportServiceInterface;
use App\Enums\Transport\TransportMethod;
use App\Enums\Transport\TransportStatus;
use App\Repositories\Transport\TransportRepositoryInterface;
use Illuminate\Http\Request;
class TransportController
{
    protected $repository;
    protected $service;

    public function __construct(
        TransportRepositoryInterface $repository,
        TransportServiceInterface $service
    ) {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index(TransportDataTable $dataTable)
    {
        return $dataTable->render('admin.transport.index');
    }

    public function store(TransportRequest $request)
    {
        $response = $this->service->store($request);
        return redirect()->route('admin.transport.edit', $response->id)
            ->with('success', 'Tạo đơn vận chuyển thành công');
    }

    public function edit($id)
    {
        $transport = $this->repository->findOrFail($id);
        $transportMethod = TransportMethod::asSelectArray();
        $transportStatus = TransportStatus::asSelectArray();
        return view('admin.transport.edit', compact('transport', 'transportMethod', 'transportStatus'));
    }

    public function update(Request $request)
    {
        $data = $request->only([
            'id',
            'payment_status'
        ]);

        $transaction = $this->repository->findOrFail($data['id']);
        $transaction->update($data);

        return redirect()->back()->with('success', 'Cập nhật trạng thái vận chuyển thành công');
    }
}