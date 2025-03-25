<?php

namespace App\Admin\Http\Controllers\Post;

use App\Admin\DataTables\Post\PostCatalogueDataTable;
use App\Enums\ActiveStatus;
use App\Http\Controllers\Controller;
use App\Admin\Http\Requests\Post\PostCatalogueRequest;
use App\Repositories\Post\PostCatalogueRepositoryInterface;
use App\Admin\Services\Post\PostCatalogueServiceInterface;
use Illuminate\Http\Request;

class PostCatalogueController extends Controller
{
    protected $repository;
    protected $service;

    public function __construct(
        PostCatalogueRepositoryInterface $repository,
        PostCatalogueServiceInterface $service
    ) {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index(PostCatalogueDataTable $dataTable)
    {
        return $dataTable->render('admin.post-catalogue.index');
    }

    public function create()
    {
        $status = ActiveStatus::asSelectArray();
        $catalogues = $this->repository->getFlatTree();
        return view('admin.post-catalogue.create', compact('catalogues', 'status'));
    }


    public function store(PostCatalogueRequest $request)
    {
        $this->service->store($request);
        return redirect()->route('admin.post_catalogue.index')->with('success', 'Thêm chuyên mục bài viết thành công');
    }

    public function edit($id)
    {
        $post_catalogue = $this->repository->findOrFail($id);
        $catalogues = $this->repository->getFlatTree();
        $status = ActiveStatus::asSelectArray();
        return view('admin.post-catalogue.edit', compact('post_catalogue', 'catalogues', 'status'));
    }

    public function update(PostCatalogueRequest $request)
    {
        $this->service->update($request);
        return redirect()->route('admin.post_catalogue.index')->with('success', 'Cập nhật chuyên mục bài viết thành công');
    }

    public function updateStatus(Request $request)
    {
        $data = $request->only('id', 'status');
        $this->repository->update($data['id'], $data);
        return response()->json(['status' => 'success', 'message' => 'Cập nhật trạng thái thành công']);
    }

    public function delete($id)
    {
        $this->repository->delete($id);
        return response()->json(['status' => 'success', 'message' => 'Xóa chuyên mục bài viết thành công']);
    }

    public function get()
    {
        $offset = request()->get('offset', 0);
        $limit = 10;

        $catalogues = $this->repository->getFlatTree();
        $cataloguesArray = $catalogues->toArray();

        if (request()->has('search')) {
            $search = request()->get('search');
            $cataloguesArray = array_filter($cataloguesArray, function ($catalogue) use ($search) {
                return strpos($catalogue['name'], $search) !== false;
            });
        }

        $total = count($cataloguesArray);

        $cataloguesArray = array_slice($cataloguesArray, $offset, $limit);

        return response()->json([
            'catalogues' => $cataloguesArray,
            'total' => $total
        ]);
    }
}