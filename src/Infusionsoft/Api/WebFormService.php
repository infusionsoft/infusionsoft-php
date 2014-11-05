<?php

namespace Infusionsoft\Api;

class WebFormService extends AbstractApi {

	/**
	 * @return mixed
	 */
	public function getMap()
	{
		return $this->client->request('WebFormService.getMap');
	}

	/**
	 * @param integer $webFormId
	 * @return mixed
	 */
	public function getHTML($webFormId)
	{
		return $this->client->request('WebFormService.getHTML', $webFormId);
	}

}