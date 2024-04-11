<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function goToListPage() {
        $contacts = Contact::get();
        return view('admin.contact.list', compact('contacts'));
    }
}
