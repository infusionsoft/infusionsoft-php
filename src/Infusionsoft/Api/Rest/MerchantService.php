<?php

namespace Infusionsoft\Api\Rest;

use Infusionsoft\Api\Rest\Traits\CannotCreate;
use Infusionsoft\Api\Rest\Traits\CannotDelete;
use Infusionsoft\Api\Rest\Traits\CannotFind;
use Infusionsoft\Api\Rest\Traits\CannotModel;
use Infusionsoft\Api\Rest\Traits\CannotSave;
use Infusionsoft\Api\Rest\Traits\CannotSync;
use Infusionsoft\Api\Rest\Traits\CannotWhere;

class MerchantService extends RestModel
{
    use CannotCreate, CannotDelete, CannotFind, CannotModel, CannotSave, CannotSync, CannotWhere;

    public $full_url = 'https://api.infusionsoft.com/crm/rest/v1/merchants';
    public $return_key = 'merchant_accounts';
}