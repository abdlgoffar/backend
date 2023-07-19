<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 *   @OA\SecurityScheme(
 *       type="http",
 *       description=" Use /auth to get the JWT token",
 *       name="Authorization",
 *       in="header",
 *       scheme="bearer",
 *       bearerFormat="JWT",
 *       securityScheme="bearerAuth",
 *   )
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth",
     *     tags={"user"},
     *     description="auth or login",
     *     operationId="auth user",
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *              type="object",
     *               @OA\Property(
     *                   property="email",
     *                   description="email",
     *                   type="string",
     *                   example="abd@gmail.com"
     *               ),
     *               @OA\Property(
     *                   property="password",
     *                   description="password",
     *                   type="string",
     *                   example="abd goffar 12345"
     *               ),
     *            )
     *         )
     *      ),
     *      @OA\Response(
     *         response="200",
     *         description="OK",
     *         content={
     *            @OA\MediaType(
     *                mediaType="application/json",
     *                @OA\Schema(
     *               @OA\Property(
     *                   property="token",
     *                   description="token",
     *                   type="string",
     *                   example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vZXhhbXBsZS5vcmciLCJhdWQiOiJodHRwOi8vZXhhbXBsZS5jb20iLCJpYXQiOjE2ODkyNzI5MzAsImV4cCI6MTY4OTg3NzczMH0.SE94w_fKpAqAmPnnWsR5FCq9CvGWa0ecgDnsrO4_DD0"
     *               ),
     *                 )
     *             )
     *         }
     *       ),
     *       @OA\Response(
     *         response="401",
     *         description="Unauthenticated"
     *        ),
     *      )
     */
    public function auth(Request $request): JsonResponse
    {
        $key = 'hfu58588ywehgddhr8r7488hgrig2996e3rd1w4gydh4h8t85921hdbve33w132as1425sv3dvud09h70jn948bf5s7dbcjnkmzoaolskkdeu6490i92';
        $payload = [
            'iss' => 'http://example.org',
            'aud' => 'http://example.com',
            'iat' => time(),
            'exp' => time() + 604800
        ];


        if (Auth::Attempt(["email" => $request->email, "password" => $request->password])) {

            $token = JWT::encode($payload, $key, 'HS256');

            $user = DB::table('users')->where('email', $request->email)->update(['jwt_token' => $token]);

            return response()->json(["token" => $token], 200, ["Content-Type" => "application/json"]);
        }

        throw new AuthenticationException();
    }

    /**
     * @OA\Get(
     *     path="/api/logout",
     *     tags={"user"},
     *     security={ {"bearerAuth":{}}},
     *     operationId="delete token or log out",
     *      @OA\Response(
     *         response="200",
     *         description="OK",
     *         content={
     *            @OA\MediaType(
     *                mediaType="application/json",
     *                @OA\Schema(
     *                   @OA\Property(
     *                   property="status",
     *                   type="string",
     *                   example="OK"
     *                 )
     *             )
     *           )
     *         }
     *     )
     * )
     */
    public function logOut(Request $request): JsonResponse
    {
        $header = $request->header("authorization");
        $token = explode(" ", $header);

        DB::table('users')
            ->where('jwt_token', end($token))
            ->update(['jwt_token' => " "]);

        return response()->json(["status" => "OK"], 200, ["Content-Type" => "application/json"]);
    }
}
