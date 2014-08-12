<?php

namespace Infusionsoft\Http;

use fXmlRpc\Transport\CurlTransport;

class CurlClient implements ClientInterface {

	/**
	 * @return GuzzleBridge
	 */
	public function getXmlRpcTransport()
	{
		return new CurlTransport();
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
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $uri);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

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