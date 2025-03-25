<?php

namespace App\Admin\Http\Controllers\Category;

use App\Admin\DataTables\Category\CategoryDataTable;
use App\Enums\ActiveStatus;
use App\Admin\Http\Requests\Category\CategoryRequest;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Admin\Services\Category\CategoryServiceInterface;
use Illuminate\Http\Request;

class CategoryController
{
    protected $repository;
    protected $service;

    public function __construct(
        CategoryRepositoryInterface $repository,
        CategoryServiceInterface $service
    ) {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.category.index');
    }

    public function create()
    {
        $status = ActiveStatus::asSelectArray();
        $categories = $this->repository->getFlatTree();
        return view('admin.category.create', compact('categories', 'status'));
    }

    public function store(CategoryRequest $request)
    {
        $this->service->store($request);
        return redirect()->route('admin.category.index')->with('success', 'Thêm mới danh mục thành công');
    }

    public function edit($id)
    {
        $category = $this->repository->find($id);
        $categories = $this->repository->getFlatTree();
        $status = ActiveStatus::asSelectArray();
        return view('admin.category.edit', compact('category', 'categories', 'status'));
    }

    public function update(CategoryRequest $request)
    {
        $this->service->update($request);
        return redirect()->route('admin.category.index')->with('success', 'Cập nhật danh mục thành công');
    }

    public function updateStatus(Request $request)
    {
        $data = $request->only('id', 'status');

        $this->repository->update($data['id'], $data);
        return response()->json(['status' => 'success', 'message' => 'Cập nhật trạng thái danh mục thành công']);
    }

    public function delete($id)
    {
        $this->repository->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Xóa danh mục thành công'
        ]);
    }

    public function get()
    {
        $offset = request()->get('offset', 0);
        $limit = 10;

        $categories = $this->repository->getFlatTree();
        $categoriesArray = $categories->toArray();

        if (request()->has('search')) {
            $search = request()->get('search');
            $categoriesArray = array_filter($categoriesArray, function ($cegory) use ($search) {
                return strpos($cegory['name'], $search) !== false;
            });
        }

        $total = count($categoriesArray);

        $categoriesArray = array_slice($categoriesArray, $offset, $limit);

        return response()->json([
            'categories' => $categoriesArray,
            'total' => $total
        ]);
    }
}