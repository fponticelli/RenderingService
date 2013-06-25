<?php

class ufront_web_mvc_ViewContext {
	public function __construct($controllerContext, $view, $viewEngine, $viewData, $viewHelpers) {
		if(!php_Boot::$skip_constructor) {
		$this->controllerContext = $controllerContext;
		$this->controller = $controllerContext->controller;
		$this->requestContext = $controllerContext->requestContext;
		$this->httpContext = $this->requestContext->httpContext;
		$this->routeData = $this->requestContext->routeData;
		$this->view = $view;
		$this->viewData = $viewData;
		$this->viewEngine = $viewEngine;
		$this->request = $this->httpContext->get_request();
		$this->response = $this->httpContext->get_response();
		$this->session = $this->httpContext->get_session();
		$this->viewHelpers = $viewHelpers;
	}}
	public $viewHelpers;
	public $viewEngine;
	public $session;
	public $response;
	public $request;
	public $viewData;
	public $view;
	public $routeData;
	public $requestContext;
	public $httpContext;
	public $controllerContext;
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
	function __toString() { return 'ufront.web.mvc.ViewContext'; }
}
