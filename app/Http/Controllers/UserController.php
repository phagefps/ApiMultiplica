<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request, $token)
    {
        return view('users', ['token' => $token, 'page' => $request->page]);
    }

    public function show($token, $client_id)
    {
        return view('usersInformation', ['token' => $token, 'client_id' => $client_id]);
    }
}
