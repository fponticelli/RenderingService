<?php

class ufront_web_mvc_JsonPResult extends ufront_web_mvc_ActionResult {
	public function __construct($content, $callbackName) {
		if(!php_Boot::$skip_constructor) {
		$this->content = $content;
		$this->callbackName = $callbackName;
	}}
	public function executeResult($controllerContext) {
		if(null === $controllerContext) {
			throw new HException(new thx_error_NullArgument("controllerContext", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "JsonPResult.hx", "lineNumber" => 20, "className" => "ufront.web.mvc.JsonPResult", "methodName" => "executeResult"))));
		}
		$controllerContext->response->set_contentType("text/javascript");
		$serialized = thx_json_Json::encode($this->content);
		$controllerContext->response->write(_hx_string_or_null($this->callbackName) . "('" . _hx_string_or_null($serialized) . "');");
	}
	public $callbackName;
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
	static function auto($content, $callbackName) {
		if(null === $callbackName) {
			return new ufront_web_mvc_JsonResult($content);
		} else {
			return new ufront_web_mvc_JsonPResult($content, $callbackName);
		}
	}
	function __toString() { return 'ufront.web.mvc.JsonPResult'; }
}
