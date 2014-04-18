<?php

namespace Infusionsoft;

class InfusionsoftTest extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->ifs = new Infusionsoft(array(
			'clientId'     => 'foo',
			'clientSecret' => 'bar',
			'redirectUri'  => 'http://example.com/'
		));
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
}
