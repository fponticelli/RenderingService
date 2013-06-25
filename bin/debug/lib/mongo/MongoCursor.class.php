<?php

class mongo_MongoCursor {
	public function __construct($c) {
		if(!php_Boot::$skip_constructor) {
		$this->c = $c;
	}}
	public function toArray() {
		$r = new _hx_array(array());
		while($this->hasNext()) {
			$r->push($this->getNext());
		}
		return $r;
	}
	public function limit($num) {
		$this->c->limit($num);
		return $this;
	}
	public function sort($fields) {
		$this->c->sort(php_Lib::associativeArrayOfObject($fields));
		return $this;
	}
	public function hasNext() {
		return $this->c->hasNext();
	}
	public function getNext() {
		return php_Lib::objectOfAssociativeArray($this->c->getNext());
	}
	public $c;
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
	function __toString() { return 'mongo.MongoCursor'; }
}
