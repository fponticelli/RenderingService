<?php

class ufront_web_HttpRequest {
	public function __construct(){}
	public function setUploadHandler($handler) {
		throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 83, "className" => "ufront.web.HttpRequest", "methodName" => "setUploadHandler"))));
	}
	public function get_authorization() {
		ufront_web_HttpRequest_0($this);
	}
	public $authorization;
	public function get_scriptDirectory() {
		ufront_web_HttpRequest_1($this);
	}
	public $scriptDirectory;
	public function get_httpMethod() {
		ufront_web_HttpRequest_2($this);
	}
	public $httpMethod;
	public function get_userAgent() {
		ufront_web_HttpRequest_3($this);
	}
	public $userAgent;
	public function get_clientHeaders() {
		ufront_web_HttpRequest_4($this);
	}
	public $clientHeaders;
	public function get_uri() {
		ufront_web_HttpRequest_5($this);
	}
	public $uri;
	public function get_clientIP() {
		ufront_web_HttpRequest_6($this);
	}
	public $clientIP;
	public function get_hostName() {
		ufront_web_HttpRequest_7($this);
	}
	public $hostName;
	public function get_cookies() {
		ufront_web_HttpRequest_8($this);
	}
	public $cookies;
	public function get_post() {
		ufront_web_HttpRequest_9($this);
	}
	public $post;
	public function get_query() {
		ufront_web_HttpRequest_10($this);
	}
	public $query;
	public function get_postString() {
		ufront_web_HttpRequest_11($this);
	}
	public $postString;
	public function get_queryString() {
		ufront_web_HttpRequest_12($this);
	}
	public $queryString;
	public function get_params() {
		if(null === $this->params) {
			$this->params = new thx_collection_CascadeMap(new _hx_array(array(new haxe_ds_StringMap(), $this->get_query(), $this->get_post(), $this->get_cookies())));
		}
		return $this->params;
	}
	public $params;
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
	static $instance;
	static function get_instance() {
		if(null === ufront_web_HttpRequest::$instance) {
			ufront_web_HttpRequest::$instance = new php_ufront_web_HttpRequest();
		}
		return ufront_web_HttpRequest::$instance;
	}
	static $__properties__ = array("get_params" => "get_params","get_queryString" => "get_queryString","get_postString" => "get_postString","get_query" => "get_query","get_post" => "get_post","get_cookies" => "get_cookies","get_hostName" => "get_hostName","get_clientIP" => "get_clientIP","get_uri" => "get_uri","get_clientHeaders" => "get_clientHeaders","get_userAgent" => "get_userAgent","get_httpMethod" => "get_httpMethod","get_scriptDirectory" => "get_scriptDirectory","get_authorization" => "get_authorization","get_instance" => "get_instance");
	function __toString() { return 'ufront.web.HttpRequest'; }
}
function ufront_web_HttpRequest_0(&$__hx__this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 81, "className" => "ufront.web.HttpRequest", "methodName" => "get_authorization"))));
}
function ufront_web_HttpRequest_1(&$__hx__this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 78, "className" => "ufront.web.HttpRequest", "methodName" => "get_scriptDirectory"))));
}
function ufront_web_HttpRequest_2(&$__hx__this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 75, "className" => "ufront.web.HttpRequest", "methodName" => "get_httpMethod"))));
}
function ufront_web_HttpRequest_3(&$__hx__this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 72, "className" => "ufront.web.HttpRequest", "methodName" => "get_userAgent"))));
}
function ufront_web_HttpRequest_4(&$__hx__this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 69, "className" => "ufront.web.HttpRequest", "methodName" => "get_clientHeaders"))));
}
function ufront_web_HttpRequest_5(&$__hx__this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 66, "className" => "ufront.web.HttpRequest", "methodName" => "get_uri"))));
}
function ufront_web_HttpRequest_6(&$__hx__this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 63, "className" => "ufront.web.HttpRequest", "methodName" => "get_clientIP"))));
}
function ufront_web_HttpRequest_7(&$__hx__this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 60, "className" => "ufront.web.HttpRequest", "methodName" => "get_hostName"))));
}
function ufront_web_HttpRequest_8(&$__hx__this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 57, "className" => "ufront.web.HttpRequest", "methodName" => "get_cookies"))));
}
function ufront_web_HttpRequest_9(&$__hx__this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 54, "className" => "ufront.web.HttpRequest", "methodName" => "get_post"))));
}
function ufront_web_HttpRequest_10(&$__hx__this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 51, "className" => "ufront.web.HttpRequest", "methodName" => "get_query"))));
}
function ufront_web_HttpRequest_11(&$__hx__this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 48, "className" => "ufront.web.HttpRequest", "methodName" => "get_postString"))));
}
function ufront_web_HttpRequest_12(&$__hx__this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 45, "className" => "ufront.web.HttpRequest", "methodName" => "get_queryString"))));
}
