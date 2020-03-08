<?php namespace Infusionsoft\Api\Rest\Traits;

use Infusionsoft\InfusionsoftException;

trait CannotFind {

	public function find($id) {
		throw new InfusionsoftException(
			__CLASS__.' cannot use '.__FUNCTION__.' function.'
		);
	}

}