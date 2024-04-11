<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CategoryRouteController extends Controller
{

    //TODO get categories
    public function getList () {
        $categories = Category::get();
        return response()->json([
            "categories" => $categories
        ], 200);
    }

    //TODO create category (post)
    public function postCreate(Request $request) {
        $data = [
            "name" => $request->name,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ];

        $response = Category::create($data);

        return response()->json($response, 200);
    }

    //TODO delete category (post)
    public function postDelete(Request $request) {
        $data = Category::where('id', '=', $request->category_id)->first();

        if(isset($data)){
            Category::where('id', '=', $request->category_id)->delete();
            return response()->json([
                "status" => true,
                "message" => "delete success"
            ], 200);
        }else {
            return response()->json([
                "status" => false,
                "message" => "There is no category for this Id."
            ], 200);
        }
    }

    //TODO details (post)
    public function postDetails(Request $request) {
        $data = Category::where('id', '=', $request->category_id)->first();

        if (isset($data)) {
            return response()->json([
                "status" => true,
                "message" => "delete success",
                "category" => $data
            ], 200);
        } else {
            return response()->json([
                "status" => false,
                "message" => "There is no category for this Id."
            ], 200);
        }
    }

    //TODO update (post)
    public function postUpdate(Request $request) {

        $data = [
            "name" => $request->category_name,
            "updated_at" => Carbon::now()
        ];

       $shiThaLar = Category::where('id', '=', $request->category_id)->first();

        if(isset($shiThaLar)) {
            $response = Category::where('id', '=', $request->category_id)->update($data);

            return response()->json([
                "status" => true,
                "message" => "Update success",
                "category" => $response
            ], 200);

        } else {
            return response()->json([
                "status" => false,
                "message" => "There is no category for this Id."
            ], 500);
        }

    }


}
