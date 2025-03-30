<?php

namespace App\Admin\Services\Transport;

use App\Enums\Transport\TransportStatus;
use App\Repositories\Transport\TransportRepositoryInterface;
use Illuminate\Http\Request;

class TransportService implements TransportServiceInterface
{
    protected $repository;

    public function __construct(
        TransportRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function store(Request $request)
    {

        $data = $request->validated();
        $data['transport_code'] = 'TR' . time();

        $transport = $this->repository->create($data);

        $transport->statuses()->create([
            'transport_id' => $transport->id,
            'status' => TransportStatus::Pending->value,
        ]);

        return $transport;
    }
}
