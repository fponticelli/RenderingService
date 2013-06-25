<?php

class model_ConfigImage {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->disableSmartWidth = false;
		$this->transparent = false;
	}}
	public function toString() {
		return "ConfigImage: " . _hx_string_or_null(model_ConfigObjects::fieldsToString($this));
	}
	public $transparent;
	public $disableSmartWidth;
	public $quality;
	public $screenHeight;
	public $screenWidth;
	public $height;
	public $width;
	public $y;
	public $x;
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
