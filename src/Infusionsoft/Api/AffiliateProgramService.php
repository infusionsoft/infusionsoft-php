<?php

namespace Infusionsoft\Api;

class AffiliateProgramService extends AbstractApi {

	/**
	 * @param integer $programId
	 * @return {{return}}
	 */
	public function getAffiliatesByProgram($programId)
	{
		return $this->client->request($this->method(), $programId);
	}

	/**
	 * @param integer $affiliateId
	 * @return {{return}}
	 */
	public function getProgramsForAffiliate($affiliateId)
	{
		return $this->client->request($this->method(), $affiliateId);
	}

	/**
	 * @return {{return}}
	 */
	public function getAffiliatePrograms()
	{
		return $this->client->request($this->method());
	}

	/**
	 * @param integer $programId
	 * @return {{return}}
	 */
	public function getResourcesForAffiliateProgram($programId)
	{
		return $this->client->request($this->method(), $programId);
	}

}