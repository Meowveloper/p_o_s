<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;

class ProductRouteController extends Controller
{



    public function getList() {
        $products = Product::get();
        $users = User::get();
        return response()->json([
            "products" => $products,
            "users" => $users
        ], 200);
    }


}
