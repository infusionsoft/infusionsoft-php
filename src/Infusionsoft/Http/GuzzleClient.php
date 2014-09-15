<?php

namespace Infusionsoft\Http;

use fXmlRpc\Transport\GuzzleBridge;
use Guzzle\Http\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;

class GuzzleClient implements ClientInterface {

	/**
	 * @return GuzzleBridge
	 */
	public function getXmlRpcTransport()
	{
		return new GuzzleBridge(new Client());
	}

}