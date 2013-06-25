<?php

class thx_core_Ints {
	public function __construct(){}
	static function range($start, $stop = null, $step = null) {
		if($step === null) {
			$step = 1;
		}
		if(null === $stop) {
			$stop = $start;
			$start = 0;
		}
		if(($stop - $start) / $step === Math::$POSITIVE_INFINITY) {
			throw new HException(new thx_error_Error("infinite range", null, null, _hx_anonymous(array("fileName" => "Ints.hx", "lineNumber" => 21, "className" => "thx.core.Ints", "methodName" => "range"))));
		}
		$range = new _hx_array(array()); $i = -1; $j = null;
		if($step < 0) {
			while(($j = $start + $step * ++$i) > $stop) {
				$range->push($j);
			}
		} else {
			while(($j = $start + $step * ++$i) < $stop) {
				$range->push($j);
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
		return Math::round(thx_core_Floats::wrap($v, $min, $max));
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
	static function interpolate($f, $min = null, $max = null, $equation = null) {
		if($max === null) {
			$max = 100.0;
		}
		if($min === null) {
			$min = 0.0;
		}
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round($min + call_user_func_array($equation, array($f)) * ($max - $min));
	}
	static function interpolatef($min = null, $max = null, $equation = null) {
		if($max === null) {
			$max = 1.0;
		}
		if($min === null) {
			$min = 0.0;
		}
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		$d = $max - $min;
		return array(new _hx_lambda(array(&$d, &$equation, &$max, &$min), "thx_core_Ints_0"), 'execute');
	}
	static function format($v, $param = null, $params = null, $culture = null) {
		return call_user_func_array(thx_core_Ints::formatf($param, $params, $culture), array($v));
	}
	static function formatf($param = null, $params = null, $culture = null) {
		return thx_core_Floats::formatf(null, thx_culture_FormatParams::params($param, $params, "I"), $culture);
	}
	static $_reparse;
	static function canParse($s) {
		return thx_core_Ints::$_reparse->match($s);
	}
	static function parse($s) {
		if(_hx_substr($s, 0, 1) === "+") {
			$s = _hx_substr($s, 1, null);
		}
		return Std::parseInt($s);
	}
	static function compare($a, $b) {
		return $a - $b;
	}
	function __toString() { return 'thx.core.Ints'; }
}
thx_core_Ints::$_reparse = new EReg("^([+-])?\\d+\$", "");
function thx_core_Ints_0(&$d, &$equation, &$max, &$min, $f) {
	{
		return Math::round($min + call_user_func_array($equation, array($f)) * $d);
	}
}
