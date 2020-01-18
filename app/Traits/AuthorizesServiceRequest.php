<?php

namespace App\Traits;

use App\Services\MarketAuthenticationService;

trait AuthorizesServiceRequest
{
	public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
	{
		$accessToken = $this->resolveAccessToken();

		$headers['Authorization'] = $accessToken;
	}

	public function resolveAccessToken()
	{
        $authenticatedService = resolve(MarketAuthenticationService::class);

        if(auth()->user()) {
        	return $authenticatedService->getAuthenticatedUserToken();
        }

		return $authenticatedService->getClientCredentialsToken();
	}

}