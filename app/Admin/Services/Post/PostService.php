<?php

namespace App\Admin\Services\Post;

use App\Repositories\Post\PostRepositoryInterface;
use Illuminate\Http\Request;

class PostService implements PostServiceInterface
{
    protected $repository;

    public function __construct(PostRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validated();
        $catalogues = $validatedData['catalogue_id'] ?? [];
        unset($validatedData['catalogue_id']);

        if ($validatedData['image'] == null) {
            $validatedData['image'] = '/images/not-found.jpg';
        }
        $post = $this->repository->create($validatedData);

        $post->catalogues()->attach($catalogues);

        return $post;
    }

    public function update(Request $request)
    {
        $validatedData = $request->validated();

        $catalogues = $validatedData['catalogue_id'] ?? [];
        unset($validatedData['catalogue_id']);

        if ($validatedData['image'] == null) {
            $validatedData['image'] = '/images/not-found.jpg';
        }

        $post = $this->repository->update($validatedData['id'], $validatedData);

        $post->catalogues()->sync($catalogues);

        return $post;
    }
}
