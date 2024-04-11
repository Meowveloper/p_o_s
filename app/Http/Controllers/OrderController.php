<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //TODO go to admin/order/list.blade.php
    public function goToListPage() {
        $orders = Order::select('orders.*', 'users.name as user_name')->leftJoin('users', 'users.id', 'orders.user_id')->orderBy('orders.created_at', 'desc')->get();
        return view('admin.order.list', compact('orders'));
    }

    //TODO filter by status
    public function filterByStatus(Request $request) {

        $orders = Order::select('orders.*', 'users.name as user_name')->leftJoin('users', 'users.id', 'orders.user_id')->orderBy('orders.created_at', 'desc');

        if($request->statusId == NULL) {
            $orders = $orders->get();
        } else {
            $orders = $orders->where('orders.status', '=', $request->statusId)->get();
        }

        return response()->json($orders, 200);
    }


    //TODO changeStatusInTheDataBase
    public function changeStatusInTheDataBase(Request $request) {
        Order::where('id', '=', $request->orderId)->update([
            'status' => $request->statusId
        ]);

        return response()->json(['message' => 'status changed'], 200);

    }


    //TODO go to admin/order/details.blade.php
    public function goToOrderDetailsPage($orderCode) {
        $orderDetails = OrderList::select('order_lists.*', 'users.name as user_name', 'products.name as product_name', 'products.image as product_image', 'users.image as user_image', 'products.price as product_price')->where('order_code', '=', $orderCode)->leftJoin('users', 'order_lists.user_id', 'users.id')->leftJoin('products', 'products.id', 'order_lists.product_id')->get();

        $wholeTotal = 0;
        foreach($orderDetails as $item) {
            $wholeTotal += $item->total;
        }
        // dd($orderDetails->toArray(), $wholeTotal);
        return view('admin.order.details', compact('orderDetails', 'wholeTotal'));
    }
}
