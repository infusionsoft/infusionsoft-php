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
	 * @param $method
	 * @param string $uri
	 * @param array $options
	 * @return mixed
	 * @internal param array $params
	 * @internal param array $headers
	 * @internal param string $method
	 */
	public function request($method, $uri, array $options);

}
