<?php

namespace App\Admin\Services\Post;
use App\Repositories\Post\PostCatalogueRepositoryInterface;
use Illuminate\Http\Request;

class PostCatalogueService implements PostCatalogueServiceInterface
{
    protected $data;

    protected $repository;

    public function __construct(PostCatalogueRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(Request $request)
    {
        $this->data = $request->validated();
        if ($this->data['image'] == null) {
            $this->data['image'] = '/images/not-found.jpg';
        }
        return $this->repository->create($this->data);
    }

    public function update(Request $request)
    {
        $this->data = $request->validated();
        if ($this->data['image'] == null) {
            $this->data['image'] = '/images/not-found.jpg';
        }
        return $this->repository->update($this->data['id'], $this->data);
    }
}
