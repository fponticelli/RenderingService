<?php

class thx_core_Enums {
	public function __construct(){}
	static function string($e) {
		$cons = Type::enumConstructor($e);
		$params = new _hx_array(array());
		{
			$_g = 0; $_g1 = Type::enumParameters($e);
			while($_g < $_g1->length) {
				$param = $_g1[$_g];
				++$_g;
				$params->push(thx_core_Dynamics::string($param));
				unset($param);
			}
		}
		return _hx_string_or_null($cons) . _hx_string_or_null((thx_core_Enums_0($cons, $e, $params)));
	}
	static function compare($a, $b) {
		$v = null;
		if(($v = thx_core_Enums_1($a, $b, $v) - thx_core_Enums_2($a, $b, $v)) !== 0) {
			return $v;
		}
		return thx_core_Arrays::compare(Type::enumParameters($a), Type::enumParameters($b));
	}
	function __toString() { return 'thx.core.Enums'; }
}
function thx_core_Enums_0(&$cons, &$e, &$params) {
	if($params->length === 0) {
		return "";
	} else {
		return "(" . _hx_string_or_null($params->join(", ")) . ")";
	}
}
function thx_core_Enums_1(&$a, &$b, &$v) {
	{
		$e = $a;
		return $e->index;
	}
}
function thx_core_Enums_2(&$a, &$b, &$v) {
	{
		$e = $b;
		return $e->index;
	}
}
