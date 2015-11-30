<?php namespace Infusionsoft\Api\Rest;

class TaskService extends RestModel {

	public $full_url = 'https://api.infusionsoft.com/crm/rest/v1/tasks';
	public $return_key = 'tasks';

	public function getIndexUrl()
	{
		$url = $this->full_url.'/search';

		return $url;
	}

}