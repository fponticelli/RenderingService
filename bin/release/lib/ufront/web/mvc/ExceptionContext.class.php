<?php

class ufront_web_mvc_ExceptionContext extends ufront_web_mvc_ControllerContext {
	public function __construct($controllerContext, $exception) {
		if(!php_Boot::$skip_constructor) {
		parent::__construct($controllerContext->controller,$controllerContext->requestContext);
		$this->{"exception"} = $exception;
	}}
	public function set_result($result) {
		$this->_result = $result;
		return $result;
	}
	public function get_result() {
		return ufront_web_mvc_ExceptionContext_0($this);
	}
	public $_result;
	public $exceptionHandled;
	public $exception;
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
	static $__properties__ = array("set_result" => "set_result","get_result" => "get_result");
	function __toString() { return 'ufront.web.mvc.ExceptionContext'; }
}
function ufront_web_mvc_ExceptionContext_0(&$__hx__this) {
	if($__hx__this->_result !== null) {
		return $__hx__this->_result;
	} else {
		return new ufront_web_mvc_EmptyResult();
	}
}
