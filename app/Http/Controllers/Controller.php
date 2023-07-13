<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(title="Documentation Laravel App Abdul Goffar", version="1.0")
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
