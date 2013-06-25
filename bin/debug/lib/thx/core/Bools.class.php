<?php

class thx_core_Bools {
	public function __construct(){}
	static function format($v, $param = null, $params = null, $culture = null) {
		return call_user_func_array(thx_core_Bools::formatf($param, $params, $culture), array($v));
	}
	static function formatf($param = null, $params = null, $culture = null) {
		$params = thx_culture_FormatParams::params($param, $params, "B");
		$format = $params->shift();
		switch($format) {
		case "B":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Bools_0"), 'execute');
		}break;
		case "N":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Bools_1"), 'execute');
		}break;
		case "R":{
			if($params->length !== 2) {
				throw new HException("bool format R requires 2 parameters");
			}
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Bools_2"), 'execute');
		}break;
		default:{
			throw new HException("Unsupported bool format: " . _hx_string_or_null($format));
		}break;
		}
	}
	static function interpolate($v, $a, $b, $equation = null) {
		return call_user_func_array(thx_core_Bools::interpolatef($a, $b, $equation), array($v));
	}
	static function interpolatef($a, $b, $equation = null) {
		if($a === $b) {
			return array(new _hx_lambda(array(&$a, &$b, &$equation), "thx_core_Bools_3"), 'execute');
		} else {
			$f = thx_core_Floats::interpolatef(0, 1, $equation);
			return array(new _hx_lambda(array(&$a, &$b, &$equation, &$f), "thx_core_Bools_4"), 'execute');
		}
	}
	static function canParse($s) {
		$s = strtolower($s);
		return $s === "true" || $s === "false";
	}
	static function parse($s) {
		return strtolower($s) === "true";
	}
	static function compare($a, $b) {
		return (($a === $b) ? 0 : (($a) ? -1 : 1));
	}
	function __toString() { return 'thx.core.Bools'; }
}
function thx_core_Bools_0(&$culture, &$format, &$param, &$params, $v) {
	{
		return (($v) ? "true" : "false");
	}
}
function thx_core_Bools_1(&$culture, &$format, &$param, &$params, $v) {
	{
		return (($v) ? "1" : "0");
	}
}
function thx_core_Bools_2(&$culture, &$format, &$param, &$params, $v) {
	{
		return thx_core_Bools_5($culture, $format, $param, $params, $v);
	}
}
function thx_core_Bools_3(&$a, &$b, &$equation, $_) {
	{
		return $a;
	}
}
function thx_core_Bools_4(&$a, &$b, &$equation, &$f, $v) {
	{
		return ((call_user_func_array($f, array($v)) < 0.5) ? $a : $b);
	}
}
function thx_core_Bools_5(&$culture, &$format, &$param, &$params, &$v) {
	if($v) {
		return $params[0];
	} else {
		return $params[1];
	}
}
