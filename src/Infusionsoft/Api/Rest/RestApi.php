<?php

namespace Infusionsoft\Api;

use Infusionsoft\Infusionsoft;

abstract class AbstractApi {

	public function __construct(Infusionsoft $client)
	{
		$this->client = $client;
	}

}