<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Validator\Validate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 *   @OA\SecurityScheme(
 *       type="http",
 *       description=" Use /auth to get the JWT token",
 *       name="Authorization",
 *       in="header",
 *       scheme="bearer",
 *       bearerFormat="JWT",
 *       securityScheme="bearerAuthP",
 *   )
 */
class ProductController extends Controller
{



    /**
     * @OA\Get(
     *     path="/api/products",
     *     tags={"product"},
     *     security={ {"bearerAuthP":{}}},
     *     operationId="get all product",
     *      @OA\Response(
     *         response="200",
     *         description="OK",
     *         content={
     *            @OA\MediaType(
     *                mediaType="application/json",
     *                @OA\Schema(
     *                   @OA\Property(
     *                   property="current_page",
     *                   description="current_page",
     *                   type="int",
     *                   example="1"
     *                   ),
     *                   @OA\Property(
     *                   property="data",
     *                   description="data",
     *                   type="string",
     *                   example="[]"
     *                   ),
     *                  @OA\Property(
     *                   property="first_page_url",
     *                   description="first_page_url",
     *                   type="string",
     *                   example=  "http:\/\/127.0.0.1:8000\/api\/categories?page=1"
     *                   ),
     *                  @OA\Property(
     *                   property="from",
     *                   description="from",
     *                   type="string",
     *                   example="null"
     *                   ),
     *                  @OA\Property(
     *                   property="last_page",
     *                   description="last_page",
     *                   type="int",
     *                   example="3"
     *                   ),
     *                  @OA\Property(
     *                   property="last_page_url",
     *                   description="last_page_url",
     *                   type="string",
     *                   example= "http:\/\/127.0.0.1:8000\/api\/categories?page=3"
     *                   ),
     *                  @OA\Property(
     *                   property="links",
     *                   description="links",
     *                   type="string",
     *                   example="[]"
     *                   ),
     *                  @OA\Property(
     *                   property="next_page_url",
     *                   description="next_page_url",
     *                   type="string",
     *                   example="null"
     *                   ),
     *                  @OA\Property(
     *                   property="path",
     *                   description="path",
     *                   type="string",
     *                   example="null"
     *                   ),
     *                  @OA\Property(
     *                   property="per_page",
     *                   description="per_page",
     *                   type="int",
     *                   example="4"
     *                   ),
     *                  @OA\Property(
     *                   property="prev_page_url",
     *                   description="prev_page_url",
     *                   type="string",
     *                   example="null"
     *                   ),
     *                  @OA\Property(
     *                   property="to",
     *                   description="to",
     *                   type="string",
     *                   example="null"
     *                   ),
     *                  @OA\Property(
     *                   property="total",
     *                   description="total",
     *                   type="int",
     *                   example="7"
     *                   ),
     *                 )
     *             )
     *         }
     *     ),
     *       @OA\Response(
     *         response="401",
     *         description="Unauthenticated"
     *        ),
     * )
     */
    public function index(): JsonResponse
    {
        $products = Product::paginate();
        return response()->json($products, 200, ["Content-Type" => "application/json"]);
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     tags={"product"},
     *     security={ {"bearerAuthP":{}}},
     *     operationId="get product by id",
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
     *                   example="12"
     *                   ),
     *                   @OA\Property(
     *                   property="name",
     *                   description="name",
     *                   type="string",
     *                   example="jacket laki-laki"
     *                   ),
     *                  @OA\Property(
     *                   property="category",
     *                   description="category",
     *                   type="int",
     *                   example="12"
     *                   ),
     *                  @OA\Property(
     *                   property="price",
     *                   description="price",
     *                   type="int",
     *                   example="120000"
     *                   ),
     *                  @OA\Property(
     *                   property="stock",
     *                   description="stock",
     *                   type="int",
     *                   example="13452"
     *                   ),
     *                  @OA\Property(
     *                   property="deleted_at",
     *                   description="deleted_at",
     *                   type="string",
     *                   example="2023-07-13T10:10:44.000000Z"
     *                   ),
     *                  @OA\Property(
     *                   property="updated_at",
     *                   description="updated_at",
     *                   type="string",
     *                   example="2023-07-13T10:10:44.000000Z"
     *                   ),
     *                 )
     *             )
     *         }
     *     ),
     *       @OA\Response(
     *         response="401",
     *         description="Unauthenticated"
     *        ),
     * )
     */
    public function getById($id): JsonResponse
    {
        $product =  Product::find($id);
        if (empty($product)) throw new NotFoundHttpException();

        return response()->json($product, 200, ["Content-Type" => "application/json"]);
    }


    public function create()
    {
        //
    }



    /**
     * @OA\Post(
     *     path="/api/products",
     *     tags={"product"},
     *     security={ {"bearerAuthP":{}}},
     *     operationId="post data product",
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
     *                   example="jacket laki-laki"
     *               ),
     *               @OA\Property(
     *                   property="category",
     *                   description="category",
     *                   type="int",
     *                   example="12"
     *               ),
     *              @OA\Property(
     *                   property="price",
     *                   description="price",
     *                   type="int",
     *                   example="120000"
     *                ),
     *               @OA\Property(
     *                   property="stock",
     *                   description="stock",
     *                   type="int",
     *                   example="13452"
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
     *                   @OA\Property(
     *                   property="name",
     *                   description="name",
     *                   type="string",
     *                   example="jacket laki-laki"
     *                   ),
     *                  @OA\Property(
     *                   property="category",
     *                   description="category",
     *                   type="int",
     *                   example="12"
     *                   ),
     *                  @OA\Property(
     *                   property="price",
     *                   description="price",
     *                   type="int",
     *                   example="120000"
     *                   ),
     *                  @OA\Property(
     *                   property="stock",
     *                   description="stock",
     *                   type="int",
     *                   example="13452"
     *                   ),
     *                 )
     *             )
     *         }
     *     ),
     *       @OA\Response(
     *         response="401",
     *         description="Unauthenticated"
     *        ),
     *       @OA\Response(
     *         response="422",
     *         description="Data Invalid"
     *        ),
     * )
     */
    public function store(Request $request)
    {

        return Validate::validCreate(
            $request,
            [
                'name' => 'required | string | min:3 | max:20',
                'category' => 'required | Numeric',
                'price' => 'required | Numeric',
                'stock' => 'required | Numeric'
            ],
            ['name', 'category', 'price', 'stock'],
            Product::class,
            [Category::class]
        );
    }

    /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     tags={"product"},
     *     security={ {"bearerAuthP":{}}},
     *     operationId="put data product",
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
     *                   example="celana laki-laki"
     *               ),
     *               @OA\Property(
     *                   property="category",
     *                   description="category",
     *                   type="int",
     *                   example="34"
     *               ),
     *              @OA\Property(
     *                   property="price",
     *                   description="price",
     *                   type="int",
     *                   example="340000"
     *                ),
     *               @OA\Property(
     *                   property="stock",
     *                   description="stock",
     *                   type="int",
     *                   example="13452"
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
     *                   @OA\Property(
     *                   property="name",
     *                   description="name",
     *                   type="string",
     *                   example="celana laki-laki"
     *                   ),
     *                  @OA\Property(
     *                   property="category",
     *                   description="category",
     *                   type="int",
     *                   example="34"
     *                   ),
     *                  @OA\Property(
     *                   property="price",
     *                   description="price",
     *                   type="int",
     *                   example="340000"
     *                   ),
     *                  @OA\Property(
     *                   property="stock",
     *                   description="stock",
     *                   type="int",
     *                   example="13452"
     *                   ),
     *                 )
     *             )
     *         }
     *     ),
     *       @OA\Response(
     *         response="401",
     *         description="Unauthenticated"
     *        ),
     *       @OA\Response(
     *         response="422",
     *         description="Data Invalid"
     *        ),
     * )
     */
    public function updateById($id, Request $request)
    {

        $product =  Product::find($id);
        if (empty($product)) throw new NotFoundHttpException();

        return Validate::validUpdate(
            $id,
            $request,
            [
                'name' => 'required | string | min:3 | max:20',
                'category' => 'required | Numeric',
                'price' => 'required | Numeric',
                'stock' => 'required | Numeric'
            ],
            ['name', 'category', 'price', 'stock'],
            Product::class,
            [Category::class]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     tags={"product"},
     *     security={ {"bearerAuthP":{}}},
     *     operationId="delete data product",
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
     *     ),
     *       @OA\Response(
     *         response="401",
     *         description="Unauthenticated"
     *        ),
     * )
     */
    public function destroy($id): JsonResponse
    {
        $product =  Product::find($id);
        if (empty($product)) throw new NotFoundHttpException();
        $product = Product::find($id)->delete();
        return response()->json(["status" => "OK"], 200, ["Content-Type" => "application/json"]);
    }
}
