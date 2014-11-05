<?php

namespace Infusionsoft\Api;

class ShippingService extends AbstractApi {

	/**
	 * @return mixed
	 */
	public function getAllShippingOptions()
	{
		return $this->client->request('ShippingService.getAllShippingOptions');
	}

	/**
	 * @param integer $optionId
	 * @return mixed
	 */
	public function getFlatRateShippingOption($optionId)
	{
		return $this->client->request('ShippingService.getFlatRateShippingOption', $optionId);
	}

	/**
	 * @param integer $optionId
	 * @return mixed
	 */
	public function getOrderTotalShippingOption($optionId)
	{
		return $this->client->request('ShippingService.getOrderTotalShippingOption', $optionId);
	}

	/**
	 * @param integer $optionId
	 * @return mixed
	 */
	public function getOrderTotalShippingRanges($optionId)
	{
		return $this->client->request('ShippingService.getOrderTotalShippingRanges', $optionId);
	}

	/**
	 * @param integer $optionId
	 * @return mixed
	 */
	public function getProductBasedShippingOption($optionId)
	{
		return $this->client->request('ShippingService.getProductBasedShippingOption', $optionId);
	}

	/**
	 * @param integer $optionId
	 * @return mixed
	 */
	public function getOrderQuantityShippingOption($optionId)
	{
		return $this->client->request('ShippingService.getOrderQuantityShippingOption', $optionId);
	}

	/**
	 * @param integer $optionId
	 * @return mixed
	 */
	public function getWeightBasedShippingOption($optionId)
	{
		return $this->client->request('ShippingService.getWeightBasedShippingOption', $optionId);
	}

	/**
	 * @param integer $optionId
	 * @return mixed
	 */
	public function getUpsShippingOption($optionId)
	{
		return $this->client->request('ShippingService.getUpsShippingOption', $optionId);
	}

}