<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Faker\Core\Number;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    //TODO go to user/main/home.blade.php
    public function goToHomePage() {
        $cart = Cart::where('user_id', '=', Auth::user()->id)->get();
        $filteredId = '';
        $products = Product::orderBy('created_at', 'desc')->get();
        $categories = Category::get();
        $history = Order::where('user_id', '=', Auth::user()->id)->get();

        return view('user.main.home', compact('products', 'categories', 'filteredId', 'cart', 'history'));
    }

    //TODO go to user/password/change.blade.php
    public function goToPasswordChangePage() {
        return view('user.password.change');
    }


    //TODO change user password
    public function changePassword(Request $request) {

        //check validation
        Validator::make($request->all(), [
            'oldPassword' => 'required',
            'newPassword' => 'required|min:8',
            'confirmPassword' => 'required|same:newPassword'
        ])->validate();

        $oldDbPassword = Auth::user()->password;
        $oldPassword = $request->oldPassword;


        if(Hash::check($oldPassword, $oldDbPassword)) {
            User::where('id', '=', Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);

            return back()->with([
                'success' => Auth::user()->name."'s password has been changed successfully.."
            ]);
        } else {
            return back()->with([
                'notMatch' => 'Dear '.Auth::user()->name.", your old password is incorrect. Sit back, relax and try to remember your password..."
            ]);
        }

    }
    //************************* */

    //TODO go to user/account/details.blade.php
    public function goToDetailsPage() {
        return view('user.account.details');
    }

    //TODO go to user/account/edit.blade.php
    public function goToEditPage() {
        return view('user.account.edit');
    }


    //TODO edit user account details
    public function editAccount(Request $request, $id) {
        $this->checkValidationUserData($request);
        $data = $this->requestUserData($request);

        if ($request->hasFile('image')) {
            $dbImage = User::where('id', '=', $id)->first();
            $dbImage = $dbImage->image;

            if ($dbImage != NULL) {
                Storage::delete('public/' . $dbImage);
            }

            $fileName = uniqid() . '_meowveloper_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $fileName);
            $data['image'] = $fileName;
        }

        User::where('id', '=', $id)->update($data);
        return redirect()->route('user#account#goToDetailsPage')->with(['userAccountUpdateSuccess' => 'Your account information has been updated successfully...']);
    }

    //TODO filter by categories
    public function filterByCategories($id) {
        $filteredId = $id;
        $cart = Cart::where('user_id', '=', Auth::user()->id)->get();
        $products = Product::where('category_id', '=', $id)->orderBy('created_at', 'desc')->get();
        $categories = Category::get();
        $history = Order::where('user_id', '=', Auth::user()->id)->get();

        return view('user.main.home', compact('products', 'categories', 'filteredId', 'cart', 'history'));
    }


    //TODO go to user/main/productDetails.blade.php
    public function goToProductDetailsPage($id) {
        $product = Product::where('id', '=', $id)->first();
        $allProducts = Product::get();
        return view('user.main.productDetails', compact('product', 'allProducts'));
    }


    //TODO go to user/main/cart.blade.php
    public function goToCartPage() {
        $cart = Cart::select('carts.*', 'products.name as product_name', 'products.price as product_price', 'products.image as product_image')
            ->where('carts.user_id', '=', Auth::user()->id)
            ->leftJoin('products', 'carts.product_id', '=' , 'products.id')
            ->get()
        ;

        $cartTotalPrice = 0;

        foreach($cart as $item) {
            $cartTotalPrice += $item->product_price * $item->qty;
        }


        return view('user.main.cart', compact('cart', 'cartTotalPrice'));
    }

    //TODO go to user/main/orderHistory.blade.php
    public function goToOrderHistoryPage() {
        $history = Order::where('user_id', '=', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(3);


        return view('user.main.orderHistory', compact('history'));
    }


    //TODO private functions-----------------------------

    //TODO check validation of form(user) data
    private function checkValidationUserData($request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'image' => 'mimes:png,jpg,jpeg,webp|file',
            'gender' => 'required',
            'address' => 'required'
        ])->validate();
    }

    //TODO request form(user) data
    private function requestUserData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
            'updated_at' => Carbon::now()
        ];
    }
}
