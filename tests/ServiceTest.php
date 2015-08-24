<?php

use AspectMock\Test as test;
use Infusionsoft\Infusionsoft;
use Mockery as m;

class ServiceTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Infusionsoft
	 */
	protected $ifs;

	/**
	 * mocked fXmlRpc\Transport\GuzzleBridge
	 *
	 * @var fXmlRpc\Transport\HttpAdapterTransporte
	 */
	protected $transport;

	/**
	 * API end point
	 *
	 * @var [type]
	 */
	protected $endpoint;

	public function setUp()
	{
		$token = new \Infusionsoft\Token(['access_token' => 'foo', 'expires_in' => 3600]);

		$this->ifs = new Infusionsoft();
		$this->ifs->setToken($token);
		$this->endpoint = 'https://api.infusionsoft.com/crm/xmlrpc/v1?access_token=foo';

		$this->transport = test::double('fXmlRpc\Transport\GuzzleBridge', ['send' => true]);
	}

	public function tearDown()
	{
		test::clean();
	}

	public function verifyCall($fixtureOrXml, $isFixture = true)
	{
		if ($isFixture)
		{
			$fixturePath = str_replace('.', '/', $fixtureOrXml);
			$expectedXml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
			$expectedXml .= $this->minifyFixture(file_get_contents(__DIR__ . "/Infusionsoft/Api/fixtures/{$fixturePath}.xml"));
		}
		else
		{
			$expectedXml = $fixtureOrXml;
		}

		$this->transport->verifyInvoked('send');
		$args = $this->transport->getCallsForMethod('send');

		$this->assertEquals($args[0][1], $expectedXml);
	}

	public function minifyFixture($content)
	{
		$search = ['/\>[^\S]+/s', '/[^\S]+\</s', '/(\s)+/s'];
		$replace = ['>', '<', '\\1'];
		$content = preg_replace($search, $replace, $content);

		return $content;
	}
}