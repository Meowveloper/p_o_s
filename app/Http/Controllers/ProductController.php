<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //TODO go to admin/product/list.blade.php
    public function goToListPage()
    {
        $products = Product::
            select('products.*', 'categories.name as category_name')
            ->when(request('key'), function($iDoNotKnowWhatTheFuckDoesThisParameterMean) {
                $iDoNotKnowWhatTheFuckDoesThisParameterMean->where('products.name', 'like', '%'.request('key').'%');
            })
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->orderBy('products.created_at', 'desc')->paginate(3)
        ;
        $products->appends(request()->all());
        return view('admin.product.list', compact('products'));
    }


    //TODO go to admin/product/create.blade.php
    public function goToCreatePage()
    {
        $categories = Category::select('id', 'name')->get();
        // dd($categories->toArray());
        return view('admin.product.create', compact('categories'));
    }

    //TODO create a product
    public function createProduct(Request $request)
    {
        $this->checkValidationOfProductData($request, 'create');
        $data = $this->requestProductData($request);

        $fileName = uniqid() . '_meowveloper_' . $request->file('productImage')->getClientOriginalName();
        $request->file('productImage')->storeAs('public', $fileName);
        $data['image'] = $fileName;

        Product::create($data);
        return redirect()->route('product#goToListPage')->with([
            'productCreationSuccess' => 'New product has successfully created..'
        ]);
    }

    //TODO delete a product
    public function deleteProduct($id) {
        Product::where('id', '=', $id)->delete();
        return back()->with(['productDeleteSuccess' => 'Product deletion has been done successfully...']);
    }

    //TODO go to admin/product/details.blade.php
    public function goToDetailsPage($id) {
        $product = Product::select('products.*', 'categories.name as category_name')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->where('products.id', '=', $id)->first();
        return view('admin.product.details', compact('product'));
    }

    //TODO go to admin/product/edit.blade.php
    public function goToEditPage($id) {
        $product = Product::where('id', '=', $id)->first();
        $categories = Category::get();
        return view('admin.product.edit', compact('product', 'categories'));
    }


    //TODO edit the product
    public function editProduct(Request $request) {
        $this->checkValidationOfProductData($request, 'update');
        $data = $this->requestProductData($request);

        if($request->hasFile('productImage')) {
            $oldImageName = Product::where('id', '=', $request->productId)->first();
            $oldImageName = $oldImageName->image;

            if($oldImageName != NULL) {
                Storage::delete('public/'.$oldImageName);
            }

            $fileName = uniqid().'_meowveloper_'.$request->file('productImage')->getClientOriginalName();

            $request->file('productImage')->storeAs('public', $fileName);

            $data['image'] = $fileName;

        }

        Product::where('id', '=', $request->productId)->update($data);
        return redirect('product/detailsPage/' . $request->productId);

    }


    //TODO Private Functions-----------------------------------
    //TODO check the validation of the product data
    private function checkValidationOfProductData($request, $action)
    {

        $validationRules = [
            'productName' => 'required|min:5|unique:products,name,'.$request->productId,
            'productCategory' => 'required',
            'productDescription' => 'required|min:10',
            'productPrice' => 'required',
            'productWaitingTime' => 'required'
        ];

        if($action == 'create') {
            $validationRules['productImage'] = 'required|mimes:png,jpg,jpeg,avif|file';
        } elseif($action == 'update') {
            $validationRules['productImage'] = 'mimes:png,jpg,jpeg,avif|file';
        }

        // dd($validationRules);
        Validator::make($request->all(), $validationRules)->validate();
    }

    //TODO request the product data
    private function requestProductData($request)
    {
        return [
            'name' => $request->productName,
            'description' => $request->productDescription,
            'price' => $request->productPrice,
            'category_id' => $request->productCategory,
            'waiting_time' => $request->productWaitingTime
        ];
    }
}
