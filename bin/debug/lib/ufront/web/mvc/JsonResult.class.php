<?php

class ufront_web_mvc_JsonResult extends ufront_web_mvc_ActionResult {
	public function __construct($content) {
		if(!php_Boot::$skip_constructor) {
		$this->content = $content;
	}}
	public function executeResult($controllerContext) {
		if(null === $controllerContext) {
			throw new HException(new thx_error_NullArgument("controllerContext", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "JsonResult.hx", "lineNumber" => 19, "className" => "ufront.web.mvc.JsonResult", "methodName" => "executeResult"))));
		}
		$controllerContext->response->set_contentType("application/json");
		$serialized = thx_json_Json::encode($this->content);
		$controllerContext->response->write($serialized);
	}
	public $allowOrigin;
	public $content;
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
	function __toString() { return 'ufront.web.mvc.JsonResult'; }
}
