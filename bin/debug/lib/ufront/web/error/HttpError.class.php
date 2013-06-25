<?php

class ufront_web_error_HttpError extends thx_error_Error {
	public function __construct($code, $message, $params = null, $param = null, $pos = null) {
		if(!php_Boot::$skip_constructor) {
		parent::__construct("Error " . _hx_string_rec($code, "") . ": " . _hx_string_or_null($message),$params,$param,$pos);
		$this->code = $code;
	}}
	public $code;
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
	function __toString() { return 'ufront.web.error.HttpError'; }
}
