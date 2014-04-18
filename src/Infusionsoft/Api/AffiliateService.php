<?php

namespace Infusionsoft\Api;

class AffiliateService extends AbstractApi {

	/**
	 * @param integer $affiliateId
	 * @param string $filterStartDate
	 * @param string $filterEndDate
	 * @return {{return}}
	 */
	public function affClawbacks($affiliateId, $filterStartDate, $filterEndDate)
	{
		return $this->client->request($this->method(), $affiliateId, $filterStartDate, $filterEndDate);
	}

	/**
	 * @param integer $affiliateId
	 * @param string $filterStartDate
	 * @param string $filterEndDate
	 * @return {{return}}
	 */
	public function affCommissions($affiliateId, $filterStartDate, $filterEndDate)
	{
		return $this->client->request($this->method(), $affiliateId, $filterStartDate, $filterEndDate);
	}

	/**
	 * @param integer $affiliateId
	 * @return {{return}}
	 */
	public function getRedirectLinksForAffiliate($affiliateId)
	{
		return $this->client->request($this->method(), $affiliateId);
	}

	/**
	 * @param integer $affiliateId
	 * @param string $filterStartDate
	 * @param string $filterEndDate
	 * @return {{return}}
	 */
	public function affPayouts($affiliateId, $filterStartDate, $filterEndDate)
	{
		return $this->client->request($this->method(), $affiliateId, $filterStartDate, $filterEndDate);
	}

	/**
	 * @param array $affiliateIds
	 * @return {{return}}
	 */
	public function affRunningTotals($affiliateIds)
	{
		return $this->client->request($this->method(), $affiliateIds);
	}

	/**
	 * @param array $affiliateId
	 * @param string $filterStartDate
	 * @param string $filterEndDate
	 * @return {{return}}
	 */
	public function affSummary($affiliateId, $filterStartDate, $filterEndDate)
	{
		return $this->client->request($this->method(), $affiliateId, $filterStartDate, $filterEndDate);
	}

}