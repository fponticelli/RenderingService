<?php

class erazor_error_ParserError {
	public function __construct($msg, $pos, $excerpt = null) {
		if(!php_Boot::$skip_constructor) {
		$this->msg = $msg;
		$this->pos = $pos;
		$this->excerpt = $excerpt;
	}}
	public function toString() {
		$excerpt = $this->excerpt;
		if($excerpt !== null) {
			$nl = _hx_index_of($excerpt, "\x0A", null);
			if($nl !== -1) {
				$excerpt = _hx_substr($excerpt, 0, $nl);
			}
		}
		return _hx_string_or_null($this->msg) . " @ " . _hx_string_rec($this->pos, "") . _hx_string_or_null((erazor_error_ParserError_0($this, $excerpt)));
	}
	public $excerpt;
	public $pos;
	public $msg;
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->__dynamics[$m]) && is_callable($this->__dynamics[$m]))
			return call_user_func_array($this->__dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call <'.$m.'>');
	}
	function __toString() { return $this->toString(); }
}
function erazor_error_ParserError_0(&$__hx__this, &$excerpt) {
	if($excerpt !== null) {
		return " ( \"" . _hx_string_or_null($excerpt) . "\" )";
	} else {
		return "";
	}
}
