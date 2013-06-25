<?php

class ufront_web_mvc_ModelBinderDictionary {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->_innerDictionary = new haxe_ds_StringMap();
	}}
	public $_innerDictionary;
	public function iterator() {
		return $this->_innerDictionary->iterator();
	}
	public function typeString($type) {
		if(Std::is($type, _hx_qtype("String"))) {
			return $type;
		}
		if(Std::is($type, _hx_qtype("Class"))) {
			return Type::getClassName($type);
		}
		throw new HException("Couldn't find a binder class for " . Std::string($type));
	}
	public function getBinder($type, $fallbackBinder = null, $fallbackToDefault = null) {
		if($fallbackToDefault === null) {
			$fallbackToDefault = true;
		}
		if($this->containsKey($type)) {
			return $this->_innerDictionary->get($this->typeString($type));
		}
		return (($fallbackBinder !== null) ? $fallbackBinder : (($fallbackToDefault) ? $this->get_defaultBinder() : null));
	}
	public function containsKey($key) {
		return $this->_innerDictionary->exists($this->typeString($key));
	}
	public function contains($item) {
		return Lambda::exists($this->_innerDictionary, array(new _hx_lambda(array(&$item), "ufront_web_mvc_ModelBinderDictionary_0"), 'execute'));
	}
	public function clear() {
		if(null == $this->_innerDictionary) throw new HException('null iterable');
		$__hx__it = $this->_innerDictionary->keys();
		while($__hx__it->hasNext()) {
			$v = $__hx__it->next();
			$this->_innerDictionary->remove($v);
		}
	}
	public function remove($key) {
		$this->_innerDictionary->remove($this->typeString($key));
	}
	public function add($key, $value) {
		$this->_innerDictionary->set($this->typeString($key), $value);
	}
	public function get_values() {
		return $this->_innerDictionary->iterator();
	}
	public $values;
	public function get_keys() {
		return $this->_innerDictionary->keys();
	}
	public $keys;
	public function set_defaultBinder($v) {
		$this->_defaultBinder = $v;
		return $this->_defaultBinder;
	}
	public function get_defaultBinder() {
		if($this->_defaultBinder === null) {
			$this->_defaultBinder = new ufront_web_mvc_DefaultModelBinder();
		}
		return $this->_defaultBinder;
	}
	public $_defaultBinder;
	public function get_count() {
		return Lambda::count($this->_innerDictionary, null);
	}
	public $count;
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
	static $__properties__ = array("get_count" => "get_count","set_defaultBinder" => "set_defaultBinder","get_defaultBinder" => "get_defaultBinder","get_keys" => "get_keys","get_values" => "get_values");
	function __toString() { return 'ufront.web.mvc.ModelBinderDictionary'; }
}
function ufront_web_mvc_ModelBinderDictionary_0(&$item, $binder) {
	{
		return $binder === $item;
	}
}
