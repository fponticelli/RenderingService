<?php

class thx_text_ERegs {
	public function __construct(){}
	static $_escapePattern;
	static function escapeERegChars($s) {
		if(thx_text_ERegs::$_escapePattern->match($s)) {
			return thx_text_ERegs::$_escapePattern->map($s, array(new _hx_lambda(array(&$s), "thx_text_ERegs_0"), 'execute'));
		} else {
			return $s;
		}
	}
	function __toString() { return 'thx.text.ERegs'; }
}
thx_text_ERegs::$_escapePattern = new EReg("[\\*\\+\\?\\|\\{\\[\\(\\)\\^\\\$\\.# \\\\]", "g");
function thx_text_ERegs_0(&$s, $e) {
	{
		return "\\" . _hx_string_or_null($e->matched(0));
	}
}
