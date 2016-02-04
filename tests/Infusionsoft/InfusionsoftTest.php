<?php

namespace Infusionsoft;

use Infusionsoft\Http\CurlClient;
use Mockery as m;
use Psr\Log\NullLogger;

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
		$this->assertInstanceOf('Infusionsoft\Http\ArrayLogger', $this->ifs->getHttpLogAdapter());
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

		$this->ifs->setHttpLogAdapter(new NullLogger());
		$this->assertInstanceOf('Psr\Log\NullLogger', $this->ifs->getHttpLogAdapter());
	}

	public function testDefaultHttpClientShouldBeGuzzle()
	{
		$this->assertInstanceOf('Infusionsoft\Http\GuzzleHttpClient', $this->ifs->getHttpClient());
	}

	public function testSettingHttpClientToCurl()
	{
		$this->ifs->setHttpClient(new CurlClient());
		$this->assertInstanceOf('Infusionsoft\Http\CurlClient', $this->ifs->getHttpClient());
	}

	public function testRequestingAccessTokenSetsAccessToken()
	{
		$client = m::mock('Infusionsoft\Http\GuzzleHttpClient');
		$client->shouldReceive('request')->once()
			->with('POST', 'https://api.infusionsoft.com/token', ['body' => array(
				'client_id' => 'foo',
				'client_secret' => 'bar',
				'code' => 'code',
				'grant_type' => 'authorization_code',
				'redirect_uri' => 'baz')]
			)->andReturn(array('access_token' => 'access_token'));

		$this->ifs->setClientId('foo');
		$this->ifs->setClientSecret('bar');
		$this->ifs->setRedirectUri('baz');
		$this->ifs->setHttpClient($client);
		$this->ifs->requestAccessToken('code');
		$this->assertEquals('access_token', $this->ifs->getToken()->getAccessToken());
	}

    public function testIsTokenExpired()
    {
        //no token is set so it should return true
        $this->assertTrue($this->ifs->isTokenExpired());

        //token is set and still not expired
        $token = new Token(array( 'access_token' => '', 'refresh_token' => '', 'expires_in' => 5));
        $this->ifs->setToken($token);
        $this->assertFalse($this->ifs->isTokenExpired());

        //token is set but expired
        $token = new Token(array( 'access_token' => '', 'refresh_token' => '', 'expires_in' => -5));
        $this->ifs->setToken($token);
        $this->assertTrue($this->ifs->isTokenExpired());
    }
}
