<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request, $token, $client_id)
    {
        return view('transactions', ['token' => $token, 'client_id' => $client_id, 'page' => $request->page]);
    }
}
