<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderList;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserManagementController extends Controller
{
    //TODO go to admin/userManagement/list.blade.php
    public function goToUserListPage() {
        $users = User::where('role', '=', 'user')->paginate(3);
        return view('admin.userManagement.list', compact('users'));
    }

    //TODO change user role
    public function changeUserRole(Request $request) {
        logger($request);
        User::where('id', '=', $request->userId)->update([
            'role' => $request->userRole
        ]);

        return response()->json([
            'status' => 'success'
        ], 200);
    }

    //TODO go to admin/userManagement/updateUser.blade.php
    public function goToUserUpdatePage($id) {
        $user = User::where('id', '=', $id)->first();
        return view('admin.userManagement.updateUser', compact('user'));
    }

    //TODO update the user
    public function updateUser(Request $request) {
        Validator::make($request->all(), [
            'userName' => 'required|min:5|unique:products,name,'.$request->userName,
            'userEmail' => 'required',
            'userPhone' => 'required|min:9',
            'userAddress' => 'required|min:3',
            'userImage' => 'mimes:png,jpg,jpeg,avif|file'
        ])->validate();

        $data = [
            'name' => $request->userName,
            'email' => $request->userEmail,
            'phone' => $request->userPhone,
            'address' => $request->userAddress,
            'role' => $request->userRole,
            'updated_at' => Carbon::now()
        ];

        if ($request->hasFile('userImage')) {
            $oldImageName = User::where('id', '=', $request->userId)->first();
            $oldImageName = $oldImageName->image;

            if ($oldImageName != NULL) {
                Storage::delete('public/' . $oldImageName);
            }

            $fileName = uniqid() . '_meowveloper_' . $request->file('userImage')->getClientOriginalName();

            $request->file('userImage')->storeAs('public', $fileName);

            $data['image'] = $fileName;
        }
        User::where('id', '=', $request->userId)->update($data);

        return redirect()->route('admin#userManagement#goToListPage')->with(['success' => 'The user with the user ID '. $request->userId. ' has been successfully updated.']);
    }

    //TODO delete the user
    public function deleteUser($id) {
        User::where('id', '=', $id)->delete();
        Order::where('user_id', '=', $id)->delete();
        OrderList::where('user_id', '=', $id)->delete();
        return redirect()->route('admin#userManagement#goToListPage')->with(['success' => 'The user with the user ID ' . $id . ' has been successfully deleted.']);
    }
}
