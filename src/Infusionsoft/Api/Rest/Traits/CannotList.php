<?php namespace Infusionsoft\Api\Rest\Traits;

use Infusionsoft\InfusionsoftException;

trait CannotList {

    public function all() {
        throw new InfusionsoftException(
            __CLASS__.' cannot use '.__FUNCTION__.' function.'
        );
    }

}