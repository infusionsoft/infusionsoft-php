<?php namespace Infusionsoft\Api\Rest;

use Infusionsoft\Api\Rest\Traits\CannotCreate;
use Infusionsoft\Api\Rest\Traits\CannotDelete;
use Infusionsoft\Api\Rest\Traits\CannotSave;
use Infusionsoft\Api\Rest\Traits\CannotSync;
use Infusionsoft\Infusionsoft;
use Infusionsoft\InfusionsoftException;

class CampaignService extends RestModel
{

    use CannotCreate, CannotDelete, CannotSave, CannotSync;

    public $full_url = 'https://api.infusionsoft.com/crm/rest/v1/campaigns';

    public $return_key = 'campaigns';

    public function __construct(Infusionsoft $client)
    {
        parent::__construct($client);
    }


}