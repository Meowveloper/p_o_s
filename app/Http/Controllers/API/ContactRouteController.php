<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContactRouteController extends Controller
{
    public function postCreate(Request $request) {

        $response = Contact::create([
            "name" => $request->name,
            "email" => $request->email,
            "description" => $request->description,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ]);

        return response()->json($response, 200);
    }
}
