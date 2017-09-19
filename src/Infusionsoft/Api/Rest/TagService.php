<?php namespace Infusionsoft\Api\Rest;

use Infusionsoft\Api\Rest\Traits\CannotCreate;
use Infusionsoft\Api\Rest\Traits\CannotDelete;
use Infusionsoft\Api\Rest\Traits\CannotFind;
use Infusionsoft\Api\Rest\Traits\CannotSave;
use Infusionsoft\Api\Rest\Traits\CannotSync;
use Infusionsoft\Api\Rest\Traits\CannotWhere;
use Infusionsoft\Infusionsoft;
use Infusionsoft\InfusionsoftException;

class TagService extends RestModel
{
    use CannotSync;
    use CannotSave;
    use CannotDelete;
    use CannotFind;
    use CannotWhere;

    public $full_url = 'https://api.infusionsoft.com/crm/rest/v1/tags';

    public $return_key = 'tags';

    public function __construct(Infusionsoft $client)
    {
        parent::__construct($client);
    }

    public function contacts()
    {
        $data = $this->client->restfulRequest('get', $this->getFullUrl($this->id . '/contacts'));
        $this->fill($data);

        return $this;
    }

    public function removeContacts($contactIds)
    {
        if (!is_array($contactIds)) {
            throw new InfusionsoftException('Must be an array of contact ids');
        } elseif (count($contactIds) > 100) {
            throw new InfusionsoftException('A maximum of 100 contact ids can be modified at once');
        }

        $contactIds = ['ids' => implode(",", $contactIds)];

        $response = $this->client->restfulRequest('delete', $this->getFullUrl($this->id . '/contacts'), $contactIds);

        return $response;
    }

    public function addContacts($contactIds)
    {
        if (!is_array($contactIds)) {
            throw new InfusionsoftException('Must be an array of contact ids');
        } elseif (count($contactIds) > 100) {
            throw new InfusionsoftException('A maximum of 100 contact ids can be modified at once');
        }

        $contacts = new \stdClass();
        $contacts->ids = $contactIds;

        $response = $this->client->restfulRequest('post', $this->getFullUrl($this->id . '/contacts'), $contacts);

        return $response;
    }

}
