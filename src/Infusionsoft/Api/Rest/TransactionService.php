<?php namespace Infusionsoft\Api\Rest;

use Infusionsoft\Api\Rest\Traits\CannotCreate;
use Infusionsoft\Api\Rest\Traits\CannotDelete;
use Infusionsoft\Api\Rest\Traits\CannotSave;

class TransactionService extends RestModel {

	use CannotCreate;
	use CannotSave;
	use CannotDelete;

	public $full_url = 'https://api.infusionsoft.com/crm/rest/v1/transactions';
	public $return_key = 'transactions';

}