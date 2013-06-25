<?php

class thx_culture_Culture extends thx_culture_Info {
	public $percent;
	public $currency;
	public $number;
	public $symbolPosInf;
	public $symbolNegInf;
	public $symbolPermille;
	public $symbolPercent;
	public $symbolNaN;
	public $signPos;
	public $signNeg;
	public $digits;
	public $isMetric;
	public $nativeRegion;
	public $englishRegion;
	public $currencyIso;
	public $currencySymbol;
	public $nativeCurrency;
	public $englishCurrency;
	public $date;
	public $language;
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->__dynamics[$m]) && is_callable($this->__dynamics[$m]))
			return call_user_func_array($this->__dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call <'.$m.'>');
	}
	static $cultures;
	static function get_cultures() {
		if(null === thx_culture_Culture::$cultures) {
			thx_culture_Culture::$cultures = new haxe_ds_StringMap();
		}
		return thx_culture_Culture::$cultures;
	}
	static function get($name) {
		return thx_culture_Culture::get_cultures()->get(strtolower($name));
	}
	static function names() {
		return thx_culture_Culture::get_cultures()->keys();
	}
	static function exists($culture) {
		return thx_culture_Culture::get_cultures()->exists(strtolower($culture));
	}
	static $_defaultCulture;
	static function get_defaultCulture() {
		if(null === thx_culture_Culture::$_defaultCulture) {
			return thx_cultures_EnUS::get_culture();
		} else {
			return thx_culture_Culture::$_defaultCulture;
		}
	}
	static function set_defaultCulture($culture) {
		return thx_culture_Culture::$_defaultCulture = $culture;
	}
	static function add($culture) {
		if(null === thx_culture_Culture::$_defaultCulture) {
			thx_culture_Culture::$_defaultCulture = $culture;
		}
		$name = strtolower($culture->name);
		if(!thx_culture_Culture::get_cultures()->exists($name)) {
			thx_culture_Culture::get_cultures()->set($name, $culture);
		}
	}
	static function loadAll() {
		$dir = _hx_string_or_null(Sys::getCwd()) . "lib/thx/cultures/";
		{
			$_g = 0; $_g1 = sys_FileSystem::readDirectory($dir);
			while($_g < $_g1->length) {
				$file = $_g1[$_g];
				++$_g;
				require_once(_hx_string_or_null($dir) . _hx_string_or_null($file));
				unset($file);
			}
		}
	}
	static $__properties__ = array("set_defaultCulture" => "set_defaultCulture","get_defaultCulture" => "get_defaultCulture","get_cultures" => "get_cultures");
	function __toString() { return 'thx.culture.Culture'; }
}
