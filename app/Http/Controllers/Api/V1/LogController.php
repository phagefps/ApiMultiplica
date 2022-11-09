<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\System;
use Illuminate\Http\Request;
use App\Http\Resources\V1\LogResource;

class LogController extends Controller
{
    /**
    * @OA\Get(
    *     path="/api/users/{token}/log",
    *     tags={"LOG"},
    *     summary="Muestra el log de todas las solicitudes a la ruta de buscar usuarios",
    *     @OA\Parameter(
    *         description="Parameter",
    *         in="path",
    *         name="token",
    *         required=true,
    *         @OA\Schema(type="string"),
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Muestra el log de todas las solicitudes a la ruta de buscar usuarios."
    *     ),
    *     @OA\Response(
    *         response=401,
    *         description="Token incorrecto."
    *     )
    * )
    */
    public function index($token)
    {
        if(System::firstWhere('token', $token)) {
            return LogResource::collection(Log::orderBy('created_at', 'desc')->take(20)->get());
        } else {
            return response()->json(['error' => 'Token incorrecto.'], 401);
        }
    }

    /**
     * Display a listing of the search.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
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
