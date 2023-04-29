<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponses{

    /**
     * Format for successful responses
     * @param $data
     * @param $message
     * @param int $code
     * @return JsonResponse
     */
    protected function successResponse($data, $message = null, int $code = 200): JsonResponse
    {
		return response()->json([
			'status'=> 'Success',
			'message' => $message,
			'data'=>$data
		], $code);
	}

    /**
     * Format for error responses
     * @param $code
     * @param $message
     * @return JsonResponse
     */
	protected function errorResponse($code,$message = null): JsonResponse
    {
		return response()->json([
			'status'=>'Error',
			'message' => $message,
			'data' => null
		], $code);
	}

}
