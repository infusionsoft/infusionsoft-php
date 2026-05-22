<?php namespace Infusionsoft\Api\Rest;

use Infusionsoft\Api\Rest\Traits\CannotCreate;
use Infusionsoft\Api\Rest\Traits\CannotDelete;
use Infusionsoft\Api\Rest\Traits\CannotFind;
use Infusionsoft\Api\Rest\Traits\CannotList;
use Infusionsoft\Api\Rest\Traits\CannotModel;
use Infusionsoft\Api\Rest\Traits\CannotSave;
use Infusionsoft\Api\Rest\Traits\CannotSync;
use Infusionsoft\Api\Rest\Traits\CannotWhere;
use Infusionsoft\Infusionsoft;

class LocaleService extends RestModel
{
    use CannotSync, CannotSave, CannotDelete, CannotFind;
    use CannotList, CannotModel, CannotWhere, CannotDelete, CannotCreate;

    public $full_url = 'https://api.infusionsoft.com/crm/rest/v1/locales';

    public $return_key = 'locales';

    public function __construct(Infusionsoft $client)
    {
        parent::__construct($client);
    }

    /**
     * Retrieves a list of all countries
     *
     * @param array $params
     * @return array
     */
    public function countries()
    {
        return $this->client->restfulRequest('get', $this->getFullUrl('/countries'));
    }

    /**
     * Retrieves a list of all provinces for given country
     *
     * @param array $params
     * @return array
     */
    public function provinces($country_code = '')
    {
        return $this->client->restfulRequest('get', $this->getFullUrl('/countries/' . $country_code . '/provinces'));
    }
}