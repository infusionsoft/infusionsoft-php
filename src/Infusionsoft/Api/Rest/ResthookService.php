<?php namespace Infusionsoft\Api\Rest;

use Infusionsoft\Infusionsoft;

class ResthookService extends RestModel
{

    public $full_url = 'https://api.infusionsoft.com/crm/rest/v1/hooks';

    public $hidden = ['key','status'];


    public function __construct(Infusionsoft $client)
    {
        $this->setUpdateVerb('put');
        $this->setPrimaryKey('key');
        parent::__construct($client);
    }

    public function events()
    {
        $data = $this->client->restfulRequest('get', $this->getFullUrl('event_keys'));
        $this->fill($data);

        return $this;
    }

    public function verify()
    {
        $data = $this->client->restfulRequest('post', $this->getFullUrl($this->key . '/verify'));
        $this->fill($data);

        return $this;
    }

    public function autoverify($return_header = true)
    {
        $headers = array();
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) <> 'HTTP_') {
                continue;
            }
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[$header] = $value;
        }

        if (isset($headers['X-Hook-Secret'])) {
            if ($return_header) {
                header('X-Hook-Secret: ' . $headers['X-Hook-Secret']);
            } else {
                return $headers['X-Hook-Secret'];
            }
        }

        return null;
    }
}