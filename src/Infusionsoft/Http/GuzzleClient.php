<?php

namespace Infusionsoft\Http;

use fXmlRpc\Transport\GuzzleBridge;
use Guzzle\Http\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;

class GuzzleClient implements ClientInterface {

	public $debug;
	public $httpLogAdapter;

	public function __construct($debug, $httpLogAdapter)
	{
		$this->debug = $debug;
		$this->httpLogAdapter = $httpLogAdapter;
	}

	/**
	 * @return GuzzleBridge
	 */
	public function getXmlRpcTransport()
	{
		return new GuzzleBridge(new Client());
	}

	/**
	 * @param string $uri
	 * @param array  $body
	 * @param array  $headers
	 * @param string $method
	 * @return mixed
	 * @throws HttpException
	 */
	public function request($uri, $body, $headers, $method)
	{
		try
		{
			$client = new Client();

			if ($this->debug)
			{
				$logPlugin = new \Guzzle\Plugin\Log\LogPlugin(
					$this->httpLogAdapter,
					\Guzzle\Log\MessageFormatter::DEBUG_FORMAT
				);
				$client->addSubscriber($logPlugin);
			}

			$request = $client->createRequest($method, $uri, $headers, $body);

			$response = $request->send();

			return $response->json();
		}
		catch (ClientErrorResponseException $e)
		{
			throw new HttpException($e);
		}
	}

}