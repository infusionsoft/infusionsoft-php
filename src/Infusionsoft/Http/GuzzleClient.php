<?php

namespace Infusionsoft\Http;

use fXmlRpc\Transport\HttpAdapterTransport;
use Guzzle\Http\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;

class GuzzleClient implements ClientInterface {

	/**
	 * @return GuzzleBridge
	 */
	public function getXmlRpcTransport()
	{
		return new HttpAdapterTransport( new \Ivory\HttpAdapter\GuzzleHttpAdapter( new Client() ) );
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