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

    public function deleteOrderItem($id = null)
    { 
	    
        if(!$id) return false;
		
        $response = $this->client->restfulRequest('delete', $this->getFullUrl($this->id . '/items/'. $id));

        return $response;
		
   }
    public function transactions()
    {
        
        $response = $this->client->restfulRequest('get', $this->getFullUrl($this->id . '/transactions'));

        return $response;
    }

}
