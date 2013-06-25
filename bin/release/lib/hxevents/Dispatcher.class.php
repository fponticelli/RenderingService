<?php

class hxevents_Dispatcher {
	public function __construct() {
		if(!isset($this->add)) $this->add = array(new _hx_lambda(array(&$this), "hxevents_Dispatcher_0"), 'execute');
		if(!php_Boot::$skip_constructor) {
		$this->handlers = new _hx_array(array());
	}}
	public function stop() {
		$this->_stop = true;
	}
	public $_stop;
	public function has($h = null) {
		if(null === $h) {
			return $this->handlers->length > 0;
		} else {
			{
				$_g = 0; $_g1 = $this->handlers;
				while($_g < $_g1->length) {
					$handler = $_g1[$_g];
					++$_g;
					if($h == $handler) {
						return true;
					}
					unset($handler);
				}
			}
			return false;
		}
	}
	public function dispatchAndAutomate($e) {
		$this->dispatch($e);
		$this->handlers = new _hx_array(array());
		$this->add = array(new _hx_lambda(array(&$e), "hxevents_Dispatcher_1"), 'execute');
	}
	public function dispatch($e) {
		$list = $this->handlers->copy();
		{
			$_g = 0;
			while($_g < $list->length) {
				$l = $list[$_g];
				++$_g;
				if($this->_stop === true) {
					$this->_stop = false;
					break;
				}
				call_user_func_array($l, array($e));
				unset($l);
			}
		}
	}
	public function clear() {
		$this->handlers = new _hx_array(array());
	}
	public function remove($h) {
		{
			$_g1 = 0; $_g = $this->handlers->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				if(Reflect::compareMethods($this->handlers[$i], $h)) {
					return _hx_array_get($this->handlers->splice($i, 1), 0);
				}
				unset($i);
			}
		}
		return null;
	}
	public function addOnce($h) {
		$me = $this;
		$_h = null;
		$_h = array(new _hx_lambda(array(&$_h, &$h, &$me), "hxevents_Dispatcher_2"), 'execute');
		$this->add($_h);
		return $_h;
	}
	public function add($h) { return call_user_func_array($this->add, array($h)); }
	public $add = null;
	public $handlers;
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
	function __toString() { return 'hxevents.Dispatcher'; }
}
function hxevents_Dispatcher_0(&$__hx__this, $h) {
	{
		$__hx__this->handlers->push($h);
		return $h;
	}
}
function hxevents_Dispatcher_1(&$e, $h) {
	{
		call_user_func_array($h, array($e));
		return $h;
	}
}
function hxevents_Dispatcher_2(&$_h, &$h, &$me, $v) {
	{
		$me->remove($_h);
		call_user_func_array($h, array($v));
	}
}
