<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Validator\Validate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

/**
 *   @OA\SecurityScheme(
 *       type="http",
 *       description=" Use /auth to get the JWT token",
 *       name="Authorization",
 *       in="header",
 *       scheme="bearer",
 *       bearerFormat="JWT",
 *       securityScheme="bearerAuthU",
 *   )
 */
class UserController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/users",
     *     tags={"user"},
     *     description="user registration",
     *     operationId="post data user",
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *              type="object",
     *               @OA\Property(
     *                   property="name",
     *                   description="name",
     *                   type="string",
     *                   example="abd goffar"
     *               ),
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
     * 
     *               @OA\Property(
     *                   property="name",
     *                   description="name",
     *                   type="string",
     *                   example="abd goffar"
     *               ),
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
     *                 )
     *             )
     *         }
     *     ),
     *       @OA\Response(
     *         response="422",
     *         description="Data Invalid"
     *        ),
     * )
     */
    public function register(Request $request): JsonResponse
    {
        return Validate::validCreate(
            $request,
            [
                'name' => 'required | string | min:3 | max:20',
                'email' => 'required | string | min:13 | max:20',
                'password' => 'required | string | min:13 | max:20'
            ],
            ['name', 'email', 'password'],
            User::class,
            []
        );
    }


    /**
     * @OA\Get(
     *     path="/api/users",
     *     tags={"user"},
     *     security={ {"bearerAuthU":{}}},
     *     description="get user data by token auth",
     *     operationId="get data user",
     *      @OA\Response(
     *         response="200",
     *         description="OK",
     *         content={
     *            @OA\MediaType(
     *                mediaType="application/json",
     *                @OA\Schema(
     *                   @OA\Property(
     *                   property="id",
     *                   description="id",
     *                   type="int",
     *                   example="123"
     *                   ),
     *               @OA\Property(
     *                   property="name",
     *                   description="name",
     *                   type="string",
     *                   example="abd goffar"
     *               ),
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
     *                 )
     *             )
     *         }
     *     ),
     *       @OA\Response(
     *         response="401",
     *         description="Unauthenticated"
     *        )
     * )
     */
    public function get(Request $request): JsonResponse
    {
        $header = $request->header("authorization");
        $token = explode(" ", $header);
        $user = DB::table('users')->where('jwt_token', end($token))->first();

        return response()->json($user, 200, ["Content-Type" => "application/json"]);
    }
}
