<?php

class ufront_web_HttpContext {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->_urlFilters = new _hx_array(array());
	}}
	public function get_session() {
		ufront_web_HttpContext_0($this);
	}
	public function get_response() {
		ufront_web_HttpContext_1($this);
	}
	public function get_request() {
		ufront_web_HttpContext_2($this);
	}
	public function dispose() {
	}
	public function clearUrlFilters() {
		$this->_requestUri = null;
		$this->_urlFilters = new _hx_array(array());
	}
	public function addUrlFilter($filter) {
		if(null === $filter) {
			throw new HException(new thx_error_NullArgument("filter", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "HttpContext.hx", "lineNumber" => 57, "className" => "ufront.web.HttpContext", "methodName" => "addUrlFilter"))));
		}
		$this->_requestUri = null;
		$this->_urlFilters->push($filter);
		return $this;
	}
	public function generateUri($uri) {
		$uriOut = ufront_web_VirtualUrl::parse($uri);
		$i = $this->_urlFilters->length - 1;
		while($i >= 0) {
			_hx_array_get($this->_urlFilters, $i--)->filterOut($uriOut, $this->get_request());
		}
		return $uriOut->toString();
	}
	public function getRequestUri() {
		if(null === $this->_requestUri) {
			$url = ufront_web_PartialUrl::parse($this->get_request()->get_uri());
			{
				$_g = 0; $_g1 = $this->_urlFilters;
				while($_g < $_g1->length) {
					$filter = $_g1[$_g];
					++$_g;
					$filter->filterIn($url, $this->get_request());
					unset($filter);
				}
			}
			$this->_requestUri = $url->toString();
		}
		return $this->_requestUri;
	}
	public $_requestUri;
	public $session;
	public $response;
	public $request;
	public $_urlFilters;
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
	static function createWebContext($sessionpath = null, $request = null, $response = null) {
		if(null === $request) {
			$request = ufront_web_HttpRequest::get_instance();
		}
		if(null === $response) {
			$response = ufront_web_HttpResponse::get_instance();
		}
		if(null === $sessionpath) {
			$sessionpath = _hx_string_or_null($request->get_scriptDirectory()) . "../_sessions";
		}
		return new ufront_web_HttpContextImpl($request, $response, ufront_web_session_FileSession::create($sessionpath));
	}
	static $__properties__ = array("get_request" => "get_request","get_response" => "get_response","get_session" => "get_session");
	function __toString() { return 'ufront.web.HttpContext'; }
}
function ufront_web_HttpContext_0(&$__hx__this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpContext.hx", "lineNumber" => 73, "className" => "ufront.web.HttpContext", "methodName" => "get_session"))));
}
function ufront_web_HttpContext_1(&$__hx__this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpContext.hx", "lineNumber" => 72, "className" => "ufront.web.HttpContext", "methodName" => "get_response"))));
}
function ufront_web_HttpContext_2(&$__hx__this) {
	throw new HException(new thx_error_AbstractMethod(_hx_anonymous(array("fileName" => "HttpContext.hx", "lineNumber" => 71, "className" => "ufront.web.HttpContext", "methodName" => "get_request"))));
}
