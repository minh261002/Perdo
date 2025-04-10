<?php

namespace App\Http\Controllers;

use App\Http\Request\Profile\UpdatePasswordRequest;
use App\Http\Request\Profile\UpdateProfileRequest;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Services\Profile\ProfileServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected $service;

    protected $orderRepository;

    public function __construct(
        ProfileServiceInterface $service,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->service = $service;
        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        $user = Auth::guard('web')->user();
        return view('client.profile.index', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $this->service->update($request);
        return redirect()->back()->with('success', 'Cập nhật thông tin thành công');
    }

    public function changePasswordForm()
    {
        return view('client.profile.change-password');
    }

    public function changePassword(UpdatePasswordRequest $request)
    {
        $response = $this->service->updatePassword($request);
        return redirect()->back()->with($response['type'], $response['message']);
    }

    public function orders()
    {
        $query = $this->orderRepository->getByQueryBuilder([
            'user_id' => Auth::guard('web')->id(),
        ], [
            'items',
            'transaction',
            'statuses'
        ]);

        if (request()->has('status')) {
            $query = $query->whereHas('statuses', function ($q) {
                $q->where('status', request()->input('status')) // Lấy đúng giá trị của status
                    ->whereIn('id', function ($subQuery) {
                        $subQuery->selectRaw('MAX(id)')
                            ->from('order_statuses')
                            ->whereColumn('order_id', 'orders.id');
                    });
            });
        }

        if (request()->has('q')) {
            $query = $query->where('order_code', 'like', '%' . request()->input('q') . '%');
        }


        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('client.profile.order', compact('orders'));
    }

    public function discounts()
    {
        $user = Auth::guard('web')->user();
        $discounts = $user->discounts()->paginate(6);
        return view('client.profile.discount', compact('discounts'));
    }

    public function invoice($order_code)
    {
        $order = $this->orderRepository->getByQueryBuilder([
            'order_code' => $order_code,
        ], [
            'items',
            'transaction',
            'statuses'
        ])->first();

        return view('client.profile.order-invoice', compact('order'));
    }

    public function detail($order_code)
    {
        $order = $this->orderRepository->getByQueryBuilder([
            'order_code' => $order_code,
        ], [
            'items',
            'transaction',
            'statuses'
        ])->first();

        return view('client.profile.order-detail', compact('order'));
    }


    public function wishlists()
    {
        $user = Auth::guard('web')->user();
        $wishlists = $user->wishlists()->paginate(6);

        return view('client.profile.wishlist', compact('wishlists'));
    }

    public function notifications()
    {
        $user = Auth::guard('web')->user();
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->paginate(5);

        return view('client.profile.notification', compact('notifications'));
    }

    public function cancelOrder(Request $request, $order_code)
    {

        $cancel_reason = $request->input('cancel_reason');

        $order = $this->orderRepository->getByQueryBuilder([
            'order_code' => $order_code,
        ])->first();
        $order->update([
            'cancel_reason' => $cancel_reason,
        ]);
        $order->statuses()->create([
            'status' => 'cancelled',
        ]);

        return redirect()->back()->with('success', 'Hủy đơn hàng thành công');
    }
}