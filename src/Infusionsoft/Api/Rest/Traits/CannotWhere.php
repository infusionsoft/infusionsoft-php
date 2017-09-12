<?php namespace Infusionsoft\Api\Rest\Traits;

use Infusionsoft\InfusionsoftException;

trait CannotWhere {

	public function where() {
		throw new InfusionsoftException(
			__CLASS__.' cannot use '.__FUNCTION__.' function.'
		);
	}

}