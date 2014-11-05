<?php

namespace Infusionsoft\Api;

class FunnelService extends AbstractApi {

	/**
	 * @param string $integration
	 * @param string $callName
	 * @param integer $contactId
	 * @return mixed
	 */
	public function achieveGoal($integration, $callName, $contactId)
	{
		return $this->client->request('FunnelService.achieveGoal', $integration, $callName, $contactId);
	}

}
