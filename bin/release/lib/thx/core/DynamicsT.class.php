<?php

class thx_core_DynamicsT {
	public function __construct(){}
	static function toMap($ob) {
		$map = new haxe_ds_StringMap();
		return thx_core_DynamicsT::copyToMap($ob, $map);
	}
	static function copyToMap($ob, $map) {
		{
			$_g = 0; $_g1 = Reflect::fields($ob);
			while($_g < $_g1->length) {
				$field = $_g1[$_g];
				++$_g;
				$value = Reflect::field($ob, $field);
				$map->set($field, $value);
				unset($value,$field);
			}
		}
		return $map;
	}
	function __toString() { return 'thx.core.DynamicsT'; }
}
