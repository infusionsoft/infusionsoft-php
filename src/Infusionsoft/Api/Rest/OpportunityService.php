<?php namespace Infusionsoft\Api\Rest;

use Infusionsoft\Api\Rest\Traits\CannotDelete;
use Infusionsoft\Api\Rest\Traits\CannotSync;

class OpportunityService extends RestModel
{
	use CannotDelete, CannotSync;

    public $full_url = 'https://api.infusionsoft.com/crm/rest/v1/opportunities';
	public $return_key = 'opportunities';

    public function stage_pipeline()
    {
        $data = $this->client->restfulRequest('get', 'https://api.infusionsoft.com/crm/rest/v1/opportunity/stage_pipeline');
        $this->fill($data);

        return $this;
    }

}