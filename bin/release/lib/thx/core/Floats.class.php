<?php

class thx_core_Floats {
	public function __construct(){}
	static function normalize($v) {
		if($v < 0.0) {
			return 0.0;
		} else {
			if($v > 1.0) {
				return 1.0;
			} else {
				return $v;
			}
		}
	}
	static function clamp($v, $min, $max) {
		if($v < $min) {
			return $min;
		} else {
			if($v > $max) {
				return $max;
			} else {
				return $v;
			}
		}
	}
	static function clampSym($v, $max) {
		if($v < -$max) {
			return -$max;
		} else {
			if($v > $max) {
				return $max;
			} else {
				return $v;
			}
		}
	}
	static function range($start, $stop = null, $step = null, $inclusive = null, $round = null) {
		if($round === null) {
			$round = false;
		}
		if($inclusive === null) {
			$inclusive = false;
		}
		if($step === null) {
			$step = 1.0;
		}
		if(null === $stop) {
			$stop = $start;
			$start = 0.0;
		}
		if(($stop - $start) / $step === Math::$POSITIVE_INFINITY) {
			throw new HException(new thx_error_Error("infinite range", null, null, _hx_anonymous(array("fileName" => "Floats.hx", "lineNumber" => 52, "className" => "thx.core.Floats", "methodName" => "range"))));
		}
		$range = new _hx_array(array()); $i = -1.0; $j = null; $increment = null;
		$increment = thx_core_Floats_0($i, $inclusive, $increment, $j, $range, $round, $start, $step, $stop);
		if($inclusive) {
			if($step < 0) {
				while(call_user_func($increment) >= $stop) {
					$range->push($j);
				}
			} else {
				while(call_user_func($increment) <= $stop) {
					$range->push($j);
				}
			}
		} else {
			if($step < 0) {
				while(call_user_func($increment) > $stop) {
					$range->push($j);
				}
			} else {
				while(call_user_func($increment) < $stop) {
					$range->push($j);
				}
			}
		}
		return $range;
	}
	static function sign($v) {
		return (($v < 0) ? -1 : 1);
	}
	static function abs($a) {
		return (($a < 0) ? -$a : $a);
	}
	static function min($a, $b) {
		return (($a < $b) ? $a : $b);
	}
	static function max($a, $b) {
		return (($a > $b) ? $a : $b);
	}
	static function wrap($v, $min, $max) {
		$range = $max - $min + 1;
		if($v < $min) {
			$v += $range * (($min - $v) / $range + 1);
		}
		return $min + _hx_mod(($v - $min), $range);
	}
	static function circularWrap($v, $max) {
		$v = _hx_mod($v, $max);
		if($v < 0) {
			$v += $max;
		}
		return $v;
	}
	static function interpolate($f, $a = null, $b = null, $equation = null) {
		if($b === null) {
			$b = 1.0;
		}
		if($a === null) {
			$a = 0.0;
		}
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return $a + call_user_func_array($equation, array($f)) * ($b - $a);
	}
	static function interpolatef($a = null, $b = null, $equation = null) {
		if($b === null) {
			$b = 1.0;
		}
		if($a === null) {
			$a = 0.0;
		}
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		$d = $b - $a;
		return array(new _hx_lambda(array(&$a, &$b, &$d, &$equation), "thx_core_Floats_1"), 'execute');
	}
	static function interpolateClampf($min, $max, $equation = null) {
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return array(new _hx_lambda(array(&$equation, &$max, &$min), "thx_core_Floats_2"), 'execute');
	}
	static function format($v, $param = null, $params = null, $culture = null) {
		return call_user_func_array(thx_core_Floats::formatf($param, $params, $culture), array($v));
	}
	static function formatf($param = null, $params = null, $culture = null) {
		$params = thx_culture_FormatParams::params($param, $params, "D");
		$format = $params->shift();
		$decimals = (($params->length > 0) ? Std::parseInt($params[0]) : null);
		switch($format) {
		case "D":{
			return array(new _hx_lambda(array(&$culture, &$decimals, &$format, &$param, &$params), "thx_core_Floats_3"), 'execute');
		}break;
		case "I":{
			return array(new _hx_lambda(array(&$culture, &$decimals, &$format, &$param, &$params), "thx_core_Floats_4"), 'execute');
		}break;
		case "C":{
			$s = thx_core_Floats_5($culture, $decimals, $format, $param, $params);
			return array(new _hx_lambda(array(&$culture, &$decimals, &$format, &$param, &$params, &$s), "thx_core_Floats_6"), 'execute');
		}break;
		case "P":{
			return array(new _hx_lambda(array(&$culture, &$decimals, &$format, &$param, &$params), "thx_core_Floats_7"), 'execute');
		}break;
		case "M":{
			return array(new _hx_lambda(array(&$culture, &$decimals, &$format, &$param, &$params), "thx_core_Floats_8"), 'execute');
		}break;
		default:{
			thx_core_Floats_9($culture, $decimals, $format, $param, $params);
		}break;
		}
	}
	static $_reparse;
	static $_reparseStrict;
	static function canParse($s, $strict = null) {
		if($strict === null) {
			$strict = false;
		}
		if($strict) {
			return thx_core_Floats::$_reparseStrict->match($s);
		} else {
			return thx_core_Floats::$_reparse->match($s);
		}
	}
	static function parse($s) {
		if(_hx_substr($s, 0, 1) === "+") {
			$s = _hx_substr($s, 1, null);
		}
		return Std::parseFloat($s);
	}
	static function compare($a, $b) {
		return (($a < $b) ? -1 : (($a > $b) ? 1 : 0));
	}
	static function isNumeric($v) {
		return Std::is($v, _hx_qtype("Float")) || Std::is($v, _hx_qtype("Int"));
	}
	static function equals($a, $b, $approx = null) {
		if($approx === null) {
			$approx = 1e-5;
		}
		if(Math::isNaN($a)) {
			return Math::isNaN($b);
		} else {
			if(Math::isNaN($b)) {
				return false;
			} else {
				if(!Math::isFinite($a) && !Math::isFinite($b)) {
					return ($a > 0) == $b > 0;
				}
			}
		}
		return Math::abs($b - $a) < $approx;
	}
	static function uninterpolatef($a, $b) {
		$b = 1 / ($b - $a);
		return array(new _hx_lambda(array(&$a, &$b), "thx_core_Floats_10"), 'execute');
	}
	static function uninterpolateClampf($a, $b) {
		$b = 1 / ($b - $a);
		return array(new _hx_lambda(array(&$a, &$b), "thx_core_Floats_11"), 'execute');
	}
	static function round($number, $precision = null) {
		if($precision === null) {
			$precision = 2;
		}
		$number *= Math::pow(10, $precision);
		return Math::round($number) / Math::pow(10, $precision);
	}
	function __toString() { return 'thx.core.Floats'; }
}
thx_core_Floats::$_reparse = new EReg("^[+\\-]?(?:0|[1-9]\\d*)(?:\\.\\d*)?(?:[eE][+\\-]?\\d+)?", "");
thx_core_Floats::$_reparseStrict = new EReg("^[+\\-]?(?:0|[1-9]\\d*)(?:\\.\\d*)?(?:[eE][+\\-]?\\d+)?\$", "");
function thx_core_Floats_0(&$i, &$inclusive, &$increment, &$j, &$range, &$round, &$start, &$step, &$stop) {
	if($round) {
		return array(new _hx_lambda(array(&$i, &$inclusive, &$increment, &$j, &$range, &$round, &$start, &$step, &$stop), "thx_core_Floats_12"), 'execute');
	} else {
		return array(new _hx_lambda(array(&$i, &$inclusive, &$increment, &$j, &$range, &$round, &$start, &$step, &$stop), "thx_core_Floats_13"), 'execute');
	}
}
function thx_core_Floats_1(&$a, &$b, &$d, &$equation, $f) {
	{
		return $a + call_user_func_array($equation, array($f)) * $d;
	}
}
function thx_core_Floats_2(&$equation, &$max, &$min, $a, $b) {
	{
		$d = $b - $a;
		return array(new _hx_lambda(array(&$a, &$b, &$d, &$equation, &$max, &$min), "thx_core_Floats_14"), 'execute');
	}
}
function thx_core_Floats_3(&$culture, &$decimals, &$format, &$param, &$params, $v) {
	{
		return thx_culture_FormatNumber::decimal($v, $decimals, $culture);
	}
}
function thx_core_Floats_4(&$culture, &$decimals, &$format, &$param, &$params, $v) {
	{
		return thx_culture_FormatNumber::int($v, $culture);
	}
}
function thx_core_Floats_5(&$culture, &$decimals, &$format, &$param, &$params) {
	if($params->length > 1) {
		return $params[1];
	}
}
function thx_core_Floats_6(&$culture, &$decimals, &$format, &$param, &$params, &$s, $v) {
	{
		return thx_culture_FormatNumber::currency($v, $s, $decimals, $culture);
	}
}
function thx_core_Floats_7(&$culture, &$decimals, &$format, &$param, &$params, $v) {
	{
		return thx_culture_FormatNumber::percent($v, $decimals, $culture);
	}
}
function thx_core_Floats_8(&$culture, &$decimals, &$format, &$param, &$params, $v) {
	{
		return thx_culture_FormatNumber::permille($v, $decimals, $culture);
	}
}
function thx_core_Floats_9(&$culture, &$decimals, &$format, &$param, &$params) {
	throw new HException(new thx_error_Error("Unsupported number format: {0}", null, $format, _hx_anonymous(array("fileName" => "Floats.hx", "lineNumber" => 167, "className" => "thx.core.Floats", "methodName" => "formatf"))));
}
function thx_core_Floats_10(&$a, &$b, $x) {
	{
		return ($x - $a) * $b;
	}
}
function thx_core_Floats_11(&$a, &$b, $x) {
	{
		return thx_core_Floats::clamp(($x - $a) * $b, 0.0, 1.0);
	}
}
function thx_core_Floats_12(&$i, &$inclusive, &$increment, &$j, &$range, &$round, &$start, &$step, &$stop) {
	{
		$dec = _hx_explode(".", ("" . _hx_string_rec($step, "")))->pop(); $precision = thx_core_Floats_15($dec, $i, $inclusive, $increment, $j, $range, $round, $start, $step, $stop);
		$increment = array(new _hx_lambda(array(&$dec, &$i, &$inclusive, &$increment, &$j, &$precision, &$range, &$round, &$start, &$step, &$stop), "thx_core_Floats_16"), 'execute');
		return call_user_func($increment);
	}
}
function thx_core_Floats_13(&$i, &$inclusive, &$increment, &$j, &$range, &$round, &$start, &$step, &$stop) {
	{
		return $j = $start + $step * ++$i;
	}
}
function thx_core_Floats_14(&$a, &$b, &$d, &$equation, &$max, &$min, $f) {
	{
		return $a + call_user_func_array($equation, array(thx_core_Floats::clamp($f, $min, $max))) * $d;
	}
}
function thx_core_Floats_15(&$dec, &$i, &$inclusive, &$increment, &$j, &$range, &$round, &$start, &$step, &$stop) {
	if($dec === "0") {
		return 0;
	} else {
		return strlen($dec);
	}
}
function thx_core_Floats_16(&$dec, &$i, &$inclusive, &$increment, &$j, &$precision, &$range, &$round, &$start, &$step, &$stop) {
	{
		return $j = thx_core_Floats::round($start + $step * ++$i, $precision);
	}
}
