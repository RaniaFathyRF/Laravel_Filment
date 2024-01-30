<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserRefreshToken;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;

class LogoutController extends Controller
{
    use ApiResponse;

    public function execute(Request $request)
    {
        try {
            auth('api')->logout();
            auth('api')->invalidate();

            $requestRefreshToken = $request->bearerToken();
            if ($requestRefreshToken) {

                $refreshTokenItem = UserRefreshToken::where('token', $requestRefreshToken)->first();
                if($refreshTokenItem) $refreshTokenItem->delete();

                return $this->ResponseSuccess(data: [], message: __("auth.logout_success"));
            }
            return $this->ResponseFail(error: ["token"=>__("auth.invalid_token")], statusCode: 401);
        } catch (JWTException $e) {
            Log::error("error in jwt logout api",[$e->getMessage()]);
            return $this->ResponseFail(error: ["user"=> __("auth.unauthorized")], statusCode: 401);
        }
    }
}
