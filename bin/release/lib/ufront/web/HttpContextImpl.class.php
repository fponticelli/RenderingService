<?php

class ufront_web_HttpContextImpl extends ufront_web_HttpContext {
	public function __construct($request, $response, $session) { if(!php_Boot::$skip_constructor) {
		parent::__construct();
		$this->request = $request;
		$this->response = $response;
		$this->session = $session;
	}}
	public function dispose() {
		$this->get_session()->dispose();
	}
	public function get_session() {
		return $this->session;
	}
	public function get_response() {
		return $this->response;
	}
	public function get_request() {
		return $this->request;
	}
	public function setSession($session) {
		if(null === $session) {
			throw new HException(new thx_error_NullArgument("session", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "HttpContextImpl.hx", "lineNumber" => 34, "className" => "ufront.web.HttpContextImpl", "methodName" => "setSession"))));
		}
		$this->session = $session;
	}
	public function setResponse($response) {
		if(null === $response) {
			throw new HException(new thx_error_NullArgument("response", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "HttpContextImpl.hx", "lineNumber" => 28, "className" => "ufront.web.HttpContextImpl", "methodName" => "setResponse"))));
		}
		$this->response = $response;
	}
	public function setRequest($request) {
		if(null === $request) {
			throw new HException(new thx_error_NullArgument("request", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "HttpContextImpl.hx", "lineNumber" => 22, "className" => "ufront.web.HttpContextImpl", "methodName" => "setRequest"))));
		}
		$this->request = $request;
	}
	static $__properties__ = array("get_request" => "get_request","get_response" => "get_response","get_session" => "get_session");
	function __toString() { return 'ufront.web.HttpContextImpl'; }
}
