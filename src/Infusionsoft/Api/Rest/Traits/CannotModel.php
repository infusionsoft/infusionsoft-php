<?php namespace Infusionsoft\Api\Rest\Traits;

use Infusionsoft\InfusionsoftException;

trait CannotModel {

	public function model() {
		throw new InfusionsoftException(
			__CLASS__.' cannot use '.__FUNCTION__.' function.'
		);
	}

}