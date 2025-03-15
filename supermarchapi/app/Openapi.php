<?php

namespace App;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="SmartShelf API",
 *     version="1.0",
 *     description="API documentation for the SmartShelf project",
 *     @OA\Contact(
 *         name="Nmissinadia",
 *         email="nmissinadia@gmail.com"
 *     )
 * )
 *
 * @OA\SecurityScheme(
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="bearerAuth"
 * )
 */
class OpenApi {}