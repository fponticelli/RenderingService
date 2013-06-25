<?php

class hxevents_AsyncDispatcher {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->handlers = new _hx_array(array());
	}}
	public function dispatch($e, $handler = null, $error = null) {
		$list = $this->handlers->copy();
		$haserror = false;
		$size = $list->length;
		$count = 0;
		$after = array(new _hx_lambda(array(&$count, &$e, &$error, &$handler, &$haserror, &$list, &$size), "hxevents_AsyncDispatcher_0"), 'execute');
		if(0 === $size) {
			if(null !== $handler) {
				call_user_func($handler);
			}
			return;
		}
		$async = new hxevents_Async($after, array(new _hx_lambda(array(&$after, &$count, &$e, &$error, &$handler, &$haserror, &$list, &$size), "hxevents_AsyncDispatcher_1"), 'execute'));
		{
			$_g = 0;
			while($_g < $list->length) {
				$l = $list[$_g];
				++$_g;
				call_user_func_array($l, array($e, $async));
				unset($l);
			}
		}
	}
	public function addAsync($h) {
		$this->handlers->push($h);
		return $h;
	}
	public function add($h) {
		$f = array(new _hx_lambda(array(&$h), "hxevents_AsyncDispatcher_2"), 'execute');
		$this->handlers->push($f);
		return $f;
	}
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
		$f = null;
		$f = array(new _hx_lambda(array(&$f, &$h, &$me), "hxevents_AsyncDispatcher_3"), 'execute');
		$this->addAsync($f);
		return $f;
	}
	public function addAsyncOnce($h) {
		$me = $this;
		$f = null;
		$f = array(new _hx_lambda(array(&$f, &$h, &$me), "hxevents_AsyncDispatcher_4"), 'execute');
		$this->addAsync($f);
		return $f;
	}
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
	function __toString() { return 'hxevents.AsyncDispatcher'; }
}
function hxevents_AsyncDispatcher_0(&$count, &$e, &$error, &$handler, &$haserror, &$list, &$size) {
	{
		if($haserror) {
			return;
		}
		if(++$count === $size) {
			if(null !== $handler) {
				call_user_func($handler);
			}
		} else {
			if($count > $size) {
				$msg = "the Async instance has been invoked too many times (expected " . _hx_string_rec($size, "") . " times)";
				if(null !== $error) {
					call_user_func_array($error, array($msg));
				} else {
					throw new HException($msg);
				}
			}
		}
	}
}
function hxevents_AsyncDispatcher_1(&$after, &$count, &$e, &$error, &$handler, &$haserror, &$list, &$size, $e1) {
	{
		$haserror = true;
		call_user_func_array($error, array($e1));
	}
}
function hxevents_AsyncDispatcher_2(&$h, $e, $async) {
	{
		call_user_func_array($h, array($e));
		$async->completed();
	}
}
function hxevents_AsyncDispatcher_3(&$f, &$h, &$me, $e, $async) {
	{
		$me->remove($f);
		call_user_func_array($h, array($e));
		$async->completed();
	}
}
function hxevents_AsyncDispatcher_4(&$f, &$h, &$me, $e, $async) {
	{
		$me->remove($f);
		call_user_func_array($h, array($e, $async));
	}
}
