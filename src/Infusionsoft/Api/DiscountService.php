<?php

namespace Infusionsoft\Api;

class DiscountService extends AbstractApi {

	/**
	 * @param string $name
	 * @param string $description
	 * @param integer $freeTrialDays
	 * @param integer $hidePrice
	 * @param integer $subscriptionPlanId
	 * @return integer
	 */
	public function addFreeTrial($name, $description, $freeTrialDays, $hidePrice, $subscriptionPlanId)
	{
		return $this->client->request('DiscountService.addFreeTrial', $name, $description, $freeTrialDays, $hidePrice, $subscriptionPlanId);
	}

	/**
	 * @param integer $trialId
	 * @return array
	 */
	public function getFreeTrial($trialId)
	{
		return $this->client->request('DiscountService.getFreeTrial', $trialId);
	}

	/**
	 * @param string $name
	 * @param string $description
	 * @param integer $applyDiscountToCommission
	 * @param integer $percentOrAmt
	 * @param integer $amt
	 * @param string $payType
	 * @return integer
	 */
	public function addOrderTotalDiscount($name, $description, $applyDiscountToCommission, $percentOrAmt, $amt, $payType)
	{
		return $this->client->request('DiscountService.addOrderTotalDiscount', $name, $description, $applyDiscountToCommission, $percentOrAmt, $amt, $payType);
	}

	/**
	 * @param integer $id
	 * @return array
	 */
	public function getOrderTotalDiscount($id)
	{
		return $this->client->request('DiscountService.getOrderTotalDiscount', $id);
	}

	/**
	 * @param string $name
	 * @param string $description
	 * @param integer $applyDiscountToCommission
	 * @param integer $amt
	 * @return integer
	 */
	public function addCategoryDiscount($name, $description, $applyDiscountToCommission, $amt)
	{
		return $this->client->request('DiscountService.addCategoryDiscount', $name, $description, $applyDiscountToCommission, $amt);
	}

	/**
	 * @param integer $id
	 * @return array
	 */
	public function getCategoryDiscount($id)
	{
		return $this->client->request('DiscountService.getCategoryDiscount', $id);
	}

	/**
	 * @param integer $id
	 * @param integer $productId
	 * @return integer
	 */
	public function addCategoryAssignmentToCategoryDiscount($id, $productId)
	{
		return $this->client->request('DiscountService.addCategoryAssignmentToCategoryDiscount', $id, $productId);
	}

	/**
	 * @param integer $id
	 * @return array
	 */
	public function getCategoryAssignmentsForCategoryDiscount($id)
	{
		return $this->client->request('DiscountService.getCategoryAssignmentsForCategoryDiscount', $id);
	}

	/**
	 * @param string $name
	 * @param string $description
	 * @param integer $applyDiscountToCommission
	 * @param integer $productId
	 * @param integer $percentOrAmt
	 * @param integer $amt
	 * @return integer
	 */
	public function addProductTotalDiscount($name, $description, $applyDiscountToCommission, $productId, $percentOrAmt, $amt)
	{
		return $this->client->request('DiscountService.addProductTotalDiscount', $name, $description, $applyDiscountToCommission, $productId, $percentOrAmt, $amt);
	}

	/**
	 * @param string $id
	 * @return array
	 */
	public function getProductTotalDiscount($id)
	{
		return $this->client->request('DiscountService.getProductTotalDiscount', $id);
	}

	/**
	 * @param string $name
	 * @param string $description
	 * @param integer $applyDiscountToCommission
	 * @param integer $percentOrAmt
	 * @param integer $amt
	 * @return integer
	 */
	public function addShippingTotalDiscount($name, $description, $applyDiscountToCommission, $percentOrAmt, $amt)
	{
		return $this->client->request('DiscountService.addShippingTotalDiscount', $name, $description, $applyDiscountToCommission, $percentOrAmt, $amt);
	}

	/**
	 * @param integer $id
	 * @return array
	 */
	public function getShippingTotalDiscount($id)
	{
		return $this->client->request('DiscountService.getShippingTotalDiscount', $id);
	}

}