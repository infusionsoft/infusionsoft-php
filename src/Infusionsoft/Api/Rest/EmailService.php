<?php namespace Infusionsoft\Api\Rest;

use Infusionsoft\Api\Rest\Traits\CannotDelete;
use Infusionsoft\Api\Rest\Traits\CannotModel;
use Infusionsoft\Api\Rest\Traits\CannotSync;

class EmailService extends RestModel
{
    use CannotSync, CannotDelete, CannotModel;

    public $full_url = 'https://api.infusionsoft.com/crm/rest/v1/emails';

    public $return_key = 'emails';
    
    public function send($attributes = [])
    {
        $response = $this->client->restfulRequest('post', $this->getFullUrl('/queue'), $attributes);
        return $response;
    }
}
