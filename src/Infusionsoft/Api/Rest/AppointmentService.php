<?php namespace Infusionsoft\Api\Rest;

class AppointmentService extends RestModel {

	public $full_url = 'https://api.infusionsoft.com/crm/rest/v1/appointments';
	public $return_key = 'appointments';

	public function getIndexUrl()
	{
		$url = $this->full_url.'/search';

		return $url;
	}

}