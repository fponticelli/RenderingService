<?php

class php_ufront_web_FileSession implements ufront_web_IHttpSessionState{
	public function __construct($savePath, $sessionId = null) {
		if(!php_Boot::$skip_constructor) {
		$this->savePath = $savePath;
		$this->content = new haxe_ds_StringMap();
		$this->sessionId = $sessionId;
		$this->setupSessionId();
		if(!file_exists($savePath)) {
			$path = haxe_io_Path::addTrailingSlash($savePath);
			$parts = php_ufront_web_FileSession_0($this, $path, $savePath, $sessionId);
			$parts->reverse();
			{
				$_g1 = 0;
				while($_g1 < $parts->length) {
					$part = $parts[$_g1];
					++$_g1;
					if(_hx_char_code_at($part, strlen($part) - 1) !== 58 && !file_exists($part)) {
						@mkdir($part, 493);
					}
					unset($part);
				}
			}
		}
		if(!file_exists($this->sessionStoragePath)) {
			$path = haxe_io_Path::addTrailingSlash($this->sessionStoragePath);
			$parts = php_ufront_web_FileSession_1($this, $path, $savePath, $sessionId);
			$parts->reverse();
			{
				$_g1 = 0;
				while($_g1 < $parts->length) {
					$part = $parts[$_g1];
					++$_g1;
					if(_hx_char_code_at($part, strlen($part) - 1) !== 58 && !file_exists($part)) {
						@mkdir($part, 493);
					}
					unset($part);
				}
			}
		}
	}}
	public function id() {
		return $this->sessionId;
	}
	public function remove($name) {
		@unlink($this->getVarPath($name));
	}
	public function exists($name) {
		return file_exists($this->getVarPath($name));
	}
	public function set($name, $value) {
		sys_io_File::saveContent($this->getVarPath($name), haxe_Serializer::run($value));
	}
	public function getVarPath($name) {
		return _hx_string_or_null($this->sessionStoragePath) . "/" . _hx_string_or_null($name);
	}
	public function get($name) {
		return haxe_Unserializer::run(sys_io_File::getContent($this->getVarPath($name)));
	}
	public function clear() {
		{
			$_g = 0; $_g1 = sys_FileSystem::readDirectory($this->sessionStoragePath);
			while($_g < $_g1->length) {
				$file = $_g1[$_g];
				++$_g;
				@unlink(_hx_string_or_null($this->sessionStoragePath) . "/" . _hx_string_or_null($file));
				unset($file);
			}
		}
		@rmdir($this->sessionStoragePath);
	}
	public function dispose() {
	}
	public function setLifeTime($lifetime) {
		$this->add("ufront", $this->sessionId, $lifetime);
	}
	public function setupSessionId() {
		if($this->sessionId === null) {
			$cookie = $this->getCookie();
			if($cookie === null) {
				$this->sessionId = $this->getId();
				$this->add("ufront", $this->sessionId, 0);
			} else {
				$id = $cookie;
				if(!file_exists(_hx_string_or_null($this->savePath) . "/" . _hx_string_or_null($id))) {
					$id = $this->getId();
					$this->add("ufront", $id, 0);
				}
				$this->sessionId = $id;
			}
		}
		$this->sessionStoragePath = _hx_string_or_null($this->savePath) . "/" . _hx_string_or_null($this->sessionId);
	}
	public $sessionStoragePath;
	public $sessionId;
	public $content;
	public $savePath;
	public function getId() {
		return Std::string(uniqid());
	}
	public function getCookie() {
		$result = null;
		
			if (array_key_exists('ufront', $_COOKIE)) 
				$result=$_COOKIE['ufront'];
		;
		return $result;
	}
	public function add($name, $value, $expire) {
		$result = false;
		
			if ($expire!=0)
				$expire=time()+$expire;
			
			$result=( 1==setcookie ( $name , $value,$expire ) );
		;
		if(!$result) {
			throw new HException("Cookie could not be set. Output already started.");
		}
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
	function __toString() { return 'php.ufront.web.FileSession'; }
}
function php_ufront_web_FileSession_0(&$__hx__this, &$path, &$savePath, &$sessionId) {
	{
		$_g = new _hx_array(array());
		while(($path = haxe_io_Path::directory($path)) !== "") {
			$_g->push($path);
		}
		return $_g;
	}
}
function php_ufront_web_FileSession_1(&$__hx__this, &$path, &$savePath, &$sessionId) {
	{
		$_g = new _hx_array(array());
		while(($path = haxe_io_Path::directory($path)) !== "") {
			$_g->push($path);
		}
		return $_g;
	}
}
