<?php

namespace Infusionsoft\Http;

use fXmlRpc\Transport\CurlTransport;

class CurlClient extends CurlTransport implements ClientInterface {

	/**
	 * @return CurlTransport
	 */
	public function getXmlRpcTransport()
	{
		return $this;
	}

	/**
	 * @param string $uri
	 * @param string $payload
	 * @return string
	 */
	public function send($uri, $payload)
	{
		curl_setopt($this->handle, CURLOPT_CAINFO, __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'cacert.pem');

		return parent::send($uri, $payload);
	}

}