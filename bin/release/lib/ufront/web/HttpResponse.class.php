<?php

class ufront_web_HttpResponse {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->clear();
		$this->set_contentType(null);
		$this->charset = "utf-8";
		$this->status = 200;
	}}
	public function set_redirectLocation($v) {
		if(null === $v) {
			$this->_headers->remove("Location");
		} else {
			$this->_headers->set("Location", $v);
		}
		return $v;
	}
	public function get_redirectLocation() {
		return $this->_headers->get("Location");
	}
	public function set_contentType($v) {
		if(null === $v) {
			$this->_headers->set("Content-type", "text/html");
		} else {
			$this->_headers->set("Content-type", $v);
		}
		return $v;
	}
	public function get_contentType() {
		return $this->_headers->get("Content-type");
	}
	public function isPermanentRedirect() {
		return $this->status === 301;
	}
	public function isRedirect() {
		return Math::floor($this->status / 100) === 3;
	}
	public function permanentRedirect($url) {
		$this->status = 301;
		$this->set_redirectLocation($url);
	}
	public function setInternalError() {
		$this->status = 500;
	}
	public function setNotFound() {
		$this->status = 404;
	}
	public function setUnauthorized() {
		$this->status = 401;
	}
	public function setOk() {
		$this->status = 200;
	}
	public function redirect($url) {
		$this->status = 302;
		$this->set_redirectLocation($url);
	}
	public function getHeaders() {
		return $this->_headers;
	}
	public function getCookies() {
		return $this->_cookies;
	}
	public function getBuffer() {
		return $this->_buff->b;
	}
	public function setCookie($cookie) {
		$this->_cookies->set($cookie->name, $cookie);
	}
	public function setHeader($name, $value) {
		if(null === $name) {
			throw new HException(new thx_error_NullArgument("name", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "HttpResponse.hx", "lineNumber" => 103, "className" => "ufront.web.HttpResponse", "methodName" => "setHeader"))));
		}
		if(null === $value) {
			throw new HException(new thx_error_NullArgument("value", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "HttpResponse.hx", "lineNumber" => 104, "className" => "ufront.web.HttpResponse", "methodName" => "setHeader"))));
		}
		$this->_headers->set($name, $value);
	}
	public function writeBytes($b, $pos, $len) {
		$this->_buff->add($b->readString($pos, $len));
	}
	public function writeChar($c) {
		$this->_buff->b .= _hx_string_or_null(chr($c));
	}
	public function write($s) {
		if(null !== $s) {
			$this->_buff->add($s);
		}
	}
	public function clearHeaders() {
		$this->_headers = new thx_collection_HashList();
	}
	public function clearContent() {
		$this->_buff = new StringBuf();
	}
	public function clearCookies() {
		$this->_cookies = new haxe_ds_StringMap();
	}
	public function clear() {
		$this->clearCookies();
		$this->clearHeaders();
		$this->clearContent();
	}
	public function flush() {
	}
	public $_cookies;
	public $_headers;
	public $_buff;
	public $status;
	public $charset;
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
		if(null === ufront_web_HttpResponse::$instance) {
			ufront_web_HttpResponse::$instance = new php_ufront_web_HttpResponse();
		}
		return ufront_web_HttpResponse::$instance;
	}
	static $__properties__ = array("set_contentType" => "set_contentType","get_contentType" => "get_contentType","set_redirectLocation" => "set_redirectLocation","get_redirectLocation" => "get_redirectLocation","get_instance" => "get_instance");
	function __toString() { return 'ufront.web.HttpResponse'; }
}
