<?php

namespace Infusionsoft\Api;

class OrderService extends AbstractApi {

	/**
	 * @param integer $contactId
	 * @param integer $creditCardId
	 * @param integer $payPlanId
	 * @param array $productIds
	 * @param array $subscriptionPlanIds
	 * @param boolean $processSpecials
	 * @param array $promoCodes
	 * @param integer $leadAffiliateId
	 * @param integer $affiliateId
	 * @return mixed
	 */
	public function placeOrder($contactId, $creditCardId, $payPlanId, $productIds, $subscriptionPlanIds, $processSpecials, $promoCodes, $leadAffiliateId, $affiliateId)
	{
		return $this->client->request('OrderService.placeOrder', $contactId, $creditCardId, $payPlanId, $productIds, $subscriptionPlanIds, $processSpecials, $promoCodes, $leadAffiliateId, $affiliateId);
	}

}