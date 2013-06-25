<?php

class thx_core_Iterables {
	public function __construct(){}
	static function count($it) {
		return thx_core_Iterators::count($it->iterator());
	}
	static function indexOf($it, $v = null, $f = null) {
		return thx_core_Iterators::indexOf($it->iterator(), $v, $f);
	}
	static function contains($it, $v = null, $f = null) {
		return thx_core_Iterators::contains($it->iterator(), $v, $f);
	}
	static function harray($it) {
		return thx_core_Iterators::harray($it->iterator());
	}
	static function join($it, $glue = null) {
		if($glue === null) {
			$glue = ", ";
		}
		return thx_core_Iterators::harray($it->iterator())->join($glue);
	}
	static function map($it, $f) {
		return thx_core_Iterators::map($it->iterator(), $f);
	}
	static function each($it, $f) {
		thx_core_Iterators::each($it->iterator(), $f);
		return;
	}
	static function filter($it, $f) {
		return thx_core_Iterators::filter($it->iterator(), $f);
	}
	static function reduce($it, $f, $initialValue) {
		return thx_core_Iterators::reduce($it->iterator(), $f, $initialValue);
	}
	static function random($it) {
		return thx_core_Arrays::random(thx_core_Iterators::harray($it->iterator()));
	}
	static function any($it, $f) {
		return thx_core_Iterators::any($it->iterator(), $f);
	}
	static function all($it, $f) {
		return thx_core_Iterators::all($it->iterator(), $f);
	}
	static function last($it) {
		return thx_core_Iterables_0($it);
	}
	static function lastf($it, $f) {
		return thx_core_Iterators::lastf($it->iterator(), $f);
	}
	static function first($it) {
		return $it->iterator()->next();
	}
	static function firstf($it, $f) {
		return thx_core_Iterators::firstf($it->iterator(), $f);
	}
	static function order($it, $f = null) {
		return thx_core_Iterables_1($f, $it);
	}
	static function isIterable($v) {
		$fields = ((Reflect::isObject($v) && null === Type::getClass($v)) ? Reflect::fields($v) : Type::getInstanceFields(Type::getClass($v)));
		if(!Lambda::has($fields, "iterator")) {
			return false;
		}
		return Reflect::isFunction(Reflect::field($v, "iterator"));
	}
	function __toString() { return 'thx.core.Iterables'; }
}
function thx_core_Iterables_0(&$it) {
	{
		$it1 = $it->iterator();
		$o = null;
		while($it1->hasNext()) {
			$o = $it1->next();
		}
		return $o;
	}
}
function thx_core_Iterables_1(&$f, &$it) {
	{
		$arr = thx_core_Iterators::harray($it->iterator());
		$arr->sort(thx_core_Iterables_2($arr, $f, $it));
		return $arr;
	}
}
function thx_core_Iterables_2(&$arr, &$f, &$it) {
	if(null === $f) {
		return (isset(thx_core_Dynamics::$compare) ? thx_core_Dynamics::$compare: array("thx_core_Dynamics", "compare"));
	} else {
		return $f;
	}
}
