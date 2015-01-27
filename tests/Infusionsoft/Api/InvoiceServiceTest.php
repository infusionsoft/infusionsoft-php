<?php
namespace Infusionsoft\Api;

use Infusionsoft\TokenExpiredException;

class InvoiceServiceTest extends \ServiceTest {

	public function testCreateBlankOrder()
	{
		$this->ifs->invoices->createBlankOrder(111, 'hello world', new \DateTime('2014-08-08'), 2, 3);

		$this->verifyCall('InvoiceService.createBlankOrder');
	}
}