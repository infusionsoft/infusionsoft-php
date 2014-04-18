<?php

namespace Infusionsoft\Api;

class ShippingService extends AbstractApi {

	/**
	 * @return {{return}}
	 */
	public function getAllShippingOptions()
	{
		return $this->client->request($this->method());
	}

	/**
	 * @param integer $optionId
	 * @return {{return}}
	 */
	public function getFlatRateShippingOption($optionId)
	{
		return $this->client->request($this->method(), $optionId);
	}

	/**
	 * @param integer $optionId
	 * @return {{return}}
	 */
	public function getOrderTotalShippingOption($optionId)
	{
		return $this->client->request($this->method(), $optionId);
	}

	/**
	 * @param integer $optionId
	 * @return {{return}}
	 */
	public function getOrderTotalShippingRanges($optionId)
	{
		return $this->client->request($this->method(), $optionId);
	}

	/**
	 * @param integer $optionId
	 * @return {{return}}
	 */
	public function getProductBasedShippingOption($optionId)
	{
		return $this->client->request($this->method(), $optionId);
	}

	/**
	 * @param integer $optionId
	 * @return {{return}}
	 */
	public function getOrderQuantityShippingOption($optionId)
	{
		return $this->client->request($this->method(), $optionId);
	}

	/**
	 * @param integer $optionId
	 * @return {{return}}
	 */
	public function getWeightBasedShippingOption($optionId)
	{
		return $this->client->request($this->method(), $optionId);
	}

	/**
	 * @param integer $optionId
	 * @return {{return}}
	 */
	public function getUpsShippingOption($optionId)
	{
		return $this->client->request($this->method(), $optionId);
	}

}