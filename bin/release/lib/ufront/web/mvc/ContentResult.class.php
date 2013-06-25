<?php

class ufront_web_mvc_ContentResult extends ufront_web_mvc_ActionResult {
	public function __construct($content = null, $contentType = null) {
		if(!php_Boot::$skip_constructor) {
		$this->content = $content;
		$this->contentType = $contentType;
	}}
	public function executeResult($controllerContext) {
		if(null === $controllerContext) {
			throw new HException(new thx_error_NullArgument("controllerContext", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "ContentResult.hx", "lineNumber" => 17, "className" => "ufront.web.mvc.ContentResult", "methodName" => "executeResult"))));
		}
		if(null !== $this->contentType) {
			$controllerContext->response->set_contentType($this->contentType);
		}
		$controllerContext->response->write($this->content);
	}
	public $contentType;
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
	function __toString() { return 'ufront.web.mvc.ContentResult'; }
}
