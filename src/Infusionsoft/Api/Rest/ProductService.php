<?php namespace Infusionsoft\Api\Rest;

use Infusionsoft\Api\Rest\Traits\CannotCreate;
use Infusionsoft\Api\Rest\Traits\CannotDelete;
use Infusionsoft\Api\Rest\Traits\CannotModel;
use Infusionsoft\Api\Rest\Traits\CannotSave;

class ProductService extends RestModel {

	use CannotCreate, CannotSave, CannotModel;

	public $full_url = 'https://api.infusionsoft.com/crm/rest/v1/products';
	public $return_key = 'products';

	public function getIndexUrl()
	{
		$url = $this->full_url.'/search';

		return $url;
	}

}