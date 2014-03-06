<?php namespace Plateau\Mezzanine\Facades;

use Illuminate\Support\Facades\Facade;

class Mezzanine extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'mezzanine'; }

}