<?php

class php_ufront_web_HttpRequest extends ufront_web_HttpRequest {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->_uploadHandler = new ufront_web_EmptyUploadHandler();
	}}
	public function get_authorization() {
		if(null === _hx_field($this, "authorization")) {
			$this->authorization = _hx_anonymous(array("user" => null, "pass" => null));
			if(isset($_SERVER['PHP_AUTH_USER'])) {
				$this->authorization->user = $_SERVER['PHP_AUTH_USER'];
				$this->authorization->pass = $_SERVER['PHP_AUTH_PW'];
			}
		}
		return $this->authorization;
	}
	public function get_scriptDirectory() {
		if(null === $this->scriptDirectory) {
			$this->scriptDirectory = _hx_string_or_null(dirname($_SERVER['SCRIPT_FILENAME'])) . "/";
		}
		return $this->scriptDirectory;
	}
	public function get_httpMethod() {
		if(null === $this->httpMethod) {
			if(isset($_SERVER['REQUEST_METHOD'])) {
				$this->httpMethod = $_SERVER['REQUEST_METHOD'];
			}
			if(null === $this->httpMethod) {
				$this->httpMethod = "";
			}
		}
		return $this->httpMethod;
	}
	public function get_clientHeaders() {
		if(null === $this->clientHeaders) {
			$this->clientHeaders = new haxe_ds_StringMap();
			$h = php_Lib::hashOfAssociativeArray($_SERVER);
			if(null == $h) throw new HException('null iterable');
			$__hx__it = $h->keys();
			while($__hx__it->hasNext()) {
				$k = $__hx__it->next();
				if(_hx_substr($k, 0, 5) === "HTTP_") {
					$this->clientHeaders->set(thx_core_Strings::ucwords(php_ufront_web_HttpRequest_0($this, $h, $k)), $h->get($k));
				}
			}
			if($h->exists("CONTENT_TYPE")) {
				$this->clientHeaders->set("Content-Type", $h->get("CONTENT_TYPE"));
			}
		}
		return $this->clientHeaders;
	}
	public function get_uri() {
		if(null === $this->uri) {
			$s = $_SERVER['REQUEST_URI'];
			$this->uri = _hx_array_get(_hx_explode("?", $s), 0);
		}
		return $this->uri;
	}
	public function get_clientIP() {
		if(null === $this->clientIP) {
			$this->clientIP = $_SERVER['REMOTE_ADDR'];
		}
		return $this->clientIP;
	}
	public function get_hostName() {
		if(null === $this->hostName) {
			$this->hostName = $_SERVER['SERVER_NAME'];
		}
		return $this->hostName;
	}
	public function get_userAgent() {
		if(null === $this->userAgent) {
			$this->userAgent = ufront_web_UserAgent::fromString($this->get_clientHeaders()->get("User-Agent"));
		}
		return $this->userAgent;
	}
	public function get_cookies() {
		if(null === $this->cookies) {
			$this->cookies = php_Lib::hashOfAssociativeArray($_COOKIE);
		}
		return $this->cookies;
	}
	public function get_post() {
		if($this->get_httpMethod() === "GET") {
			return new haxe_ds_StringMap();
		}
		if(null === $this->post) {
			$this->post = php_ufront_web_HttpRequest::getHashFromString($this->get_postString());
			if(!$this->post->iterator()->hasNext()) {
				if(isset($_POST)) {
					$na = array();
					foreach($_POST as $k => $v) { $na[urldecode($k)] = $v; }
					$h = php_Lib::hashOfAssociativeArray($na);
					if(null == $h) throw new HException('null iterable');
					$__hx__it = $h->keys();
					while($__hx__it->hasNext()) {
						$k = $__hx__it->next();
						$this->post->set($k, $h->get($k));
					}
				}
			}
			if(isset($_FILES)) {
				$parts = new _hx_array(array_keys($_FILES));
				{
					$_g = 0;
					while($_g < $parts->length) {
						$part = $parts[$_g];
						++$_g;
						$file = $_FILES[$part]['name'];
						$name = StringTools::urldecode($part);
						$this->post->set($name, $file);
						unset($part,$name,$file);
					}
				}
			}
		}
		return $this->post;
	}
	public function get_query() {
		if(null === $this->query) {
			$this->query = php_ufront_web_HttpRequest::getHashFromString($this->get_queryString());
		}
		return $this->query;
	}
	public function setUploadHandler($handler) {
		if($this->_parsed) {
			throw new HException(new thx_error_Error("multipart has been already parsed", null, null, _hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 108, "className" => "php.ufront.web.HttpRequest", "methodName" => "setUploadHandler"))));
		}
		$this->_uploadHandler = $handler;
		$this->_parseMultipart();
	}
	public function _parseMultipart() {
		if($this->_parsed) {
			return;
		}
		$this->_parsed = true;
		$post = $this->get_post();
		$handler = $this->_uploadHandler;
		if(!isset($_FILES)) {
			return;
		}
		$parts = new _hx_array(array_keys($_FILES));
		{
			$_g = 0;
			while($_g < $parts->length) {
				$part = $parts[$_g];
				++$_g;
				$info = $_FILES[$part];
				$file = $info["name"];
				$tmp = $info["tmp_name"];
				$name = StringTools::urldecode($part);
				$post->set($name, $file);
				if($tmp === "") {
					continue;
				}
				$err = $info["error"];
				if($err > 0) {
					switch($err) {
					case 1:{
						throw new HException(new thx_error_Error("The uploaded file exceeds the max size of {0}", ini_get("upload_max_filesize"), null, _hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 82, "className" => "php.ufront.web.HttpRequest", "methodName" => "_parseMultipart"))));
					}break;
					case 2:{
						throw new HException(new thx_error_Error("The uploaded file exceeds the max file size directive specified in the HTML form (max is {0})", ini_get("post_max_size"), null, _hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 83, "className" => "php.ufront.web.HttpRequest", "methodName" => "_parseMultipart"))));
					}break;
					case 3:{
						throw new HException(new thx_error_Error("The uploaded file was only partially uploaded", null, null, _hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 84, "className" => "php.ufront.web.HttpRequest", "methodName" => "_parseMultipart"))));
					}break;
					case 4:{
						continue 2;
					}break;
					case 6:{
						throw new HException(new thx_error_Error("Missing a temporary folder", null, null, _hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 86, "className" => "php.ufront.web.HttpRequest", "methodName" => "_parseMultipart"))));
					}break;
					case 7:{
						throw new HException(new thx_error_Error("Failed to write file to disk", null, null, _hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 87, "className" => "php.ufront.web.HttpRequest", "methodName" => "_parseMultipart"))));
					}break;
					case 8:{
						throw new HException(new thx_error_Error("File upload stopped by extension", null, null, _hx_anonymous(array("fileName" => "HttpRequest.hx", "lineNumber" => 88, "className" => "php.ufront.web.HttpRequest", "methodName" => "_parseMultipart"))));
					}break;
					}
				}
				$handler->uploadStart($name, $file);
				$h = fopen($tmp, "r");
				$bsize = 8192;
				while(!feof($h)) {
					$buf = fread($h, $bsize);
					$size = strlen($buf);
					$handler->uploadProgress(haxe_io_Bytes::ofString($buf), 0, $size);
					unset($size,$buf);
				}
				fclose($h);
				$handler->uploadEnd();
				unlink($tmp);
				unset($tmp,$part,$name,$info,$h,$file,$err,$bsize);
			}
		}
	}
	public $_parsed;
	public $_uploadHandler;
	public function get_postString() {
		if($this->get_httpMethod() === "GET") {
			return "";
		}
		if(null === $this->postString) {
			if(isset($GLOBALS["HTTP_RAW_POST_DATA"])) {
				$this->postString = $GLOBALS["HTTP_RAW_POST_DATA"];
			} else {
				$this->postString = file_get_contents("php://input");
			}
			if(null === $this->postString) {
				$this->postString = "";
			}
		}
		return $this->postString;
	}
	public function get_queryString() {
		if(null === $this->queryString) {
			$this->queryString = $_SERVER["QUERY_STRING"];
		}
		return $this->queryString;
	}
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
	static function encodeName($s) {
		return php_ufront_web_HttpRequest_1($s);
	}
	static $paramPattern;
	static function getHashFromString($s) {
		$hash = new haxe_ds_StringMap();
		{
			$_g = 0; $_g1 = _hx_explode("&", $s);
			while($_g < $_g1->length) {
				$part = $_g1[$_g];
				++$_g;
				if(!php_ufront_web_HttpRequest::$paramPattern->match($part)) {
					continue;
				}
				$hash->set(urldecode(php_ufront_web_HttpRequest::$paramPattern->matched(1)), urldecode(php_ufront_web_HttpRequest::$paramPattern->matched(2)));
				unset($part);
			}
		}
		return $hash;
	}
	static function getHashFrom($a) {
		if(get_magic_quotes_gpc()) {
			reset($a); while(list($k, $v) = each($a)) $a[$k] = stripslashes((string)$v);
		}
		return php_Lib::hashOfAssociativeArray($a);
	}
	static $__properties__ = array("get_params" => "get_params","get_queryString" => "get_queryString","get_postString" => "get_postString","get_query" => "get_query","get_post" => "get_post","get_cookies" => "get_cookies","get_hostName" => "get_hostName","get_clientIP" => "get_clientIP","get_uri" => "get_uri","get_clientHeaders" => "get_clientHeaders","get_userAgent" => "get_userAgent","get_httpMethod" => "get_httpMethod","get_scriptDirectory" => "get_scriptDirectory","get_authorization" => "get_authorization","get_instance" => "get_instance");
	function __toString() { return 'php.ufront.web.HttpRequest'; }
}
php_ufront_web_HttpRequest::$paramPattern = new EReg("^([^=]+)=(.*?)\$", "");
function php_ufront_web_HttpRequest_0(&$__hx__this, &$h, &$k) {
	{
		$s = strtolower(_hx_substr($k, 5, null));
		return str_replace("_", "-", $s);
	}
}
function php_ufront_web_HttpRequest_1(&$s) {
	{
		$s1 = rawurlencode($s);
		return str_replace(".", "%2E", $s1);
	}
}
