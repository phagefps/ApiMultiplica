<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\System;
use Illuminate\Http\Request;
use App\Http\Resources\V1\TransactionResource;

class TransactionController extends Controller
{
    /**
    * @OA\Get(
    *     path="/api/users/{token}/transactions/{client_id}",
    *     tags={"TRANSACTIONS"},
    *     summary="Muestra todas las transacciones de un usuario",
    *     @OA\Parameter(
    *         description="Parameter",
    *         in="path",
    *         name="token",
    *         required=true,
    *         @OA\Schema(type="string"),
    *     ),
    *     @OA\Parameter(
    *         description="Parameter",
    *         in="path",
    *         name="client_id",
    *         required=true,
    *         @OA\Schema(type="integer"),
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Muestra todas las transacciones de un usuario de manera descendente y paginación."
    *     ),
    *     @OA\Response(
    *         response=401,
    *         description="Token incorrecto o cliente no existente."
    *     )
    * )
    */
    public function index($token, $client_id)
    {
        if(System::firstWhere('token', $token)) {
            if(User::find($client_id)) {
                return TransactionResource::collection(User::find($client_id)->transactions()->orderBy('created_at', 'desc')->paginate(10));
            } else {
                return response()->json(['error' => 'Cliente no existente.'], 401);
            }
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
    public function show(Transaction $transaction)
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
