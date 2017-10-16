<?php namespace Infusionsoft\Api\Rest;

use Infusionsoft\Api\Rest\Traits\CannotSync;

class FileService extends RestModel
{
    use CannotSync;

    public $full_url = 'https://api.infusionsoft.com/crm/rest/v1/files';
    public $return_key = 'files';

}