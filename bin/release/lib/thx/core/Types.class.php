<?php

class thx_core_Types {
	public function __construct(){}
	static function className($o) {
		return _hx_explode(".", Type::getClassName(Type::getClass($o)))->pop();
	}
	static function fullName($o) {
		return Type::getClassName(Type::getClass($o));
	}
	static function typeName($o) {
		return thx_core_Types_0($o);
	}
	static function hasSuperClass($type, $sup) {
		while(null !== $type) {
			if($type === $sup) {
				return true;
			}
			$type = Type::getSuperClass($type);
		}
		return false;
	}
	static function isAnonymous($v) {
		return Reflect::isObject($v) && null === Type::getClass($v);
	}
	static function has($value, $type) {
		return ((Std::is($value, $type)) ? $value : null);
	}
	static function ifIs($value, $type, $handler) {
		if(Std::is($value, $type)) {
			call_user_func_array($handler, array($value));
		}
		return $value;
	}
	static function of($type, $value) {
		return ((Std::is($value, $type)) ? $value : null);
	}
	static function sameType($a, $b) {
		if(null === $a && $b === null) {
			return true;
		}
		if(null === $a || $b === null) {
			return false;
		}
		$tb = Type::typeof($b);
		$__hx__t = ($tb);
		switch($__hx__t->index) {
		case 6:
		$c = $__hx__t->params[0];
		{
			return Std::is($a, $c);
		}break;
		case 7:
		$e = $__hx__t->params[0];
		{
			return Std::is($a, $e);
		}break;
		default:{
			return Type::typeof($a) === $tb;
		}break;
		}
	}
	static function isPrimitive($v) {
		return thx_core_Types_1($v);
	}
	function __toString() { return 'thx.core.Types'; }
}
function thx_core_Types_0(&$o) {
	{
		$_g = Type::typeof($o);
		$__hx__t = ($_g);
		switch($__hx__t->index) {
		case 0:
		{
			return "null";
		}break;
		case 1:
		{
			return "Int";
		}break;
		case 2:
		{
			return "Float";
		}break;
		case 3:
		{
			return "Bool";
		}break;
		case 5:
		{
			return "function";
		}break;
		case 6:
		$c = $__hx__t->params[0];
		{
			return Type::getClassName($c);
		}break;
		case 7:
		$e = $__hx__t->params[0];
		{
			return Type::getEnumName($e);
		}break;
		case 4:
		{
			return "Object";
		}break;
		case 8:
		{
			return "Unknown";
		}break;
		}
		unset($_g);
	}
}
function thx_core_Types_1(&$v) {
	{
		$_g = Type::typeof($v);
		$__hx__t = ($_g);
		switch($__hx__t->index) {
		case 0:
		case 1:
		case 2:
		case 3:
		{
			return true;
		}break;
		case 5:
		case 7:
		case 4:
		case 8:
		{
			return false;
		}break;
		case 6:
		$c = $__hx__t->params[0];
		{
			return Type::getClassName($c) === "String";
		}break;
		}
		unset($_g);
	}
}
