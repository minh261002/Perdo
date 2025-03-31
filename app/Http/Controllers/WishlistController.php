<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::guard('web')->user();
        $productId = $request->input('product_id');

        $existingWishlist = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->exists();

        if ($existingWishlist) {
            return response()->json(['status' => 'success', 'message' => 'Sản phẩm đã tồn tại trong danh sách yêu thích'], 409);
        }

        Wishlist::insert([
            'user_id' => $user->id,
            'product_id' => $productId,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Sản phẩm đã được thêm vào danh sách yêu thích'], 201);
    }


    public function delete(Request $request)
    {
        $user = Auth::guard('web')->user();
        $productId = $request->input('product_id');

        $deleted = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->delete();

        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => 'Sản phẩm đã được xoá khỏi danh sách yêu thích'], 200);
        }

        return response()->json(['status' => 'success', 'message' => 'Không tìm thấy sản phẩm trong danh sách yêu thích'], 404);
    }

}