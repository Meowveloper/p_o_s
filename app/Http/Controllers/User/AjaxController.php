<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{

    //TODO return pizza list to JS
    public function returnProductList() {
        return Product::get();
    }

    //TODO add to cart
    public function addToCart(Request $request) {
        logger($request->all());
        $sameProductExist = false;

        $sameCartId = 0;

        $userCart = Cart::where('user_id', '=', Auth::user()->id)->get();

        $data = [
            'user_id' => $request->userId,
            'product_id' => $request->productId,
            'qty' => $request->count,
            'crated_at' => Carbon::now(),
            'update_at' => Carbon::now()
        ];

        foreach($userCart as $item) {
            if($item->product_id == $data['product_id']) {
                $sameProductExist = true;
                $sameCartId = $item->id;
                break;
            }
        }


        if($sameProductExist) {
            $sameProduct = Cart::where('id', '=', $sameCartId)->first();

            Cart::where('id', '=', $sameProduct->id)->update([
                'qty' => $sameProduct->qty + $data['qty']
            ]);

            $reponse = [
                'status' => 'success',
                'message' => 'Updated'
            ];

            return response()->json($reponse, 200);


        } else {
            Cart::create($data);

            $reponse = [
                'status' => 'success',
                'message' => 'Product ID ' . $data['product_id'] . ' was added to cart successfully.'
            ];

            return response()->json($reponse, 200);
        }

    }

    //TODO remove a product from cart
    public function removeAProductFromCart(Request $request) {
        Cart::where('id', '=', $request->id)->delete();
    }


    //TODO make check out
    public function checkOut(Request $request) {
        logger($request->all());

        $totalPrice = 0;

        foreach($request->all() as $item) {
            $data = OrderList::create([
                'user_id' => $item['user_id'],
                'product_id' => $item['product_id'],
                'qty' => $item['qty'],
                'total' => $item['total'],
                'order_code' => $item['order_code']
            ]);

            $totalPrice += $data->total;
        }

        Cart::where('user_id', '=', Auth::user()->id)->delete();

        Order::create([
            'user_id' => Auth::user()->id,
            'order_code' => $data->order_code,
            'total_price' => $totalPrice + 3000,
            'status' => 0
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Check Out Success'
        ], 200);


    }


    //TODO clear cart
    public function clearCart() {
        Cart::where('user_id', '=', Auth::user()->id)->delete();
    }


    //TODO increase view count
    public function increaseViewCount(Request $request) {
        logger($request);
        $product = Product::where('id', '=', $request->productId)->first();
        Product::where('id', '=', $request->productId)->update([
            'view_count' => $product->view_count + 1
        ]);
    }
}
