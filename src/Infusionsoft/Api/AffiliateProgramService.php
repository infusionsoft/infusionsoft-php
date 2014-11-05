<?php

namespace Infusionsoft\Api;

class AffiliateProgramService extends AbstractApi {

	/**
	 * @param integer $programId
	 * @return array
	 */
	public function getAffiliatesByProgram($programId)
	{
		return $this->client->request('AffiliateProgramService.getAffiliatesByProgram', $programId);
	}

	/**
	 * @param integer $affiliateId
	 * @return array
	 */
	public function getProgramsForAffiliate($affiliateId)
	{
		return $this->client->request('AffiliateProgramService.getProgramsForAffiliate', $affiliateId);
	}

	/**
	 * @return array
	 */
	public function getAffiliatePrograms()
	{
		return $this->client->request('AffiliateProgramService.getAffiliatePrograms');
	}

	/**
	 * @param integer $programId
	 * @return array
	 */
	public function getResourcesForAffiliateProgram($programId)
	{
		return $this->client->request('AffiliateProgramService.getResourcesForAffiliateProgram', $programId);
	}

}