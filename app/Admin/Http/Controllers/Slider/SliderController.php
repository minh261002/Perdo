<?php

namespace App\Admin\Http\Controllers\Slider;
;
use App\Admin\DataTables\Slider\SliderDataTable;
use App\Admin\DataTables\Slider\SliderItemDataTable;
use App\Admin\Http\Requests\Slider\SliderItemRequest;
use App\Admin\Http\Requests\Slider\SliderRequest;
use App\Enums\ActiveStatus;
use App\Repositories\Slider\SliderItemRepositoryInterface;
use App\Repositories\Slider\SliderRepositoryInterface;
use App\Admin\Services\Slider\SliderItemServiceInterface;
use App\Admin\Services\Slider\SliderServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    protected $sliderRepository;
    protected $sliderService;
    protected $sliderItemRepository;
    protected $sliderItemService;

    public function __construct(
        SliderRepositoryInterface $sliderRepository,
        SliderServiceInterface $sliderService,
        SliderItemRepositoryInterface $sliderItemRepository,
        SliderItemServiceInterface $sliderItemService
    ) {
        $this->sliderRepository = $sliderRepository;
        $this->sliderService = $sliderService;
        $this->sliderItemRepository = $sliderItemRepository;
        $this->sliderItemService = $sliderItemService;
    }

    public function index(SliderDataTable $dataTable)
    {
        return $dataTable->render('admin.slider.index');
    }

    public function create(): View
    {
        $status = ActiveStatus::asSelectArray();
        return view('admin.slider.create', compact('status'));
    }

    public function store(SliderRequest $request)
    {
        $this->sliderService->store($request);
        return redirect()->route('admin.slider.index')->with('success', 'Thêm slider thành công');
    }

    public function edit($id): View
    {
        $status = ActiveStatus::asSelectArray();
        $slider = $this->sliderRepository->findOrFail($id);
        return view('admin.slider.edit', compact('slider', 'status'));
    }

    public function update(SliderRequest $request)
    {
        $this->sliderService->update($request);
        return redirect()->route('admin.slider.index')->with('success', 'Cập nhật slider thành công');
    }

    public function updateStatus(Request $request)
    {
        $this->sliderService->updateStatus($request);

        return response()->json(['status' => 'success', 'message' => 'Cập nhật trạng thái slider thành công']);
    }

    public function delete($id)
    {
        $this->sliderRepository->delete($id);
        return response()->json(['status' => 'success', 'message' => 'Xóa slider thành công']);
    }

    public function indexItem(SliderItemDataTable $dataTable)
    {
        return $dataTable->render('admin.slider.item.index');
    }

    public function createItem($sliderId): View
    {
        $slider = $this->sliderRepository->findOrFail($sliderId);
        return view('admin.slider.item.create', compact('slider'));
    }

    public function storeItem(SliderItemRequest $request)
    {
        $this->sliderItemService->store($request);
        return redirect()->route('admin.slider.item.index', ['id' => $request->slider_id])->with('success', 'Thêm item thành công');
    }

    public function editItem($id): View
    {
        $item = $this->sliderItemRepository->findOrFail($id);
        $slider = $this->sliderRepository->findOrFail($item->slider_id);
        return view('admin.slider.item.edit', compact('item', 'slider'));
    }

    public function updateItem(SliderItemRequest $request)
    {
        $this->sliderItemService->update($request);
        return redirect()->route('admin.slider.item.index', ['id' => $request->slider_id])->with('success', 'Cập nhật item thành công');
    }

    public function deleteItem($id)
    {
        $this->sliderItemRepository->delete($id);
        return response()->json(['status' => 'success', 'message' => 'Xóa item thành công']);
    }
}
