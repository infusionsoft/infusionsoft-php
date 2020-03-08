<?php namespace Infusionsoft\Api\Rest;

use Infusionsoft\Api\Rest\Traits\CannotCreate;
use Infusionsoft\Api\Rest\Traits\CannotDelete;
use Infusionsoft\Api\Rest\Traits\CannotFind;
use Infusionsoft\Api\Rest\Traits\CannotList;
use Infusionsoft\Api\Rest\Traits\CannotSave;
use Infusionsoft\Api\Rest\Traits\CannotSync;
use Infusionsoft\Api\Rest\Traits\CannotWhere;

class UserInfoService extends RestModel
{
    use CannotList, CannotWhere, CannotSync, CannotSave, CannotFind, CannotDelete, CannotCreate;

    public $full_url = 'https://api.infusionsoft.com/crm/rest/v1/oauth/connect/userinfo';

    public function get()
    {

        $data = $this->client->restfulRequest('get', $this->getIndexUrl());

        return $data;
    }

}