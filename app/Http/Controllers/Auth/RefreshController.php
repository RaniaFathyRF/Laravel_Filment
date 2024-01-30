<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserRefreshToken;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;


class RefreshController extends Controller
{
    use ApiResponse;

    public function execute(Request $request)
    {
        //todo: mohammed code redundant in try catch with TokenExpiredException
        //Not workin :(
        try {
            $user = auth('api')->user();
            $token = auth('api')->refresh();
            auth('api')->setToken($token)->user();

            $user['token'] = $token;
            UserRefreshToken::where('user_id', $user['id'])->update(["token" => $token]);

            return $this->ResponseSuccess(data: ["user" => $user], message: __("auth.token_refreshed_success"));
        } catch (Exception $e) {
            Log::error("error in jwt refresh api", [$e->getMessage()]);
            if ($e instanceof TokenInvalidException) {

                return $this->ResponseFail(error: ["token" => __("auth.invalid_token")], statusCode: 401);
            } else if ($e instanceof TokenExpiredException) {
                $requestRefreshToken = $request->bearerToken();

                if ($requestRefreshToken) {
                    $refreshTokenItem = UserRefreshToken::where('token', $requestRefreshToken)->first();

                    $token = auth('api')->tokenById($refreshTokenItem->user_id);

                    $refreshTokenItem->update(['token' => $token]);

                    $user['token'] = $token;
                    return $this->ResponseSuccess(data: ["user" => $user], message: __("auth.token_refreshed_success"));
                }
                return $this->ResponseFail(error: ["token" => __("auth.invalid_token")], statusCode: 401);
            } else {
                return $this->ResponseFail(error: ["token" => __("auth.token_not_found")], statusCode: 401);
            }
        }
    }
}
