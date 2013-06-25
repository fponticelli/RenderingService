<?php

class thx_culture_FormatNumber {
	public function __construct(){}
	static function decimal($v, $decimals = null, $culture = null) {
		if(null === $culture) {
			$culture = thx_culture_Culture::get_defaultCulture();
		}
		return thx_culture_FormatNumber::crunch($v, $decimals, $culture->percent, $culture->number->patternNegative, $culture->number->patternPositive, $culture, null, null);
	}
	static function percent($v, $decimals = null, $culture = null) {
		if(null === $culture) {
			$culture = thx_culture_Culture::get_defaultCulture();
		}
		return thx_culture_FormatNumber::crunch($v, $decimals, $culture->percent, $culture->percent->patternNegative, $culture->percent->patternPositive, $culture, "%", $culture->symbolPercent);
	}
	static function permille($v, $decimals = null, $culture = null) {
		if(null === $culture) {
			$culture = thx_culture_Culture::get_defaultCulture();
		}
		return thx_culture_FormatNumber::crunch($v, $decimals, $culture->percent, $culture->percent->patternNegative, $culture->percent->patternPositive, $culture, "%", $culture->symbolPermille);
	}
	static function currency($v, $symbol = null, $decimals = null, $culture = null) {
		if(null === $culture) {
			$culture = thx_culture_Culture::get_defaultCulture();
		}
		return thx_culture_FormatNumber::crunch($v, $decimals, $culture->currency, $culture->currency->patternNegative, $culture->currency->patternPositive, $culture, "\$", thx_culture_FormatNumber_0($culture, $decimals, $symbol, $v));
	}
	static function int($v, $culture = null) {
		if(null === $culture) {
			$culture = thx_culture_Culture::get_defaultCulture();
		}
		return thx_culture_FormatNumber::decimal($v, 0, $culture);
	}
	static function digits($v, $culture = null) {
		if(null === $culture) {
			$culture = thx_culture_Culture::get_defaultCulture();
		}
		return thx_culture_FormatNumber::processDigits($v, $culture->digits);
	}
	static function crunch($v, $decimals, $info, $negative, $positive, $culture, $symbol, $replace) {
		if(Math::isNaN($v)) {
			return $culture->symbolNaN;
		} else {
			if(!Math::isFinite($v)) {
				return thx_culture_FormatNumber_1($culture, $decimals, $info, $negative, $positive, $replace, $symbol, $v);
			}
		}
		$fv = thx_culture_FormatNumber::value($v, $info, thx_culture_FormatNumber_2($culture, $decimals, $info, $negative, $positive, $replace, $symbol, $v), $culture->digits);
		if($symbol !== null) {
			return thx_culture_FormatNumber_3($culture, $decimals, $fv, $info, $negative, $positive, $replace, $symbol, $v);
		} else {
			return thx_culture_FormatNumber_4($culture, $decimals, $fv, $info, $negative, $positive, $replace, $symbol, $v);
		}
	}
	static function processDigits($s, $digits) {
		if($digits === null) {
			return $s;
		}
		$o = new _hx_array(array());
		{
			$_g1 = 0; $_g = strlen($s);
			while($_g1 < $_g) {
				$i = $_g1++;
				$o->push($digits[Std::parseInt(_hx_substr($s, $i, 1))]);
				unset($i);
			}
		}
		return $o->join("");
	}
	static function value($v, $info, $decimals, $digits) {
		$fv = "" . _hx_string_rec(Math::abs($v), "");
		$pos = _hx_index_of($fv, "E", null);
		if($pos > 0) {
			$e = Std::parseInt(_hx_substr($fv, $pos + 1, null));
			$ispos = true;
			if($e < 0) {
				$ispos = false;
				$e = -$e;
			}
			$s = thx_culture_FormatNumber_5($decimals, $digits, $e, $fv, $info, $ispos, $pos, $v);
			if($ispos) {
				$fv = thx_culture_FormatNumber_6($decimals, $digits, $e, $fv, $info, $ispos, $pos, $s, $v);
			} else {
				$fv = "0" . _hx_string_or_null((((strlen("0") === 0 || strlen(".") >= $e) ? "." : str_pad(".", Math::ceil(($e - strlen(".")) / strlen("0")) * strlen("0") + strlen("."), "0", STR_PAD_RIGHT)))) . _hx_string_or_null($s);
			}
		}
		$parts = _hx_explode(".", $fv);
		$temp = $parts[0];
		$intparts = new _hx_array(array());
		$group = 0;
		while(true) {
			if(strlen($temp) === 0) {
				break;
			}
			$len = $info->groups[$group];
			if(strlen($temp) <= $len) {
				$intparts->unshift(thx_culture_FormatNumber::processDigits($temp, $digits));
				break;
			}
			$intparts->unshift(thx_culture_FormatNumber::processDigits(_hx_substr($temp, -$len, null), $digits));
			$temp = _hx_substr($temp, 0, -$len);
			if($group < $info->groups->length - 1) {
				$group++;
			}
			unset($len);
		}
		$intpart = $intparts->join($info->groupsSeparator);
		if($decimals > 0) {
			$decpart = thx_culture_FormatNumber_7($decimals, $digits, $fv, $group, $info, $intpart, $intparts, $parts, $pos, $temp, $v);
			return _hx_string_or_null($intpart) . _hx_string_or_null($info->decimalsSeparator) . _hx_string_or_null(thx_culture_FormatNumber::processDigits($decpart, $digits));
		} else {
			return $intpart;
		}
	}
	function __toString() { return 'thx.culture.FormatNumber'; }
}
function thx_culture_FormatNumber_0(&$culture, &$decimals, &$symbol, &$v) {
	if($symbol === null) {
		return $culture->currencySymbol;
	} else {
		return $symbol;
	}
}
function thx_culture_FormatNumber_1(&$culture, &$decimals, &$info, &$negative, &$positive, &$replace, &$symbol, &$v) {
	if($v === Math::$NEGATIVE_INFINITY) {
		return $culture->symbolNegInf;
	} else {
		return $culture->symbolPosInf;
	}
}
function thx_culture_FormatNumber_2(&$culture, &$decimals, &$info, &$negative, &$positive, &$replace, &$symbol, &$v) {
	if($decimals === null) {
		return $info->decimals;
	} else {
		if($decimals < 0) {
			return 0;
		} else {
			return $decimals;
		}
	}
}
function thx_culture_FormatNumber_3(&$culture, &$decimals, &$fv, &$info, &$negative, &$positive, &$replace, &$symbol, &$v) {
	{
		$s = thx_culture_FormatNumber_8($culture, $decimals, $fv, $info, $negative, $positive, $replace, $symbol, $v);
		if($symbol === "") {
			return implode(str_split ($s), $replace);
		} else {
			return str_replace($symbol, $replace, $s);
		}
		unset($s);
	}
}
function thx_culture_FormatNumber_4(&$culture, &$decimals, &$fv, &$info, &$negative, &$positive, &$replace, &$symbol, &$v) {
	{
		$s = (($v < 0) ? $negative : $positive);
		return str_replace("n", $fv, $s);
	}
}
function thx_culture_FormatNumber_5(&$decimals, &$digits, &$e, &$fv, &$info, &$ispos, &$pos, &$v) {
	{
		$s1 = _hx_substr($fv, 0, $pos);
		return str_replace(".", "", $s1);
	}
}
function thx_culture_FormatNumber_6(&$decimals, &$digits, &$e, &$fv, &$info, &$ispos, &$pos, &$s, &$v) {
	{
		$l = $e + 1;
		if(strlen("0") === 0 || strlen($s) >= $l) {
			return $s;
		} else {
			return str_pad($s, Math::ceil(($l - strlen($s)) / strlen("0")) * strlen("0") + strlen($s), "0", STR_PAD_RIGHT);
		}
		unset($l);
	}
}
function thx_culture_FormatNumber_7(&$decimals, &$digits, &$fv, &$group, &$info, &$intpart, &$intparts, &$parts, &$pos, &$temp, &$v) {
	if($parts->length === 1) {
		if(strlen("0") === 0 || strlen("") >= $decimals) {
			return "";
		} else {
			return str_pad("", Math::ceil(($decimals - strlen("")) / strlen("0")) * strlen("0") + strlen(""), "0", STR_PAD_LEFT);
		}
	} else {
		if(strlen($parts[1]) > $decimals) {
			return _hx_substr($parts[1], 0, $decimals);
		} else {
			$s = $parts[1];
			if(strlen("0") === 0 || strlen($s) >= $decimals) {
				return $s;
			} else {
				return str_pad($s, Math::ceil(($decimals - strlen($s)) / strlen("0")) * strlen("0") + strlen($s), "0", STR_PAD_RIGHT);
			}
			unset($s);
		}
	}
}
function thx_culture_FormatNumber_8(&$culture, &$decimals, &$fv, &$info, &$negative, &$positive, &$replace, &$symbol, &$v) {
	{
		$s1 = (($v < 0) ? $negative : $positive);
		return str_replace("n", $fv, $s1);
	}
}
