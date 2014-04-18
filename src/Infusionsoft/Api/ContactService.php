<?php

namespace Infusionsoft\Api;

class ContactService extends AbstractApi {

	public function add(array $params)
	{
		return $this->client->request($this->method(), $params);
	}

}