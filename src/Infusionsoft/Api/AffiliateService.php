<?php

namespace Infusionsoft\Api;

class AffiliateService extends AbstractApi {

	/**
	 * @param integer $affiliateId
	 * @param string $filterStartDate
	 * @param string $filterEndDate
	 * @return array
	 */
	public function affClawbacks($affiliateId, $filterStartDate, $filterEndDate)
	{
		return $this->client->request($this->method(), $affiliateId, $filterStartDate, $filterEndDate);
	}

	/**
	 * @param integer $affiliateId
	 * @param string $filterStartDate
	 * @param string $filterEndDate
	 * @return array
	 */
	public function affCommissions($affiliateId, $filterStartDate, $filterEndDate)
	{
		return $this->client->request($this->method(), $affiliateId, $filterStartDate, $filterEndDate);
	}

	/**
	 * @param integer $affiliateId
	 * @return array
	 */
	public function getRedirectLinksForAffiliate($affiliateId)
	{
		return $this->client->request($this->method(), $affiliateId);
	}

	/**
	 * @param integer $affiliateId
	 * @param string $filterStartDate
	 * @param string $filterEndDate
	 * @return array
	 */
	public function affPayouts($affiliateId, $filterStartDate, $filterEndDate)
	{
		return $this->client->request($this->method(), $affiliateId, $filterStartDate, $filterEndDate);
	}

	/**
	 * @param array $affiliateIds
	 * @return array
	 */
	public function affRunningTotals($affiliateIds)
	{
		return $this->client->request($this->method(), $affiliateIds);
	}

	/**
	 * @param array $affiliateId
	 * @param string $filterStartDate
	 * @param string $filterEndDate
	 * @return array
	 */
	public function affSummary($affiliateId, $filterStartDate, $filterEndDate)
	{
		return $this->client->request($this->method(), $affiliateId, $filterStartDate, $filterEndDate);
	}

}