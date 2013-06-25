<?php

class thx_collection_CascadeMap {
	public function __construct($hashes) {
		if(!php_Boot::$skip_constructor) {
		if(null === $hashes) {
			throw new HException(new thx_error_NullArgument("hashes", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "CascadeHash.hx", "lineNumber" => 15, "className" => "thx.collection.CascadeMap", "methodName" => "new"))));
		}
		$this->_h = new HList();
		{
			$_g = 0;
			while($_g < $hashes->length) {
				$h = $hashes[$_g];
				++$_g;
				$this->_h->add($h);
				unset($h);
			}
		}
	}}
	public function toString() {
		$arr = new _hx_array(array());
		if(null == $this) throw new HException('null iterable');
		$__hx__it = $this->keys();
		while($__hx__it->hasNext()) {
			$k = $__hx__it->next();
			$arr->push(Std::string($k) . ": " . Std::string($this->get($k)));
		}
		return "{" . _hx_string_or_null($arr->join(", ")) . "}";
	}
	public function keys() {
		$s = new thx_collection_Set();
		if(null == $this->_h) throw new HException('null iterable');
		$__hx__it = $this->_h->iterator();
		while($__hx__it->hasNext()) {
			$h = $__hx__it->next();
			if(null == $h) throw new HException('null iterable');
			$__hx__it2 = $h->keys();
			while($__hx__it2->hasNext()) {
				$k = $__hx__it2->next();
				$s->add($k);
			}
		}
		return $s->iterator();
	}
	public function iterator() {
		$list = new HList();
		if(null == $this) throw new HException('null iterable');
		$__hx__it = $this->keys();
		while($__hx__it->hasNext()) {
			$k = $__hx__it->next();
			$list->push($this->get($k));
		}
		return $list->iterator();
	}
	public function exists($key) {
		if(null == $this->_h) throw new HException('null iterable');
		$__hx__it = $this->_h->iterator();
		while($__hx__it->hasNext()) {
			$h = $__hx__it->next();
			if($h->exists($key)) {
				return true;
			}
		}
		return false;
	}
	public function get($key) {
		if(null == $this->_h) throw new HException('null iterable');
		$__hx__it = $this->_h->iterator();
		while($__hx__it->hasNext()) {
			$h = $__hx__it->next();
			if($h->exists($key)) {
				return $h->get($key);
			}
		}
		return null;
	}
	public function remove($key) {
		if(null == $this->_h) throw new HException('null iterable');
		$__hx__it = $this->_h->iterator();
		while($__hx__it->hasNext()) {
			$h = $__hx__it->next();
			if($h->remove($key)) {
				return true;
			}
		}
		return false;
	}
	public function set($key, $value) {
		$this->_h->first()->set($key, $value);
	}
	public $_h;
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
