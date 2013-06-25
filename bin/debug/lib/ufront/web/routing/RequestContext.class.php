<?php

class ufront_web_routing_RequestContext {
	public function __construct($httpContext, $routeData, $routes) {
		if(!php_Boot::$skip_constructor) {
		$this->httpContext = $httpContext;
		$this->routeData = $routeData;
		$this->request = $httpContext->get_request();
		$this->response = $httpContext->get_response();
		$this->session = $httpContext->get_session();
		$this->routes = $routes;
	}}
	public $routes;
	public $session;
	public $response;
	public $request;
	public $routeData;
	public $httpContext;
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
	function __toString() { return 'ufront.web.routing.RequestContext'; }
}
