<?php

class HList implements IteratorAggregate{
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->length = 0;
	}}
	public function getIterator() {
		return $this->iterator();
	}
	public function toString() {
		$s = "";
		$first = true;
		$l = $this->h;
		while($l !== null) {
			if($first) {
				$first = false;
			} else {
				$s .= ", ";
			}
			$s .= Std::string($l[0]);
			$l = $l[1];
		}
		return "{" . _hx_string_or_null($s) . "}";
	}
	public function iterator() {
		return new _hx_list_iterator($this);
	}
	public function remove($v) {
		$prev = null;
		$l = & $this->h;
		while($l !== null) {
			if($l[0] === $v) {
				if($prev === null) {
					$this->h =& $l[1];
				} else {
					$prev[1] =& $l[1];
				}
				if(($this->q === $l)) {
					$this->q =& $prev;
				}
				$this->length--;
				return true;
			}
			$prev =& $l;
			$l =& $l[1];
		}
		return false;
	}
	public function last() {
		return HList_0($this);
	}
	public function first() {
		return HList_1($this);
	}
	public function push($item) {
		$x = array($item, &$this->h);
		$this->h =& $x;
		if($this->q === null) {
			$this->q =& $x;
		}
		$this->length++;
	}
	public function add($item) {
		$x = array($item, null);
		if($this->h === null) {
			$this->h =& $x;
		} else {
			$this->q[1] =& $x;
		}
		$this->q =& $x;
		$this->length++;
	}
	public $length;
	public $q;
	public $h;
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
function HList_0(&$__hx__this) {
	if($__hx__this->q === null) {
		return null;
	} else {
		return $__hx__this->q[0];
	}
}
function HList_1(&$__hx__this) {
	if($__hx__this->h === null) {
		return null;
	} else {
		return $__hx__this->h[0];
	}
}
