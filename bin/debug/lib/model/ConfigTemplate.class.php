<?php

class model_ConfigTemplate {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->params = new thx_collection_Set();
		$this->allowedValues = new haxe_ds_StringMap();
		$this->defaults = new haxe_ds_StringMap();
	}}
	public function toString() {
		return "ConfigTample: " . _hx_string_or_null(model_ConfigObjects::fieldsToString($this));
	}
	public function replaceables() {
		$list = $this->params->harray();
		$list->sort(array(new _hx_lambda(array(&$list), "model_ConfigTemplate_0"), 'execute'));
		return $list;
	}
	public function getDefault($name) {
		return $this->defaults->get($name);
	}
	public function setDefault($name, $value) {
		$value1 = $value;
		$this->defaults->set($name, $value1);
	}
	public function isValid($name, $value) {
		$values = $this->allowedValues->get($name);
		if(null === $values) {
			return true;
		}
		return thx_core_Arrays::exists($values, $value, null);
	}
	public function addParameter($name, $values = null) {
		$this->params->add($name);
		if(null !== $values) {
			$this->allowedValues->set($name, $values);
		}
	}
	public $defaults;
	public $allowedValues;
	public $params;
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
function model_ConfigTemplate_0(&$list, $a, $b) {
	{
		$c = strlen($b) - strlen($a);
		if($c !== 0) {
			return $c;
		}
		return thx_core_Strings::compare($a, $b);
	}
}
