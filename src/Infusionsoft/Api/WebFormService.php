<?php

namespace Infusionsoft\Api;

class WebFormService extends AbstractApi {

	/**
	 * @return {{return}}
	 */
	public function getMap()
	{
		return $this->client->request($this->method());
	}

	/**
	 * @param integer $webFormId
	 * @return {{return}}
	 */
	public function getHTML($webFormId)
	{
		return $this->client->request($this->method(), $webFormId);
	}

}