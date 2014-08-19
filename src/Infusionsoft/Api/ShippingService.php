<?php

namespace Infusionsoft\Api;

class ShippingService extends AbstractApi {

	/**
	 * @return mixed
	 */
	public function getAllShippingOptions()
	{
		return $this->client->request($this->method());
	}

	/**
	 * @param integer $optionId
	 * @return mixed
	 */
	public function getFlatRateShippingOption($optionId)
	{
		return $this->client->request($this->method(), $optionId);
	}

	/**
	 * @param integer $optionId
	 * @return mixed
	 */
	public function getOrderTotalShippingOption($optionId)
	{
		return $this->client->request($this->method(), $optionId);
	}

	/**
	 * @param integer $optionId
	 * @return mixed
	 */
	public function getOrderTotalShippingRanges($optionId)
	{
		return $this->client->request($this->method(), $optionId);
	}

	/**
	 * @param integer $optionId
	 * @return mixed
	 */
	public function getProductBasedShippingOption($optionId)
	{
		return $this->client->request($this->method(), $optionId);
	}

	/**
	 * @param integer $optionId
	 * @return mixed
	 */
	public function getOrderQuantityShippingOption($optionId)
	{
		return $this->client->request($this->method(), $optionId);
	}

	/**
	 * @param integer $optionId
	 * @return mixed
	 */
	public function getWeightBasedShippingOption($optionId)
	{
		return $this->client->request($this->method(), $optionId);
	}

	/**
	 * @param integer $optionId
	 * @return mixed
	 */
	public function getUpsShippingOption($optionId)
	{
		return $this->client->request($this->method(), $optionId);
	}

}