<?php

namespace App\Http\Controllers;
/**
 * @OA\Info(
 *    title="Conecta Salud API Documentation",
 *    version="1.0.0",
 * )
 * @OA\PathItem(path="/api")
**  
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
abstract class Controller
{
    //
}
