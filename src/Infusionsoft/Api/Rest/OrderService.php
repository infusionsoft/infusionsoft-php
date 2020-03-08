<?php namespace Infusionsoft\Api\Rest;

use Infusionsoft\Api\Rest\Traits\CannotDelete;

class OrderService extends RestModel {

	public $full_url = 'https://api.infusionsoft.com/crm/rest/v1/orders';
	public $return_key = 'orders';


    public function addPayment($paymentDetails)
    {

        $response = $this->client->restfulRequest('post', $this->getFullUrl($this->id . '/payments'), $paymentDetails);

        return $response;
    }

}
