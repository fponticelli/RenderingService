<?php

class model_LogGateway {
	public function __construct($coll) {
		if(!php_Boot::$skip_constructor) {
		$this->coll = $coll;
	}}
	public function clear() {
		$this->coll->remove(_hx_anonymous(array()), null);
	}
	public function hlist() {
		$list = $this->coll->find(_hx_anonymous(array()), null)->sort(_hx_anonymous(array("time" => -1)))->toArray();
		thx_core_Arrays::each($list, array(new _hx_lambda(array(&$list), "model_LogGateway_0"), 'execute'));
		return $list;
	}
	public $coll;
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
	function __toString() { return 'model.LogGateway'; }
}
function model_LogGateway_0(&$list, $el, $_) {
	{
		Reflect::deleteField($el, "_id");
	}
}
