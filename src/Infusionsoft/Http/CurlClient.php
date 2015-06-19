<?php

namespace Infusionsoft\Http;

use fXmlRpc\Transport\CurlTransport;

class CurlClient implements ClientInterface {

	/**
	 * @return CurlTransport
	 */
	public function getXmlRpcTransport()
	{
		return new CurlTransport();
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
		$processed_headers = array();
		if(!empty($headers))
		{
			foreach($headers as $key => $value)
			{
				$processed_headers[] = $key . ': ' . $value;
			}
		}

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $uri);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $processed_headers);
		curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'cacert.pem');

		if ($method === 'POST')
		{
			curl_setopt($ch, CURLOPT_POST, true);

			if ($body && is_array($body))
			{
				$body = http_build_query($body, '', '&');
			}

			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		}
		else
		{
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		}

		$response     = curl_exec($ch);
		$responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if (false === $response)
		{
			$errNo  = curl_errno($ch);
			$errStr = curl_error($ch);
			curl_close($ch);

			if (empty($errStr))
			{
				throw new HttpException('There was a problem requesting the resource.', $responseCode);
			}

			throw new HttpException($errStr . '(cURL Error: ' . $errNo . ')', $responseCode);
		}

		curl_close($ch);

		return json_decode($response, true);
	}

}