<?php

class ufront_web_AppConfiguration {
	public function __construct($controllerPackage = null, $modRewrite = null, $basePath = null, $logFile = null, $disableBrowserTrace = null) {
		if(!php_Boot::$skip_constructor) {
		if($disableBrowserTrace === null) {
			$disableBrowserTrace = false;
		}
		if($basePath === null) {
			$basePath = "/";
		}
		$this->modRewrite = (($modRewrite === null) ? false : $modRewrite);
		$this->basePath = $basePath;
		$this->controllerPackages = new _hx_array(array((($controllerPackage === null) ? "" : $controllerPackage)));
		$this->attributePackages = new _hx_array(array("ufront.web.mvc.attributes"));
		$this->logFile = $logFile;
		$this->disableBrowserTrace = $disableBrowserTrace;
	}}
	public $disableBrowserTrace;
	public $logFile;
	public $basePath;
	public $attributePackages;
	public $controllerPackages;
	public $modRewrite;
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
	function __toString() { return 'ufront.web.AppConfiguration'; }
}
