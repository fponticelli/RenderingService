<?php

class ufront_web_mvc_ControllerContext {
	public function __construct($controller, $requestContext) {
		if(!php_Boot::$skip_constructor) {
		$this->controller = $controller;
		$this->requestContext = $requestContext;
		$this->httpContext = $requestContext->httpContext;
		$this->routeData = $requestContext->routeData;
		$this->request = $this->httpContext->get_request();
		$this->response = $this->httpContext->get_response();
		$this->session = $this->httpContext->get_session();
	}}
	public $session;
	public $response;
	public $request;
	public $routeData;
	public $httpContext;
	public $requestContext;
	public $controller;
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
	function __toString() { return 'ufront.web.mvc.ControllerContext'; }
}
