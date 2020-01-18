<?php

namespace App\Services;

use App\Traits\AuthorizesServiceRequest;
use App\Traits\ConsumesExternalServices;
use App\Traits\InteractsWithServiceResponses;

class MarketService
{
	use ConsumesExternalServices;
	use AuthorizesServiceRequest;
	use InteractsWithServiceResponses;

	protected $baseUri;

	function __construct()
	{
		$this->baseUri = config('services.market.base_uri');
	}

	public function getProducts()
	{
		return $this->makeRequest('GET', 'products');
	}

	public function getProduct($id)
	{
		return $this->makeRequest('GET', 'products/' .  $id);
	}

	public function getCategories()
	{
		return $this->makeRequest('GET', 'categories');
	}

	public function getCategoryProducts($id)
	{
		return $this->makeRequest('GET', 'categories/' . $id . "/products");
	}

	public function getUserInformation()
	{
		return $this->makeRequest('GET', 'user');
	}

	/**
	 * Createa new product
	 * @return stdClass
	 */
	public function createProduct($sellerId, $data)
	{
		return $this->makeRequest(
			'POST',
			'sellers/' . $sellerId . '/products',
			[],
			$data,
			[],
			$hasFile = true
		);
	}

	/**
	 * Associate product to a category
	 * @return stdClass
	 */
	public function setProductCategory($productId, $categoryId)
	{
		$this->makeRequest(
			'PUT',
			'products/' . $productId . '/categories/' . $categoryId
		);
	}

	/**
	 * Updates an existing product
	 * @return stdClass
	 */
	public function updateProduct($sellerId, $productId, $productData)
	{

		$productData['_method'] = 'PUT';

		return $this->makeRequest(
			'POST',
			'sellers/' . $sellerId . '/products/' . $productId,
			[],
			$productData,
			[],
			$hasFile = isset($productData['picture'])
		);
	}

	/**
	 * Allows purchase product
	 * @return stdClass
	 */
	public function purchaseProduct($productId, $buyerId, $quantity)
	{
		return $this->makeRequest(
			'POST',
			'products/' . $productId . '/buyers/' . $buyerId . '/transactions',
			[],
			['quantity' => $quantity]
		);
	}

	/**
	 * Obtains the list of products for logged in user
	 * @return stdClass
	 */
	public function getPurchases($buyerId)
	{
		return $this->makeRequest(
			'GET',
			'buyers/' . $buyerId . '/products'
		);
	}

	/**
	 * Obtains the publications for a user
	 * @return stdClass
	 */
	public function getUserProducts($sellerId)
	{
		return $this->makeRequest(
			'GET',
			'sellers/' . $sellerId . '/products'
		);
	}

}