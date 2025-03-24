<?php

namespace App\Repositories\Post;

use App\Models\Post;
use App\Repositories\BaseRepository;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    public function getModel()
    {
        return Post::class;
    }
}
