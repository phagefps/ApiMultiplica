<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\System;
use App\Models\Log;
use Illuminate\Http\Request;
use App\Http\Resources\V1\UserResource;
use App\Http\Resources\V1\UserInformationResource;

/**
* @OA\Info(title="API Multiplica | Enrique Marrero", version="1.0")
*
* @OA\Server(url="http://apimultiplica.devel")
*/

class UserController extends Controller
{
    /**
    * @OA\Get(
    *     path="/api/users/{token}",
    *     tags={"USERS"},
    *     summary="Muestra usuarios y url para transacciones",
    *     @OA\Parameter(
    *         description="Parameter",
    *         in="path",
    *         name="token",
    *         required=true,
    *         @OA\Schema(type="string"),
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Muestra todos los usuarios de manera descendente, varias urls para visualizar las transacciones y paginación."
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
            return UserResource::collection(User::orderBy('created_at', 'desc')->paginate(10), $token);
        } else {
            return response()->json(['error' => 'Token incorrecto.'], 401);
        }
    }

    /**
    * @OA\Post(
    *     path="/api/users/{token}/search/{val_search}",
    *     tags={"USERS"},
    *     summary="Buscar a usuarios por su ID, Nombre o Email",
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
    *         name="val_search",
    *         required=true,
    *         @OA\Schema(type="string"),
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Muestra a los usuarios que coincidan, limite de 20."
    *     ),
    *     @OA\Response(
    *         response=401,
    *         description="Token incorrecto."
    *     )
    * )
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
    * @OA\Get(
    *     path="/api/users/{token}/{client_id}",
    *     tags={"USERS"},
    *     summary="Muestra a un usuario en específico.",
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
    *         description="Muestra a un usuario en específico junto a sus transacciones y registra en el log la visita al mismo."
    *     ),
    *     @OA\Response(
    *         response=401,
    *         description="Token incorrecto."
    *     )
    * )
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
