<?php

namespace Infusionsoft\Http;

interface ClientInterface {

	/**
	 * @return \fXmlRpc\Transport\TransportInterface
	 */
	public function getXmlRpcTransport();

	/**
	 * Sends a request to the given URI and returns the raw response.
	 *
	 * @param string $uri
	 * @param array  $params
	 * @param array  $headers
	 * @param string $method
	 * @return mixed
	 */
	public function request($uri, $params, $headers, $method);

}
