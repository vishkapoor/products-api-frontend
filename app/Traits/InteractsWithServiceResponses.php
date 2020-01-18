<?php

namespace App\Traits;

trait InteractsWithServiceResponses
{
	public function decodeResponse($response) 
	{
		$decodedResponse = json_decode($response);

		if(isset($decodedResponse->data->data)) {
			return $decodedResponse->data->data;
		}
		return $decodedResponse->data ?? $decodedResponse;
	}
	/**
	 * Resolve when request failed
	 */
	public function checkIfErrorResponse($response) 
	{
		if (isset($response->error)) {
			throw new \Exception('Something failed:' . $response->error);
		}
	}
}