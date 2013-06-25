<?php

class model_Renderable {
	public function __construct($html, $config, $createdOn = null, $lastUsage = null, $usages = null) {
		if(!php_Boot::$skip_constructor) {
		$this->html = $html;
		$this->config = $config;
		$this->createdOn = ((null === $createdOn) ? Date::now() : $createdOn);
		$this->lastUsage = ((null === $lastUsage) ? Date::now() : $lastUsage);
		$this->usages = ((null === $usages) ? 0 : $usages);
	}}
	public function toString() {
		return "CONFIG\x0A" . Std::string($this->config) . "\x0A\x0AHTML\x0A" . _hx_string_or_null($this->html);
	}
	public function canRenderTo($format) {
		return thx_core_Arrays::exists($this->config->allowedFormats, $format, null);
	}
	public function get_uid() {
		if(null === $this->uid) {
			$s = _hx_string_or_null($this->html) . "::" . _hx_string_or_null(haxe_Serializer::run($this->config));
			$s = "][4p5.,vsd" . _hx_string_or_null(_hx_deref(new EReg("\\s+", "mg"))->replace($s, ""));
			$this->uid = model_Renderable::Map($s);
		}
		return $this->uid;
	}
	public $uid;
	public $usages;
	public $lastUsage;
	public $createdOn;
	public $config;
	public $html;
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
	static function Map($s) {
		$s = md5($s);
		$s = base_convert($s, 16, 36);
		return _hx_substr($s, 0, 12);
	}
	static $__properties__ = array("get_uid" => "get_uid");
	function __toString() { return $this->toString(); }
}
