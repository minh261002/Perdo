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
        $this->service->store($request);
        return redirect()->back()
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
            'status'
        ]);

        $transport = $this->repository->findOrFail($data['id']);

        $transport->statuses()->create([
            'transport_id' => $data['id'],
            'status' => $data['status'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Cập nhật trạng thái vận chuyển thành công');
    }
}