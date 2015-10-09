<?php namespace Infusionsoft\FrameworkSupport\Laravel;

use Illuminate\Support\Facades\Facade;

class InfusionsoftFacade extends Facade {
	protected static function getFacadeAccessor() { return 'infusionsoft'; }
}