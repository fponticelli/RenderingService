<?php

class thx_core_Strings {
	public function __construct(){}
	static $_re;
	static $_reSplitWC;
	static $_reReduceWS;
	static $_reFormat;
	static function format($pattern, $values, $nullstring = null, $culture = null) {
		if($nullstring === null) {
			$nullstring = "null";
		}
		if(null === $values || 0 === $values->length) {
			return $pattern;
		}
		return call_user_func_array(thx_core_Strings::formatf($pattern, $nullstring, $culture), array($values));
	}
	static function formatf($pattern, $nullstring = null, $culture = null) {
		if($nullstring === null) {
			$nullstring = "null";
		}
		$buf = new _hx_array(array());
		while(true) {
			if(!thx_core_Strings::$_reFormat->match($pattern)) {
				$buf->push(array(new _hx_lambda(array(&$buf, &$culture, &$nullstring, &$pattern), "thx_core_Strings_0"), 'execute'));
				break;
			}
			$pos = Std::parseInt(thx_core_Strings::$_reFormat->matched(1));
			$format = thx_core_Strings::$_reFormat->matched(2);
			if($format === "") {
				$format = null;
			}
			$p = null;
			$params = new _hx_array(array());
			{
				$_g = 3;
				while($_g < 20) {
					$i = $_g++;
					$p = thx_core_Strings::$_reFormat->matched($i);
					if($p === null || $p === "") {
						break;
					}
					$params->push(thx_culture_FormatParams::cleanQuotes($p));
					unset($i);
				}
				unset($_g);
			}
			$left = thx_core_Strings::$_reFormat->matchedLeft();
			$buf->push(array(new _hx_lambda(array(&$buf, &$culture, &$format, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos), "thx_core_Strings_1"), 'execute'));
			$df = thx_core_Dynamics::formatf($format, $params, $nullstring, $culture);
			$buf->push(thx_core_Strings_2($buf, $culture, $df, $format, $left, $nullstring, $p, $params, $pattern, $pos));
			$pattern = thx_core_Strings::$_reFormat->matchedRight();
			unset($pos,$params,$p,$left,$format,$df);
		}
		return array(new _hx_lambda(array(&$buf, &$culture, &$nullstring, &$pattern), "thx_core_Strings_3"), 'execute');
	}
	static function formatOne($v, $param = null, $params = null, $culture = null) {
		return call_user_func_array(thx_core_Strings::formatOnef($param, $params, $culture), array($v));
	}
	static function formatOnef($param = null, $params = null, $culture = null) {
		$params = thx_culture_FormatParams::params($param, $params, "S");
		$format = $params->shift();
		switch($format) {
		case "S":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Strings_4"), 'execute');
		}break;
		case "T":{
			$len = (($params->length < 1) ? 20 : Std::parseInt($params[0]));
			$ellipsis = thx_core_Strings_5($culture, $format, $len, $param, $params);
			return thx_core_Strings::ellipsisf($len, $ellipsis);
		}break;
		case "PR":{
			$len1 = (($params->length < 1) ? 10 : Std::parseInt($params[0]));
			$pad = thx_core_Strings_6($culture, $format, $len1, $param, $params);
			return array(new _hx_lambda(array(&$culture, &$format, &$len1, &$pad, &$param, &$params), "thx_core_Strings_7"), 'execute');
		}break;
		case "PL":{
			$len2 = (($params->length < 1) ? 10 : Std::parseInt($params[0]));
			$pad1 = thx_core_Strings_8($culture, $format, $len2, $param, $params);
			return array(new _hx_lambda(array(&$culture, &$format, &$len2, &$pad1, &$param, &$params), "thx_core_Strings_9"), 'execute');
		}break;
		default:{
			thx_core_Strings_10($culture, $format, $param, $params);
		}break;
		}
	}
	static function upTo($value, $searchFor) {
		$pos = _hx_index_of($value, $searchFor, null);
		if($pos < 0) {
			return $value;
		} else {
			return _hx_substr($value, 0, $pos);
		}
	}
	static function startFrom($value, $searchFor) {
		$pos = _hx_index_of($value, $searchFor, null);
		if($pos < 0) {
			return $value;
		} else {
			return _hx_substr($value, $pos + strlen($searchFor), null);
		}
	}
	static function rtrim($value, $charlist) {
		return rtrim($value, $charlist);
	}
	static function ltrim($value, $charlist) {
		return ltrim($value, $charlist);
	}
	static function trim($value, $charlist) {
		return trim($value, $charlist);
	}
	static $_reCollapse;
	static function collapse($value) {
		return thx_core_Strings::$_reCollapse->replace(trim($value), " ");
	}
	static function ucfirst($value) {
		return thx_core_Strings_11($value);
	}
	static function lcfirst($value) {
		return thx_core_Strings_12($value);
	}
	static function hempty($value) {
		return $value === null || $value === "";
	}
	static function isAlphaNum($value) {
		return ctype_alnum($value);
	}
	static function digitsOnly($value) {
		return ctype_digit($value);
	}
	static function ucwords($value) {
		return thx_core_Strings::$__ucwordsPattern->map(thx_core_Strings_13($value), (isset(thx_core_Strings::$__upperMatch) ? thx_core_Strings::$__upperMatch: array("thx_core_Strings", "__upperMatch")));
	}
	static function ucwordsws($value) {
		return ucwords($value);
	}
	static function __upperMatch($re) {
		return strtoupper($re->matched(0));
	}
	static $__ucwordsPattern;
	static function humanize($s) {
		return thx_core_Strings_14($s);
	}
	static function capitalize($s) {
		return _hx_string_or_null(strtoupper(_hx_substr($s, 0, 1))) . _hx_string_or_null(_hx_substr($s, 1, null));
	}
	static function succ($s) {
		return _hx_string_or_null(_hx_substr($s, 0, -1)) . _hx_string_or_null(chr(_hx_char_code_at(_hx_substr($s, -1, null), 0) + 1));
	}
	static function underscore($s) {
		$s = _hx_deref(new EReg("::", "g"))->replace($s, "/");
		$s = _hx_deref(new EReg("([A-Z]+)([A-Z][a-z])", "g"))->replace($s, "\$1_\$2");
		$s = _hx_deref(new EReg("([a-z\\d])([A-Z])", "g"))->replace($s, "\$1_\$2");
		$s = _hx_deref(new EReg("-", "g"))->replace($s, "_");
		return strtolower($s);
	}
	static function dasherize($s) {
		return str_replace("_", "-", $s);
	}
	static function repeat($s, $times) {
		$b = new _hx_array(array());
		{
			$_g = 0;
			while($_g < $times) {
				$i = $_g++;
				$b->push($s);
				unset($i);
			}
		}
		return $b->join("");
	}
	static function wrapColumns($s, $columns = null, $indent = null, $newline = null) {
		if($newline === null) {
			$newline = "\x0A";
		}
		if($indent === null) {
			$indent = "";
		}
		if($columns === null) {
			$columns = 78;
		}
		$parts = thx_core_Strings::$_reSplitWC->split($s);
		$result = new _hx_array(array());
		{
			$_g = 0;
			while($_g < $parts->length) {
				$part = $parts[$_g];
				++$_g;
				$result->push(thx_core_Strings::_wrapColumns(trim(thx_core_Strings::$_reReduceWS->replace($part, " ")), $columns, $indent, $newline));
				unset($part);
			}
		}
		return $result->join($newline);
	}
	static function _wrapColumns($s, $columns, $indent, $newline) {
		$parts = new _hx_array(array());
		$pos = 0;
		$len = strlen($s);
		$ilen = strlen($indent);
		$columns -= $ilen;
		while(true) {
			if($pos + $columns >= $len - $ilen) {
				$parts->push(_hx_substr($s, $pos, null));
				break;
			}
			$i = 0;
			while(!StringTools::isSpace($s, $pos + $columns - $i) && $i < $columns) {
				$i++;
			}
			if($i === $columns) {
				$i = 0;
				while(!StringTools::isSpace($s, $pos + $columns + $i) && $pos + $columns + $i < $len) {
					$i++;
				}
				$parts->push(_hx_substr($s, $pos, $columns + $i));
				$pos += $columns + $i + 1;
			} else {
				$parts->push(_hx_substr($s, $pos, $columns - $i));
				$pos += $columns - $i + 1;
			}
			unset($i);
		}
		return _hx_string_or_null($indent) . _hx_string_or_null($parts->join(_hx_string_or_null($newline) . _hx_string_or_null($indent)));
	}
	static function stripTags($s) {
		return strip_tags($s);
	}
	static $_reInterpolateNumber;
	static function interpolate($v, $a, $b, $equation = null) {
		return call_user_func_array(thx_core_Strings::interpolatef($a, $b, $equation), array($v));
	}
	static function interpolatef($a, $b, $equation = null) {
		$extract = array(new _hx_lambda(array(&$a, &$b, &$equation), "thx_core_Strings_15"), 'execute');
		$decimals = array(new _hx_lambda(array(&$a, &$b, &$equation, &$extract), "thx_core_Strings_16"), 'execute');
		$sa = new _hx_array(array()); $fa = new _hx_array(array()); $sb = new _hx_array(array()); $fb = new _hx_array(array());
		call_user_func_array($extract, array($a, $sa, $fa));
		call_user_func_array($extract, array($b, $sb, $fb));
		$functions = new _hx_array(array()); $i = 0;
		$min = thx_core_Strings_17($a, $b, $decimals, $equation, $extract, $fa, $fb, $functions, $i, $sa, $sb);
		while($i < $min) {
			if($sa[$i] !== $sb[$i]) {
				break;
			}
			if(null === $sa[$i]) {
				if($fa[$i] === $fb[$i]) {
					$s1 = "" . _hx_string_rec($fa[$i], "");
					$functions->push(array(new _hx_lambda(array(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$s1, &$sa, &$sb), "thx_core_Strings_18"), 'execute'));
					unset($s1);
				} else {
					$f1 = thx_core_Floats::interpolatef($fa[$i], $fb[$i], $equation);
					$dec = Math::pow(10, thx_core_Strings_19($a, $b, $decimals, $equation, $extract, $f1, $fa, $fb, $functions, $i, $min, $sa, $sb));
					$functions->push(array(new _hx_lambda(array(&$a, &$b, &$dec, &$decimals, &$equation, &$extract, &$f1, &$fa, &$fb, &$functions, &$i, &$min, &$sa, &$sb), "thx_core_Strings_20"), 'execute'));
					unset($f1,$dec);
				}
			} else {
				$s2 = $sa[$i];
				$functions->push(array(new _hx_lambda(array(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$s2, &$sa, &$sb), "thx_core_Strings_21"), 'execute'));
				unset($s2);
			}
			$i++;
		}
		$rest = "";
		while($i < $sb->length) {
			if(null !== $sb[$i]) {
				$rest .= _hx_string_or_null($sb[$i]);
			} else {
				$rest .= _hx_string_rec($fb[$i], "");
			}
			$i++;
		}
		if("" !== $rest) {
			$functions->push(array(new _hx_lambda(array(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$rest, &$sa, &$sb), "thx_core_Strings_22"), 'execute'));
		}
		return array(new _hx_lambda(array(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$rest, &$sa, &$sb), "thx_core_Strings_23"), 'execute');
	}
	static function interpolateChars($v, $a, $b, $equation = null) {
		return call_user_func_array(thx_core_Strings::interpolateCharsf($a, $b, $equation), array($v));
	}
	static function interpolateCharsf($a, $b, $equation = null) {
		$aa = _hx_explode("", $a); $ab = _hx_explode("", $b);
		while($aa->length > $ab->length) {
			$ab->insert(0, " ");
		}
		while($ab->length > $aa->length) {
			$aa->insert(0, " ");
		}
		$ai = new _hx_array(array());
		{
			$_g1 = 0; $_g = $aa->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$ai[$i] = thx_core_Strings::interpolateCharf($aa[$i], $ab[$i], null);
				unset($i);
			}
		}
		return array(new _hx_lambda(array(&$a, &$aa, &$ab, &$ai, &$b, &$equation), "thx_core_Strings_24"), 'execute');
	}
	static function interpolateChar($v, $a, $b, $equation = null) {
		return call_user_func_array(thx_core_Strings::interpolateCharf($a, $b, $equation), array($v));
	}
	static function interpolateCharf($a, $b, $equation = null) {
		if(_hx_deref(new EReg("^\\d", ""))->match($b) && $a === " ") {
			$a = "0";
		}
		$r = new EReg("^[^a-zA-Z0-9]", "");
		if($r->match($b) && $a === " ") {
			$a = $r->matched(0);
		}
		$ca = _hx_char_code_at($a, 0); $cb = _hx_char_code_at($b, 0); $i = thx_core_Ints::interpolatef($ca, $cb, $equation);
		return array(new _hx_lambda(array(&$a, &$b, &$ca, &$cb, &$equation, &$i, &$r), "thx_core_Strings_25"), 'execute');
	}
	static function ellipsis($s, $maxlen = null, $symbol = null) {
		if($symbol === null) {
			$symbol = "...";
		}
		if($maxlen === null) {
			$maxlen = 20;
		}
		if(strlen($s) > $maxlen) {
			return _hx_string_or_null(_hx_substr($s, 0, thx_core_Strings_26($maxlen, $s, $symbol))) . _hx_string_or_null($symbol);
		} else {
			return $s;
		}
	}
	static function ellipsisf($maxlen = null, $symbol = null) {
		if($symbol === null) {
			$symbol = "...";
		}
		if($maxlen === null) {
			$maxlen = 20;
		}
		return array(new _hx_lambda(array(&$maxlen, &$symbol), "thx_core_Strings_27"), 'execute');
	}
	static function compare($a, $b) {
		return (($a < $b) ? -1 : (($a > $b) ? 1 : 0));
	}
	function __toString() { return 'thx.core.Strings'; }
}
thx_core_Strings::$_re = new EReg("[{](\\d+)(?::[^}]*)?[}]", "m");
thx_core_Strings::$_reSplitWC = new EReg("(\x0D\x0A|\x0A\x0D|\x0A|\x0D)", "g");
thx_core_Strings::$_reReduceWS = new EReg("\\s+", "");
thx_core_Strings::$_reFormat = new EReg("{(\\d+)(?::([a-zA-Z]+))?(?:,([^\"',}]+|'[^']+'|\"[^\"]+\"))?(?:,([^\"',}]+|'[^']+'|\"[^\"]+\"))?(?:,([^\"',}]+|'[^']+'|\"[^\"]+\"))?}", "m");
thx_core_Strings::$_reCollapse = new EReg("\\s+", "g");
thx_core_Strings::$__ucwordsPattern = new EReg("[^a-zA-Z]([a-z])", "g");
thx_core_Strings::$_reInterpolateNumber = new EReg("[-+]?(?:\\d+\\.\\d+|\\d+\\.|\\.\\d+|\\d+)(?:[eE][-]?\\d+)?", "");
function thx_core_Strings_0(&$buf, &$culture, &$nullstring, &$pattern, $_) {
	{
		return $pattern;
	}
}
function thx_core_Strings_1(&$buf, &$culture, &$format, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos, $_) {
	{
		return $left;
	}
}
function thx_core_Strings_2(&$buf, &$culture, &$df, &$format, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos) {
	{
		$f = array(new _hx_lambda(array(&$buf, &$culture, &$df, &$format, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos), "thx_core_Strings_28"), 'execute'); $i1 = $pos;
		return array(new _hx_lambda(array(&$buf, &$culture, &$df, &$f, &$format, &$i1, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos), "thx_core_Strings_29"), 'execute');
	}
}
function thx_core_Strings_3(&$buf, &$culture, &$nullstring, &$pattern, $values) {
	{
		if(null === $values) {
			$values = new _hx_array(array());
		}
		return $buf->map(array(new _hx_lambda(array(&$buf, &$culture, &$nullstring, &$pattern, &$values), "thx_core_Strings_30"), 'execute'))->join("");
	}
}
function thx_core_Strings_4(&$culture, &$format, &$param, &$params, $v) {
	{
		return $v;
	}
}
function thx_core_Strings_5(&$culture, &$format, &$len, &$param, &$params) {
	if($params->length < 2) {
		return "...";
	} else {
		return $params[1];
	}
}
function thx_core_Strings_6(&$culture, &$format, &$len1, &$param, &$params) {
	if($params->length < 2) {
		return " ";
	} else {
		return $params[1];
	}
}
function thx_core_Strings_7(&$culture, &$format, &$len1, &$pad, &$param, &$params, $v) {
	{
		return ((strlen($pad) === 0 || strlen($v) >= $len1) ? $v : str_pad($v, Math::ceil(($len1 - strlen($v)) / strlen($pad)) * strlen($pad) + strlen($v), $pad, STR_PAD_RIGHT));
	}
}
function thx_core_Strings_8(&$culture, &$format, &$len2, &$param, &$params) {
	if($params->length < 2) {
		return " ";
	} else {
		return $params[1];
	}
}
function thx_core_Strings_9(&$culture, &$format, &$len2, &$pad1, &$param, &$params, $v) {
	{
		return ((strlen($pad1) === 0 || strlen($v) >= $len2) ? $v : str_pad($v, Math::ceil(($len2 - strlen($v)) / strlen($pad1)) * strlen($pad1) + strlen($v), $pad1, STR_PAD_LEFT));
	}
}
function thx_core_Strings_10(&$culture, &$format, &$param, &$params) {
	throw new HException("Unsupported string format: " . _hx_string_or_null($format));
}
function thx_core_Strings_11(&$value) {
	if($value === null) {
		return null;
	} else {
		return _hx_string_or_null(strtoupper(_hx_char_at($value, 0))) . _hx_string_or_null(_hx_substr($value, 1, null));
	}
}
function thx_core_Strings_12(&$value) {
	if($value === null) {
		return null;
	} else {
		return _hx_string_or_null(strtolower(_hx_char_at($value, 0))) . _hx_string_or_null(_hx_substr($value, 1, null));
	}
}
function thx_core_Strings_13(&$value) {
	if($value === null) {
		return null;
	} else {
		return _hx_string_or_null(strtoupper(_hx_char_at($value, 0))) . _hx_string_or_null(_hx_substr($value, 1, null));
	}
}
function thx_core_Strings_14(&$s) {
	{
		$s1 = thx_core_Strings::underscore($s);
		return str_replace("_", " ", $s1);
	}
}
function thx_core_Strings_15(&$a, &$b, &$equation, $value, $s, $f) {
	{
		while(thx_core_Strings::$_reInterpolateNumber->match($value)) {
			$left = thx_core_Strings::$_reInterpolateNumber->matchedLeft();
			if(!thx_core_Strings::hempty($left)) {
				$s->push($left);
				$f->push(null);
			}
			$s->push(null);
			$f->push(Std::parseFloat(thx_core_Strings::$_reInterpolateNumber->matched(0)));
			$value = thx_core_Strings::$_reInterpolateNumber->matchedRight();
			unset($left);
		}
		if(!thx_core_Strings::hempty($value)) {
			$s->push($value);
			$f->push(null);
		}
	}
}
function thx_core_Strings_16(&$a, &$b, &$equation, &$extract, $v) {
	{
		$s = "" . _hx_string_rec($v, ""); $p = _hx_index_of($s, ".", null);
		if($p < 0) {
			return 0;
		}
		return strlen($s) - $p - 1;
	}
}
function thx_core_Strings_17(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$sa, &$sb) {
	{
		$a1 = $sa->length; $b1 = $sb->length;
		if($a1 < $b1) {
			return $a1;
		} else {
			return $b1;
		}
		unset($b1,$a1);
	}
}
function thx_core_Strings_18(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$s1, &$sa, &$sb, $_) {
	{
		return $s1;
	}
}
function thx_core_Strings_19(&$a, &$b, &$decimals, &$equation, &$extract, &$f1, &$fa, &$fb, &$functions, &$i, &$min, &$sa, &$sb) {
	{
		$a1 = call_user_func_array($decimals, array($fa[$i])); $b1 = call_user_func_array($decimals, array($fb[$i]));
		if($a1 > $b1) {
			return $a1;
		} else {
			return $b1;
		}
		unset($b1,$a1);
	}
}
function thx_core_Strings_20(&$a, &$b, &$dec, &$decimals, &$equation, &$extract, &$f1, &$fa, &$fb, &$functions, &$i, &$min, &$sa, &$sb, $t) {
	{
		return "" . _hx_string_rec(Math::round(call_user_func_array($f1, array($t)) * $dec) / $dec, "");
	}
}
function thx_core_Strings_21(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$s2, &$sa, &$sb, $_) {
	{
		return $s2;
	}
}
function thx_core_Strings_22(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$rest, &$sa, &$sb, $_) {
	{
		return $rest;
	}
}
function thx_core_Strings_23(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$rest, &$sa, &$sb, $t1) {
	{
		return thx_core_Iterators::map($functions->iterator(), array(new _hx_lambda(array(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$rest, &$sa, &$sb, &$t1), "thx_core_Strings_31"), 'execute'))->join("");
	}
}
function thx_core_Strings_24(&$a, &$aa, &$ab, &$ai, &$b, &$equation, $v) {
	{
		$r = new _hx_array(array());
		{
			$_g1 = 0; $_g = $ai->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$r[$i] = call_user_func_array($ai[$i], array($v));
				unset($i);
			}
		}
		return trim($r->join(""));
	}
}
function thx_core_Strings_25(&$a, &$b, &$ca, &$cb, &$equation, &$i, &$r, $v) {
	{
		return chr(call_user_func_array($i, array($v)));
	}
}
function thx_core_Strings_26(&$maxlen, &$s, &$symbol) {
	{
		$a = strlen($symbol); $b = $maxlen - strlen($symbol);
		if($a > $b) {
			return $a;
		} else {
			return $b;
		}
		unset($b,$a);
	}
}
function thx_core_Strings_27(&$maxlen, &$symbol, $s) {
	{
		if(strlen($s) > $maxlen) {
			return _hx_string_or_null(_hx_substr($s, 0, thx_core_Strings_32($maxlen, $s, $symbol))) . _hx_string_or_null($symbol);
		} else {
			return $s;
		}
	}
}
function thx_core_Strings_28(&$buf, &$culture, &$df, &$format, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos, $i, $v) {
	{
		return call_user_func_array($df, array($v[$i]));
	}
}
function thx_core_Strings_29(&$buf, &$culture, &$df, &$f, &$format, &$i1, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos, $v) {
	{
		return call_user_func_array($f, array($i1, $v));
	}
}
function thx_core_Strings_30(&$buf, &$culture, &$nullstring, &$pattern, &$values, $df) {
	{
		return call_user_func_array($df, array($values));
	}
}
function thx_core_Strings_31(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$rest, &$sa, &$sb, &$t1, $f, $_) {
	{
		return call_user_func_array($f, array($t1));
	}
}
function thx_core_Strings_32(&$maxlen, &$s, &$symbol) {
	{
		$a = strlen($symbol); $b = $maxlen - strlen($symbol);
		if($a > $b) {
			return $a;
		} else {
			return $b;
		}
		unset($b,$a);
	}
}
