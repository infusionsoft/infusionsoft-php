<?php

namespace Infusionsoft\Http;

use fXmlRpc\Client;
use fXmlRpc\Exception\ExceptionInterface as fXmlRpcException;

class InfusionsoftSerializer implements SerializerInterface {

	/**
	 * @param string          $method
	 * @param string          $uri
	 * @param array           $params
	 * @param ClientInterface $client
	 * @return mixed|void
	 * @throws HttpException
	 */
	public function request($method, $uri, $params, ClientInterface $client)
	{
		// Although we are using fXmlRpc to handle the XML-RPC formatting, we
		// can still use Guzzle as our HTTP client which is much more robust.
		try
		{
			$transport = $client->getXmlRpcTransport();

			$client = new Client($uri, $transport);

			$response = $client->call($method, $params);

			return $response;
		}
		catch (fXmlRpcException $e)
		{
			throw new HttpException($e);
		}
	}

}