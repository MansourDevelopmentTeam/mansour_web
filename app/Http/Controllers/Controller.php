<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Resources\Json\JsonResource;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function jsonResponse($message = "", $data = null, $code = 200)
    {
    	return response()->json([
    		"code" => $code,
    		"message" => $message,
    		"data" => $data
    	], 200);
    }

    public function errorResponse($userMessage, $internalMessage, $moreInfo = "", $code = 400)
    {
    	return response()->json([
    		"code" => $code,
    		"message" => $userMessage,
    		"errors" => [
    			"errorMessage" => $internalMessage,
    			"errorDetails" => $moreInfo,
    		]
    	], 200);
    }

	/**
	 *  @param Illuminate\Http\Resources\Json\JsonResource $resource instance of JsonResource
	 */
	public function jsonResourceResponse($message = "", $resource = null, $code = 200)
	{
		if (!($resource instanceof JsonResource)) {
			return $this->errorResponse(__('Error happened. Try again later'), 'Invalid resource');
		}
		return ($resource)->additional([
			'code' => $code,
			'message' => $message
		]);
	}
}
