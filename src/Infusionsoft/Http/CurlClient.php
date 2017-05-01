<?php

namespace Infusionsoft\Http;

use fXmlRpc\Transport\HttpAdapterTransport;
use Ivory\HttpAdapter\Configuration;
use Ivory\HttpAdapter\CurlHttpAdapter;

class CurlClient implements ClientInterface {

	/**
	 * @return \fXmlRpc\Transport\HttpAdapterTransport
	 */
	public function getXmlRpcTransport()
	{
		$config = new Configuration();
		$config->setTimeout( 60 );

		return new HttpAdapterTransport(new CurlHttpAdapter($config));
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
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return mixed
     * @throws HttpException
     * @internal param array $body
     * @internal param array $headers
     */
	public function request($method, $uri, array $options)
	{
        $headers = $options['headers'];
        $body = $options['body'];

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

		if (strtolower($method) === 'post')
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
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
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

		return $response;
	}

}