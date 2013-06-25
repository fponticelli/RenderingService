<?php

class php_Lib {
	public function __construct(){}
	static function hprint($v) {
		echo(Std::string($v));
	}
	static function serialize($v) {
		return serialize($v);
	}
	static function unserialize($s) {
		return unserialize($s);
	}
	static function hashOfAssociativeArray($arr) {
		$h = new haxe_ds_StringMap();
		$h->h = $arr;
		return $h;
	}
	static function objectOfAssociativeArray($arr) {
		foreach($arr as $key => $value){
			if(is_array($value)) $arr[$key] = php_Lib::objectOfAssociativeArray($value);
		}
		return _hx_anonymous($arr);
	}
	static function associativeArrayOfObject($ob) {
		return (array) $ob;
	}
	static function rethrow($e) {
		if(Std::is($e, _hx_qtype("php.Exception"))) {
			$__rtex__ = $e;
			throw $__rtex__;
		} else {
			throw new HException($e);
		}
	}
	function __toString() { return 'php.Lib'; }
}
