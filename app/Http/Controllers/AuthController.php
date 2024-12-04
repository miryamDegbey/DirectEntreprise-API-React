<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Interfaces\AuthInterface;
use App\Models\User;
use App\Resources\UserRessouce;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class AuthController extends Controller
{

    private AuthInterface $authInterface;

    public function __construct(AuthInterface $authInterface)
    {
        $this->authInterface = $authInterface;
    }

    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        DB::beginTransaction();
        try {
            $user = $this->authInterface->Login($data);

            DB::commit();

            if (!$user) {
                return ApiResponse::sendResponse(
                    // true, 
                    // [new UserResource($user)], 
                    // 'Connexion réussie.', 
                    // 201
                    $user,
                    [],
                    'Information de connexion incorrect.',
                    201
                );
            }

            return ApiResponse::sendResponse(
                // true, 
                // [new UserResource($user)], 
                // 'Connexion réussie.', 
                // 201
                $user,
                [],
                'Connexion réussie.',
                200
            );
        } catch (\Throwable $th) {
            // return $th;
            return ApiResponse::rollback($th);
        }
    }

    public function register(RegisterRequest $request)
    {
        $data = [
            'name' => $request->name,
            'firstname' => $request->firstname,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => $request->password,
        ];

        DB::beginTransaction();
        try {
            $user = $this->authInterface->Register($data);

            DB::commit();

            return ApiResponse::sendResponse(
                true,
                $user,
                // [new UserResource($user)], 
                'Opération effectuée.',
                201
            );
        } catch (\Throwable $th) {
            return $th;
            return ApiResponse::rollback($th);
        }
    }



    public function checkOtpCode(Request $request)
    {
        $data = [
            'email' => $request->email,
            'code' => $request->code,
        ];

        DB::beginTransaction();
        try {
            $user = $this->authInterface->checkOtpCode($data);

            if (!$user) {
                return ApiResponse::sendResponse(
                    // true, 
                    // [new UserResource($user)], 
                    // 'Connexion réussie.', 
                    // 201
                    false,
                    [],
                    'Code confirmation invalide.',
                    $user ? 200 : 401
                );
            }

            return ApiResponse::sendResponse(
                true,
                [new UserRessouce($user)],
                'Opération effettuee.',
                $user ? 200 : 401
            );

            DB::commit();
        } catch (\Throwable $th) {
            return $th;
            return ApiResponse::rollback($th);
        }
    }
}
