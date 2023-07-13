<?php

/**
 * @OA\SecurityScheme(
 *       type="http",
 *       description=" Use /auth to get the JWT token",
 *       name="Authorization",
 *       in="header",
 *       scheme="bearer",
 *       bearerFormat="JWT",
 *       securityScheme="bearerAuth",
 * )
 */
