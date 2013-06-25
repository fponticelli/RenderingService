<?php

class ufront_web_DirectoryUrlFilter implements ufront_web_IUrlFilter{
	public function __construct($directory) {
		if(!php_Boot::$skip_constructor) {
		if(StringTools::endsWith($directory, "/")) {
			$directory = _hx_substr($directory, 0, strlen($directory) - 1);
		}
		$this->directory = $directory;
		$this->segments = _hx_explode("/", $directory);
	}}
	public function filterOut($url, $request) {
		$url->segments = $this->segments->concat($url->segments);
	}
	public function filterIn($url, $request) {
		$pos = 0;
		while($url->segments->length > 0 && $url->segments[0] === $this->segments[$pos++]) {
			$url->segments->shift();
		}
	}
	public $segments;
	public $directory;
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
	function __toString() { return 'ufront.web.DirectoryUrlFilter'; }
}
