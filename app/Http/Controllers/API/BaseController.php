<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'status' => true,
            'message' => $message,
            'data'    => $result,
        ];


        //return response()->json($response, 200);
        return response()->json($response, 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 401)
    {
        $response = [
            'status' => false,
            'message' => $error,
            'data' => $errorMessages
        ];


        return response()->json($response, $code);
    }

}
