<?php

class ufront_web_PathInfoUrlFilter implements ufront_web_IUrlFilter{
	public function __construct($frontScript = null, $useCleanRoot = null) {
		if(!php_Boot::$skip_constructor) {
		if($useCleanRoot === null) {
			$useCleanRoot = true;
		}
		if(null === $frontScript) {
			$frontScript = "index.php";
		}
		$this->frontScript = $frontScript;
		$this->useCleanRoot = $useCleanRoot;
	}}
	public function filterOut($url, $request) {
		if($url->isPhysical || $url->segments->length === 0 && $this->useCleanRoot) {
		} else {
			$url->segments->unshift($this->frontScript);
		}
	}
	public function filterIn($url, $request) {
		if($url->segments[0] === $this->frontScript) {
			$url->segments->shift();
		}
	}
	public $useCleanRoot;
	public $frontScript;
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
	function __toString() { return 'ufront.web.PathInfoUrlFilter'; }
}
