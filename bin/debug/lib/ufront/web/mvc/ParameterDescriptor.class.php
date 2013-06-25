<?php

class ufront_web_mvc_ParameterDescriptor {
	public function __construct($name, $type, $ctype = null) {
		if(!php_Boot::$skip_constructor) {
		$this->name = $name;
		$this->type = $type;
		$this->ctype = $ctype;
	}}
	public function toString() {
		return "ParameterDescriptor { name : " . _hx_string_or_null($this->name) . ", type : " . _hx_string_or_null($this->type) . ", ctype : " . Std::string($this->ctype) . "}";
	}
	public $defaultValue;
	public $ctype;
	public $type;
	public $name;
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
	function __toString() { return $this->toString(); }
}
