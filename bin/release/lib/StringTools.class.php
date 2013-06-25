<?php

class StringTools {
	public function __construct(){}
	static function htmlEscape($s, $quotes = null) {
		$s = _hx_explode(">", _hx_explode("<", _hx_explode("&", $s)->join("&amp;"))->join("&lt;"))->join("&gt;");
		return (($quotes) ? _hx_explode("'", _hx_explode("\"", $s)->join("&quot;"))->join("&#039;") : $s);
	}
	static function startsWith($s, $start) {
		return strlen($s) >= strlen($start) && _hx_substr($s, 0, strlen($start)) === $start;
	}
	static function endsWith($s, $end) {
		$elen = strlen($end);
		$slen = strlen($s);
		return $slen >= $elen && _hx_substr($s, $slen - $elen, $elen) === $end;
	}
	static function isSpace($s, $pos) {
		$c = _hx_char_code_at($s, $pos);
		return $c >= 9 && $c <= 13 || $c === 32;
	}
	static function hex($n, $digits = null) {
		$s = dechex($n); $len = 8;
		if(strlen($s) > (StringTools_0($digits, $len, $n, $s))) {
			$s = _hx_substr($s, -$len, null);
		} else {
			if($digits !== null) {
				$s = ((strlen("0") === 0 || strlen($s) >= $digits) ? $s : str_pad($s, Math::ceil(($digits - strlen($s)) / strlen("0")) * strlen("0") + strlen($s), "0", STR_PAD_LEFT));
			}
		}
		return strtoupper($s);
	}
	function __toString() { return 'StringTools'; }
}
function StringTools_0(&$digits, &$len, &$n, &$s) {
	if(null === $digits) {
		return $len;
	} else {
		return $len = (($digits > $len) ? $digits : $len);
	}
}
