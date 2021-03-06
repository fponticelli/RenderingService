<?php

class ufront_web_mvc_ViewEngines {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->_list = new HList();
	}}
	public function iterator() {
		return $this->_list->iterator();
	}
	public function clear() {
		$this->_list = new HList();
	}
	public function add($engine) {
		$this->_list->add($engine);
	}
	public $_list;
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
	static $engines;
	static function get_engines() {
		if(null === ufront_web_mvc_ViewEngines::$engines) {
			ufront_web_mvc_ViewEngines::$engines = new ufront_web_mvc_ViewEngines();
			ufront_web_mvc_ViewEngines::$engines->add(new ufront_web_mvc_view_ErazorViewEngine());
		}
		return ufront_web_mvc_ViewEngines::$engines;
	}
	static $__properties__ = array("get_engines" => "get_engines");
	function __toString() { return 'ufront.web.mvc.ViewEngines'; }
}
