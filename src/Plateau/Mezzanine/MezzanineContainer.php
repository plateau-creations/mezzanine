<?php
namespace Plateau\Mezzanine;
use Illuminate\Support\Facades\HTML;
use Illuminate\Support\Facades\Config;

class MezzanineContainer {
	
	/** 
	 * The asset container name.
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * All of the registered assets.
	 *
	 * @var array
	 */
	protected $assets = array();

	protected $isProduction;


	public function __construct($name)
	{
		$this->name = $name;
		$this->isProduction = Config::get('mezzanine::production');
	}	


	/**
	 * Setting assets
	 * */
	public function add($source, $productionSource = null)
	{
		$type = (pathinfo($source, PATHINFO_EXTENSION) == 'css') ? 'style' : 'script';

		return $this->$type($source, $productionSource);
	}
	
	public function style($source, $productionSource = null)
	{
		$this->register('style', $source, $productionSource);

		return $this;
	}

	public function script($source, $productionSource = null)
	{
		$this->register('script', $source, $productionSource);

		return $this;
	}

	protected function register($type, $source, $productionSource = null)
	{
		$this->assets[$type][] = compact('source', 'productionSource');
	}


	/*
	 	DUMPING ASSETS
	 */
	public function styles()
	{
		return $this->group('style');
	}

	public function scripts()
	{
		return $this->group('script');
	}

	protected function group($group)
	{
		if ( ! isset($this->assets[$group]) or count($this->assets[$group]) == 0) return '';

		$assets = '';

		foreach ($this->assets[$group] as $data)
		{
			
			$assets .= $this->asset($group,$data);
		}

		return $assets;
	}


	protected function asset($group, $asset)
	{
		if ($this->isProduction && $asset['productionSource'] != null)
		{
			$source = $asset['productionSource'];
		}
		else
		{
			$source = $asset['source'];
		}
		
		return HTML::$group($source);
	}
}