<?php namespace Infusionsoft\Api\Rest;

use Infusionsoft\Api\Rest\Traits\CannotCreate;
use Infusionsoft\Api\Rest\Traits\CannotDelete;
use Infusionsoft\Api\Rest\Traits\CannotModel;
use Infusionsoft\Api\Rest\Traits\CannotSave;
use Infusionsoft\Api\Rest\Traits\CannotSync;

class CustomFieldService extends RestModel {

    use CannotDelete, CannotSync, CannotSave, CannotCreate, CannotModel;

    public $full_url = 'https://api.infusionsoft.com/crm/rest/v1/contactCustomFields';

}