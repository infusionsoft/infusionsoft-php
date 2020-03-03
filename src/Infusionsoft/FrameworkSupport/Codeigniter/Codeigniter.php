<?php namespace Infusionsoft\FrameworkSupport\Codeigniter;

use Infusionsoft;

class Codeigniter {
    
    
    public function setvariables() {
        
            $infusionsoft = new Infusionsoft\Infusionsoft(array(
                    'clientId'     => env('INFUSIONSOFT_CLIENT_ID'),
                    'clientSecret' => env('INFUSIONSOFT_SECRET'),
                    'redirectUri'  => env('INFUSIONSOFT_REDIRECT')
                ));
            
        
            return($infusionsoft);
            
        } 
}