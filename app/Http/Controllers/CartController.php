<?php

namespace App\Http\Controllers;

use App\Http\Request\Cart\AddToCartRequest;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $productRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository
    ) {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        return view('client.checkout.cart', compact('cart'));
    }

    public function addToCart(AddToCartRequest $request)
    {
        $data = $request->validated();
        $product = $this->productRepository->findOrFail($data['id']);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sản phẩm không tồn tại.'
            ], 404);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$data['id']])) {
            $newQuantity = $cart[$data['id']]['quantity'] + $data['quantity'];

            if ($newQuantity > $product->stock) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Số lượng sản phẩm trong giỏ hàng vượt quá số lượng hiện có sẵn trong kho!'
                ], 400);
            }

            $cart[$data['id']]['quantity'] = $newQuantity;
        } else {
            if ($data['quantity'] > $product->stock) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Số lượng sản phẩm trong giỏ hàng vượt quá số lượng hiện có sẵn trong kho!'
                ], 400);
            }

            $cart[$data['id']] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $data['quantity']
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'status' => 'success',
            'message' => 'Thêm sản phẩm vào giỏ hàng thành công!'
        ]);
    }

    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->id;
        $quantity = (int) $request->quantity;

        $product = $this->productRepository->findOrFail($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sản phẩm không tồn tại.'
            ], 404);
        }

        if (!isset($cart[$id])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sản phẩm không có trong giỏ hàng.'
            ], 400);
        }

        if ($quantity <= 0) {
            unset($cart[$id]);
        } else {
            if ($quantity > $product->stock) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Số lượng sản phẩm trong giỏ hàng vượt quá số lượng có sẵn!'
                ], 400);
            }

            $cart[$id]['quantity'] = $quantity;
        }

        session()->put('cart', $cart);

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật giỏ hàng thành công!'
        ]);
    }

}
