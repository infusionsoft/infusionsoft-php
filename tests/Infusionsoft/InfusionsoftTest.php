<?php

namespace Infusionsoft;

use Infusionsoft\Http\CurlClient;
use Mockery as m;

class InfusionsoftTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var Infusionsoft
	 */
	protected $ifs;

	public function setUp()
	{
		$this->ifs = new Infusionsoft(array(
			'clientId'     => 'foo',
			'clientSecret' => 'bar',
			'redirectUri'  => 'http://example.com/'
		));
	}

	public function testMainClass()
	{
		$this->assertInstanceOf('Infusionsoft\Infusionsoft', $this->ifs);
	}

	public function testInfusionsoft()
	{
		$this->assertEquals('foo', $this->ifs->getClientId());
		$this->assertEquals('bar', $this->ifs->getClientSecret());
		$this->assertEquals('http://example.com/', $this->ifs->getRedirectUri());
	}

	public function testGetAuthorizationUrl()
	{
		$this->assertEquals('https://signin.infusionsoft.com/app/oauth/authorize?client_id=foo&redirect_uri=http%3A%2F%2Fexample.com%2F&response_type=code&scope=full', $this->ifs->getAuthorizationUrl());
	}

	public function testSettingUrl()
	{
		$this->ifs->setUrl('http://example.com/');
		$this->assertEquals('http://example.com/', $this->ifs->getUrl());
	}

	public function testSettingAuth()
	{
		$this->ifs->setAuth('http://example.com/');
		$this->assertEquals('http://example.com/', $this->ifs->getAuth());
	}

	public function testSettingTokenUri()
	{
		$this->ifs->setTokenUri('http://example.com/');
		$this->assertEquals('http://example.com/', $this->ifs->getTokenUri());
	}

	public function testSettingToken()
	{
		$this->ifs->setToken('http://example.com/');
		$this->assertEquals('http://example.com/', $this->ifs->getToken());
	}

	public function testDefaultHttpLogAdapter()
	{
		$this->assertInstanceOf('Guzzle\Log\ArrayLogAdapter', $this->ifs->getHttpLogAdapter());
	}

	public function testSettingClientId()
	{
		$this->ifs->setClientId('foo');
		$this->assertEquals('foo', $this->ifs->getClientId());
	}

	public function testSettingClientSecret()
	{
		$this->ifs->setClientSecret('bar');
		$this->assertEquals('bar', $this->ifs->getClientSecret());
	}

	public function testSettingRedirectUri()
	{
		$this->ifs->setRedirectUri('http://example.com/');
		$this->assertEquals('http://example.com/', $this->ifs->getRedirectUri());
	}

	public function testSettingTokenAndGettingProperties()
	{
		$this->ifs->setToken(new Token(array('access_token' => 'foo', 'refresh_token' => 'bar', 'expires_in' => 1, 'key' => 'value')));
		$this->assertEquals('foo', $this->ifs->getToken()->getAccessToken());
		$this->assertEquals('bar', $this->ifs->getToken()->getRefreshToken());
		$this->assertEquals(time() + 1, $this->ifs->getToken()->getEndOfLife());
		$extra = $this->ifs->getToken()->getExtraInfo();
		$this->assertEquals('value', $extra['key']);
	}

	public function testSettingHttpLogAdapter()
	{
		$this->ifs->setHttpLogAdapter(m::mock('Guzzle\Log\LogAdapterInterface'));
		$this->assertInstanceOf('Guzzle\Log\LogAdapterInterface', $this->ifs->getHttpLogAdapter());
	}

	public function testDefaultHttpClientShouldBeGuzzle()
	{
		$this->assertInstanceOf('Infusionsoft\Http\GuzzleClient', $this->ifs->getHttpClient());
	}

	public function testSettingHttpClientToCurl()
	{
		$this->ifs->setHttpClient(new CurlClient());
		$this->assertInstanceOf('Infusionsoft\Http\CurlClient', $this->ifs->getHttpClient());
	}

	public function testRequestingAccessTokenSetsAccessToken()
	{
		$client = m::mock('Infusionsoft\Http\ClientInterface');
		$client->shouldReceive('request')->once()
			->with('https://api.infusionsoft.com/token', array('client_id' => 'foo', 'client_secret' => 'bar', 'code' => 'code', 'grant_type' => 'authorization_code', 'redirect_uri' => 'baz'), array(), 'POST')
			->andReturn(array('access_token' => 'access_token'));

		$this->ifs->setClientId('foo');
		$this->ifs->setClientSecret('bar');
		$this->ifs->setRedirectUri('baz');
		$this->ifs->setHttpClient($client);
		$this->ifs->requestAccessToken('code');
		$this->assertEquals('access_token', $this->ifs->getToken()->getAccessToken());
	}

}
