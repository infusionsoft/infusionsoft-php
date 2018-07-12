<?php

namespace Infusionsoft;

use Infusionsoft\Api\Rest\ContactService;
use Mockery as m;
use Psr\Log\NullLogger;

class RestModelTest extends \PHPUnit_Framework_TestCase
{
  protected $model;

  protected $client;

  public function setUp()
  {
    $this->client = m::mock('Infusionsoft\Infusionsoft');
    $this->model = new ContactService($this->client);
  }

  public function testFirst() {
    $this->mockRestfulRequest([
      'get',
      'https://api.infusionsoft.com/crm/rest/v1/contacts',
      ['limit' => 1],
    ],
    [
      'count' => 1,
      'contacts' => [['first_name' => 'Bob']],
    ]);

    $this->assertEquals(
      'Bob',
      $this->model->first()->first_name
    );
  }

  public function testFirstWithClauses() {
    $this->mockRestfulRequest([
      'get',
      'https://api.infusionsoft.com/crm/rest/v1/contacts',
      [
        // params should be folded in
        'limit' => 1,
        'optional_properties' => 'custom_fields,job_title',
        'email' => 'bob@example.com',
      ],
    ],
    [
      'count' => 1,
      'contacts' => [['first_name' => 'Bob']],
    ]);

    $bob = $this->model
      ->where('email', 'bob@example.com')
      ->with(['custom_fields', 'job_title'])
      ->first();

    $this->assertEquals(
      'Bob',
      $bob->first_name
    );

  }

  protected function mockRestfulRequest($args = [], $return = []) {
    $this->client->shouldReceive('restfulRequest')
      ->once()
      ->withArgs($args)
      ->andReturn($return);
  }
}
