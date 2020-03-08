<?php namespace Infusionsoft\Api\Rest;

use Infusionsoft\Api\Rest\Traits\CannotModel;
use Infusionsoft\Api\Rest\Traits\CannotSync;

class NoteService extends RestModel
{
    use CannotSync, CannotModel;

    public $full_url = 'https://api.infusionsoft.com/crm/rest/v1/notes';

    public $return_key = 'notes';

    public $updateVerb = 'patch';
}
