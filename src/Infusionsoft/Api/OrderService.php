<?php

namespace Infusionsoft\Api;

class OrderService extends AbstractApi {

	/**
	 * @param integer $contactId
	 * @param integer $creditCardId
	 * @param integer $payPlanId
	 * @param List $productIds
	 * @param List $subscriptionPlanIds
	 * @param boolean $processSpecials
	 * @param List $promoCodes
	 * @param integer $leadAffiliateId
	 * @param integer $affiliateId
	 * @return {{return}}
	 */
	public function placeOrder($contactId, $creditCardId, $payPlanId, $productIds, $subscriptionPlanIds, $processSpecials, $promoCodes, $leadAffiliateId, $affiliateId)
	{
		return $this->client->request($this->method(), $contactId, $creditCardId, $payPlanId, $productIds, $subscriptionPlanIds, $processSpecials, $promoCodes, $leadAffiliateId, $affiliateId);
	}

}