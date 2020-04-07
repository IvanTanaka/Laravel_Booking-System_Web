<?php

namespace App\Helpers;

function api_response(bool $success, int $code, String $message, $response = []){
    return response()->json(
        [
            'success' => $success,
            'code' => $code,
            'message' => $message, 
            'result' => $response
        ], $code
    );
}