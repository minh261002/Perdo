<?php

namespace App\Admin\Http\Controllers\Product;

use App\Admin\DataTables\Product\ProductDataTable;
use App\Enums\ActiveStatus;
use App\Admin\Http\Requests\Product\ProductRequest;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Admin\Services\Product\ProductServiceInterface;
use Illuminate\Http\Request;

class ProductController
{
    protected $service;
    protected $repository;
    protected $warehouseRepository;
    protected $brandRepository;

    public function __construct(
        ProductServiceInterface $service,
        ProductRepositoryInterface $repository,
        BrandRepositoryInterface $brandRepository
    ) {
        $this->service = $service;
        $this->repository = $repository;
        $this->brandRepository = $brandRepository;
    }

    public function index(ProductDataTable $dataTable)
    {
        return $dataTable->render('admin.product.index');
    }

    public function create()
    {
        $status = ActiveStatus::asSelectArray();
        $brands = $this->brandRepository->getQueryBuilderOrderBy()->pluck('name', 'id')->toArray();
        return view('admin.product.create', compact('status', 'brands'));
    }

    public function store(ProductRequest $request)
    {
        $this->service->store($request);
        return redirect()->route('admin.product.index')->with('success', 'Thêm sản phẩm thành công');
    }

    public function edit($id)
    {
        $product = $this->repository->find($id);
        $status = ActiveStatus::asSelectArray();
        $brands = $this->brandRepository->getQueryBuilderOrderBy()->pluck('name', 'id')->toArray();
        return view('admin.product.edit', compact('product', 'status', 'brands'));
    }

    public function updateStatus(Request $request)
    {
        $data = $request->only('id', 'status');
        $this->repository->update($data['id'], $data);
        return response()->json(['status' => 'success', 'message' => 'Cập nhật trạng thái thành công']);
    }

    public function update(ProductRequest $request)
    {
        $this->service->update($request);
        return redirect()->route('admin.product.index')->with('success', 'Cập nhật sản phẩm thành công');
    }

    public function delete($id)
    {
        $this->repository->delete($id);
        return response()->json(['status' => 'success', 'message' => 'Xóa sản phẩm thành công']);
    }

    public function get()
    {
        $offset = request()->get('offset', 0);
        $limit = 10;
        $search = request()->get('search', '');

        $products = $this->repository->getByQueryBuilder(
            ['status' => ActiveStatus::Active->value]
        )->get();

        $productsArray = $products->toArray();

        if (!empty($search)) {
            $productsArray = array_filter($productsArray, function ($product) use ($search) {
                return str_contains($product['name'], $search);
            });
        }

        $total = count($productsArray);

        $productsArray = array_slice($productsArray, $offset, $limit);

        return response()->json([
            'products' => array_values($productsArray),
            'total' => $total
        ]);
    }

}
