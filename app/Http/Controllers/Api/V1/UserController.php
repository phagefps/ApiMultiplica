<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\System;
use App\Models\Log;
use Illuminate\Http\Request;
use App\Http\Resources\V1\UserResource;
use App\Http\Resources\V1\UserInformationResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($token)
    {
        if(System::firstWhere('token', $token)) {
            return UserResource::collection(User::orderBy('created_at', 'desc')->paginate(10), $token);
        } else {
            return response()->json(['error' => 'Token incorrecto.'], 401);
        }
    }

    /**
     * Display a listing of the search.
     *
     * @return \Illuminate\Http\Response
     */
    public function search($token, $val_search)
    {
        if(System::firstWhere('token', $token)) {
            return UserResource::collection(User::where('id', 'like', "%{$val_search}%")->orWhere('name', 'like', "%{$val_search}%")->orWhere('email', 'like', "%{$val_search}%")->take(10)->get(), $token);
        } else {
            return response()->json(['error' => 'Token incorrecto.'], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $token, $client_id)
    {
        if(System::firstWhere('token', $token)) {
            function getIpInfo($ip = '') {
                $ipinfo = file_get_contents("https://ipinfo.io/" . $ip);
                $ipinfo_json = json_decode($ipinfo, true);
                return $ipinfo_json;
            }
            $ip = $request->ip();
            $ipinfo = getIpInfo($ip);
            Log::create(['token' => $token, 'user_id' => $client_id, 'ip' => $ip, 'isp' => (isset($ipinfo['org'])) ? $ipinfo['org'] : null, 'location' => (isset($ipinfo['country'])) ? $ipinfo['country'] : null]);
            
            return UserInformationResource::collection(User::where('id', $client_id)->with('transactions')->orderBy('created_at', 'desc')->get(), $token);
        } else {
            return response()->json(['error' => 'Token incorrecto.'], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
