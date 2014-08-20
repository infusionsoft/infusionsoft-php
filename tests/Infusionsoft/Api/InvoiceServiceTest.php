<?php
namespace Infusionsoft\Api;

use Infusionsoft\Infusionsoft;
use AspectMock\Test as test;
use Mockery as m;

class InvoiceServiceTest extends \ServiceTest
{

    public function testCreateBlankOrder()
    {
        $this->ifs->invoices->createBlankOrder(111, 'hello world', new \DateTime('2014-08-08'), 2, 3);
        $this->verifyCall('InvoiceService.createBlankOrder');
    }
}