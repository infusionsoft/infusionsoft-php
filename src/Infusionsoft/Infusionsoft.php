<?php

namespace Infusionsoft;

class Infusionsoft {

	protected $url = 'https://api.infusionsoft.com/crm/xmlrpc/v1';

	protected $auth = 'https://signin.infusionsoft.com/app/oauth/authorize';

	protected $token = 'https://api.infusionsoft.com/token';

	protected $clientId;

	protected $clientSecret;

	protected $redirectUri;

	protected $accessToken;

	protected $apis = array();

	public function __construct($config = array())
	{
		if (isset($config['clientId'])) $this->clientId = $config['clientId'];

		if (isset($config['clientSecret'])) $this->clientSecret = $config['clientSecret'];

		if (isset($config['redirectUri'])) $this->redirectUri = $config['redirectUri'];
	}

	/**
	 * @return string
	 */
	public function getClientId()
	{
		return $this->clientId;
	}

	/**
	 * @param string $clientId
	 * @return string
	 */
	public function setClientId($clientId)
	{
		$this->clientId = $clientId;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getClientSecret()
	{
		return $this->clientSecret;
	}

	/**
	 * @param string $clientSecret
	 * @return string
	 */
	public function setClientSecret($clientSecret)
	{
		$this->clientSecret = $clientSecret;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getRedirectUri()
	{
		return $this->redirectUri;
	}

	/**
	 * @param string $redirectUri
	 * @return string
	 */
	public function setRedirectUri($redirectUri)
	{
		$this->redirectUri = $redirectUri;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getAccessToken()
	{
		return $this->accessToken;
	}

	/**
	 * @param string $accessToken
	 * @return string
	 */
	public function setAccessToken($accessToken)
	{
		$this->accessToken = $accessToken;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getAuthorizationUrl()
	{
		$params = array(
			'client_id'     => $this->clientId,
			'redirect_uri'  => $this->redirectUri,
			'response_type' => 'code',
			'scope'         => 'full'
		);

		return $this->auth . '?' . http_build_query($params);
	}

	/**
	 * @param string $code
	 * @return array
	 */
	public function requestAccessToken($code)
	{
		$params = array(
			'client_id'     => $this->clientId,
			'client_secret' => $this->clientSecret,
			'code'          => $code,
			'grant_type'    => 'authorization_code',
			'redirect_uri'  => $this->redirectUri,
		);

		try
		{
			$guzzle = new \Guzzle\Http\Client();

			$response = $guzzle->post($this->token, array(), $params)->send();

			$tokenInfo = $response->json();

			if ($tokenInfo['mapi'] !== $this->clientId)
			{
				throw new InfusionsoftException('Invalid map.');
			}

			return $this->setAccessToken($tokenInfo['access_token']);
		}
		catch (\Guzzle\Http\Exception\ClientErrorResponseException $e)
		{
			throw new InfusionsoftException('There was a problem while requesting the access token.');
		}
	}

	/**
	 * @param string $methodName
	 * @param array $params
	 * @throws InfusionsoftException
	 * @return mixed
	 */
	public function request($methodName, array $params = array())
	{
		$httpClient = new \Guzzle\Http\Client();

		$url = $this->url . '?' . http_build_query(array('access_token' => $this->accessToken));

		// Although we are using fXmlRpc to handle the XML-RPC formatting, we
		// can still use Guzzle as our HTTP client which is much more robust.
		$client = new \fXmlRpc\Client($url, new \fXmlRpc\Transport\GuzzleBridge($httpClient));

		try
		{
			$response = $client->call($methodName, array('key' => '', $params));

			return $response;
		}
		catch (\fXmlRpc\Exception\HttpException $e)
		{
			throw new InfusionsoftException($e);
		}
	}

	/**
	 * @param $name
	 * @throws \UnexpectedValueException
	 * @return mixed
	 */
	public function __get($name)
	{
		$services = array('contacts');

		if (method_exists($this, $name) and in_array($name, $services))
		{
			return $this->{$name}();
		}

		throw new \UnexpectedValueException(sprintf('Invalid property: %s', $name));
	}

	public function contacts()
	{
		return $this->getApi('ContactService');
	}

	public function getApi($class)
	{
		$class = '\Infusionsoft\Api\\' . $class;

		if ( ! array_key_exists($class, $this->apis))
		{
			$this->apis[$class] = new $class($this);
		}

		return $this->apis[$class];
	}

}