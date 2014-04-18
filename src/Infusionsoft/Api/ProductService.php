<?php

namespace Infusionsoft\Api;

class ProductService extends AbstractApi {

	/**
	 * @param integer $productId
	 * @return {{return}}
	 */
	public function getInventory($productId)
	{
		return $this->client->request($this->method(), $productId);
	}

	/**
	 * @param integer $productId
	 * @return {{return}}
	 */
	public function incrementInventory($productId)
	{
		return $this->client->request($this->method(), $productId);
	}

	/**
	 * @param integer $productId
	 * @return {{return}}
	 */
	public function decrementInventory($productId)
	{
		return $this->client->request($this->method(), $productId);
	}

	/**
	 * @param integer $productId
	 * @param integer $quantity
	 * @return {{return}}
	 */
	public function increaseInventory($productId, $quantity)
	{
		return $this->client->request($this->method(), $productId, $quantity);
	}

	/**
	 * @param integer $productId
	 * @param integer $quantity
	 * @return {{return}}
	 */
	public function decreaseInventory($productId, $quantity)
	{
		return $this->client->request($this->method(), $productId, $quantity);
	}

	/**
	 * @param integer $creditCardId
	 * @return {{return}}
	 */
	public function deactivateCreditCard($creditCardId)
	{
		return $this->client->request($this->method(), $creditCardId);
	}

}