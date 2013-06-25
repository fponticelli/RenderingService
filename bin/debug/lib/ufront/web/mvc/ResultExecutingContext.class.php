<?php

class ufront_web_mvc_ResultExecutingContext {
	public function __construct($controllerContext, $result) {
		if(!php_Boot::$skip_constructor) {
		$this->controllerContext = $controllerContext;
		$this->result = $result;
	}}
	public $result;
	public $controllerContext;
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
	function __toString() { return 'ufront.web.mvc.ResultExecutingContext'; }
}
