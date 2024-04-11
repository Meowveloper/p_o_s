<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //TODO go to admin/account/changePassword.blade.php
    public function goToAdminPasswordChangePage()
    {
        return view('admin.account.changePassword');
    }
    //*************************** */

    //TODO change password
    public function changePassword(Request $request)
    {

        $this->changePasswordValidationCheck($request);


        $currentUser = User::where('id', '=', Auth::user()->id)->first();
        $dbHashedPassword = $currentUser->password;

        if (Hash::check($request->oldPassword, $dbHashedPassword)) {

            User::where('id', '=', Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);

            // Auth::logout();

            return redirect()->route('admin#goToAdminPasswordChangePage')->with([
                'success' => 'Password changed successfully..'
            ]);
        } else {
            return redirect()->route('admin#goToAdminPasswordChangePage')->with([
                'notMatch' => 'Old Password is incorrect. Relax, sit back and try to remember your password...'
            ]);
        }
    }
    //****************************************** */

    // TODO go to admin/account/details.blade.php
    public function goToAdminAccountDetailsPage()
    {
        return view('admin.account.details');
    }
    //******************************** */


    //TODO go to admin/account/edit.blade.php
    public function goToAdminAccountEditPage()
    {
        return view('admin.account.edit');
    }
    //************************************ */

    //TODO update admin account details
    public function updateAdminAccount($id, Request $request)
    {
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
        return redirect()->route('admin#goToAdminAccountDetailsPage')->with(['adminAccountUpdateSuccess' => 'Your account information has been updated successfully...']);
    }

    //TODO go to admin/account/list.blade.php
    public function goToAdminAccountsListPage()
    {
        $admins = User::when(request('key'), function ($query) {
            $query->orWhere('name', 'like', '%' . request('key') . '%')
                ->orWhere('gender', '=', request('key'))
                ->orWhere('email', 'like', '%' . request('key') . '%')
                ->orWhere('phone', 'like', '%' . request('key') . '%')
                ->orWhere('address', 'like', '%' . request('key') . '%');
        })->where('role', '=', 'admin')->paginate(3);

        $admins->appends(request()->all());
        return view('admin.account.list', compact('admins'));
    }

    //TODO delete an admin's account (other than self)
    public function deleteAnAdminAccount($id)
    {
        User::where('id', '=', $id)->delete();
        return redirect()->route('admin#goToAdminAccountsListPage')->with([
            'anAdminAcountDeleted' => 'Successfully deleted an admin account..'
        ]);
    }

    //TODO go to admin/account/changeRole.blade.php
    public function goToChangeRolePage($id) {
        $account = User::where('id', '=', $id)->first();
        return view('admin.account.changeRole', compact('account'));
    }


    public function changeARole(Request $request, $id) {
        User::where('id', '=', $id)->update(['role' => $request->role]);
        return redirect()->route('admin#goToAdminAccountsListPage');
    }


    //************* private functions **************** */


    //TODO change password validation check
    private function changePasswordValidationCheck($request)
    {
        Validator::make($request->all(), [
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6|max:15',
            'confirmPassword' => 'required|min:6|max:15|same:newPassword'
        ])->validate();
    }

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
