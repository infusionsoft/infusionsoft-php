<?php namespace Infusionsoft\Api\Rest;

use Infusionsoft\Api\Rest\Traits\CannotCreate;
use Infusionsoft\Api\Rest\Traits\CannotDelete;
use Infusionsoft\Api\Rest\Traits\CannotModel;
use Infusionsoft\Api\Rest\Traits\CannotSave;

class TransactionService extends RestModel {

	use CannotCreate, CannotSave, CannotDelete, CannotModel;

	public $full_url = 'https://api.infusionsoft.com/crm/rest/v1/transactions';
	public $return_key = 'transactions';

}