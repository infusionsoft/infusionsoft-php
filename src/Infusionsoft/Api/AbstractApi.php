<?php

namespace Infusionsoft\Api;

use Infusionsoft\Infusionsoft;

abstract class AbstractApi {

	public function __construct(Infusionsoft $client)
	{
		$this->client = $client;
	}

	public function method()
	{
		$class = explode('\\', get_class($this));

		list(, $caller) = debug_backtrace(false);

		return array_pop($class) . '.' . $caller['function'];
	}

}