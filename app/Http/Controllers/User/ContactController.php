<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;


class ContactController extends Controller
{
    public function goToContactCreatePage() {
        return view('user.contact.create');
    }

    public function createContact(Request $request) {
        Validator::make($request->all(), [
            'contactMessage' => 'required|min:10'
        ])->validate();

        Contact::create([
            'name' => $request->contactName,
            'email' => $request->contactEmail,
            'message' => $request->contactMessage
        ]);

        return redirect()->route('user#contact#goToCreatePage')->with([
            'success' => 'Your Message has been sent to the admins of this web page.'
        ]);
    }
}
