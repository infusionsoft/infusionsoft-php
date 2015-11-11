<?php namespace Infusionsoft\Api\Rest;

use Infusionsoft\Api\Rest\Traits\CannotDelete;

class OrderService extends RestModel {

	use CannotDelete;

	public $full_url = 'https://api.infusionsoft.com/crm/rest/v1/orders';
	public $return_key = 'orders';

}