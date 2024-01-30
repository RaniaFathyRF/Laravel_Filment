<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserRefreshToken;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Traits\ApiResponse;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{

    use ApiResponse;

    public function execute(AuthLoginRequest $request)
    {
        $credentials = $request->validated();
        try {
            if (!$token = auth('api')->attempt($credentials)) {
                return $this->ResponseFail(error: ["user" => __("auth.wrong_username_or_password")], statusCode: 422);
            }
            $user = auth('api')->user();
            $user['token'] = $token;
            UserRefreshToken::updateOrCreate(
                ['user_id' => $user['id']],
                ['token' => $token]
            );

            return $this->ResponseSuccess(
                data: [
                    "user" => $user
                ],
                message: __("auth.login_successfull")
            );
        } catch (JWTException $e) {
            Log::error("error in jwt login api", [$e->getMessage()]);
            return $this->ResponseFail(error: ["user" => __("auth.server_could_not_create_token")], statusCode: 500);
        }
    }
}
