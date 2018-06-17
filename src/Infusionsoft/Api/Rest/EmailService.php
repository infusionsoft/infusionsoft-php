<?php namespace Infusionsoft\Api\Rest;

use Infusionsoft\Api\Rest\Traits\CannotDelete;
use Infusionsoft\Api\Rest\Traits\CannotFind;
use Infusionsoft\Api\Rest\Traits\CannotModel;
use Infusionsoft\Api\Rest\Traits\CannotSave;
use Infusionsoft\Api\Rest\Traits\CannotSync;

class EmailService extends RestModel
{
    use CannotSync, CannotSave, CannotDelete, CannotFind, CannotModel;

    public $full_url = 'https://api.infusionsoft.com/crm/rest/v1/emails';

    public $return_key = 'emails';
}