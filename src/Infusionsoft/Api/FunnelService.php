<?php

namespace Infusionsoft\Api;

class FunnelService extends AbstractApi {

	/**
	 * @param string $key
	 * @param string $integration
	 * @param string $callName
	 * @param integer $contactId
	 * @return {{return}}
	 */
	public function achieveGoal($key, $integration, $callName, $contactId)
	{
		return $this->client->request($this->method(), $key, $integration, $callName, $contactId);
	}

}