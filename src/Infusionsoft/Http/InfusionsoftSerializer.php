<?php

namespace Infusionsoft\Http;

use fXmlRpc\Client;
use fXmlRpc\Exception\ExceptionInterface as fXmlRpcException;
use fXmlRpc\Parser\XmlReaderParser;

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

            $parser = new XmlReaderParser(true);

			$client = new Client($uri, $transport, $parser);

			$response = $client->call($method, $params);

			return $response;
		}
		catch (fXmlRpcException $e)
		{
			throw new HttpException($e->getMessage(), $e->getCode(), $e);
		}
	}

}
