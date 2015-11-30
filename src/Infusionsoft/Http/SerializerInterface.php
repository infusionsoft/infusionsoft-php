<?php

namespace Infusionsoft\Http;

interface SerializerInterface {

	/**
	 * Calls an XML-RPC endpoint by serializing the parameters using the
	 * default XML-RPC serializer. Uses the same HTTP Client as the
	 * OAuth2 calls.
	 *
	 * @param string          $method
	 * @param string          $uri
	 * @param array           $params
	 * @param ClientInterface $client
	 * @return mixed
	 */
	public function request($method, $uri, $params, ClientInterface $client);

}