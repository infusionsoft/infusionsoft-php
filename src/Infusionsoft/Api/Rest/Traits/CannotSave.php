<?php namespace Infusionsoft\Api\Rest\Traits;

use Infusionsoft\InfusionsoftException;

trait CannotSave {

	public function save() {
		throw new InfusionsoftException(
			__CLASS__.' cannot use '.__FUNCTION__.' function.'
		);
	}

}