<?php namespace Plateau\Mezzanine;

use Illuminate\Support\Facades\HTML;
use Config;

/**
 * Mezzanine Asset Manager
 */
class Mezzanine {


	protected $containers = array();

	
	public function container($container = 'default')
	{
		if ( ! isset($this->containers[$container]))
		{
			$this->containers[$container] = new MezzanineContainer($container);
		}
		return $this->containers[$container];
	}

	
	public function __call($method, $parameters)
	{
		return call_user_func_array(array($this->container(), $method), $parameters);
	}

}

	