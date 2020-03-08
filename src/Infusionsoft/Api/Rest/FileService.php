<?php namespace Infusionsoft\Api\Rest;

use Infusionsoft\Api\Rest\Traits\CannotModel;
use Infusionsoft\Api\Rest\Traits\CannotSync;

class FileService extends RestModel
{
    use CannotSync, CannotModel;

    public $full_url = 'https://api.infusionsoft.com/crm/rest/v1/files';
    public $return_key = 'files';

    public function getIdAttribute() {
        if(isset($this->attributes['id'])) {
            return $this->attributes['id'];
        }
        if(isset($this->attributes['file_descriptor'])) {
            return $this->attributes['file_descriptor']['id'];
        }
    }
}