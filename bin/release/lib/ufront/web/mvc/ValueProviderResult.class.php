<?php

class ufront_web_mvc_ValueProviderResult {
	public function __construct($rawValue, $attemptedValue) {
		if(!php_Boot::$skip_constructor) {
		$this->rawValue = $rawValue;
		$this->attemptedValue = $attemptedValue;
	}}
	public function toString() {
		return "ValueProviderResult { rawValue : " . Std::string($this->rawValue) . ", attemptedValue : " . Std::string($this->attemptedValue) . "}";
	}
	public $attemptedValue;
	public $rawValue;
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
	static $jugglers;
	static function arraySplitter($type, $s) {
		$arr = new _hx_array(array());
		$parts = _hx_explode(",", $s);
		{
			$_g = 0;
			while($_g < $parts->length) {
				$part = $parts[$_g];
				++$_g;
				$juggler = ufront_web_mvc_ValueProviderResult::$jugglers->get($type);
				if(null === $juggler) {
					return null;
				}
				$value = call_user_func_array($juggler, array($part));
				if(null === $value) {
					return null;
				}
				$arr->push($value);
				unset($value,$part,$juggler);
			}
		}
		return $arr;
	}
	static function registerTypeJuggler($typeName, $method) {
		ufront_web_mvc_ValueProviderResult::$jugglers->set($typeName, $method);
	}
	static function getTypeJuggler($t) {
		return ufront_web_mvc_ValueProviderResult::$jugglers->get($t);
	}
	static function _ctypeCheck($value, $t) {
		$__hx__t = ($t);
		switch($__hx__t->index) {
		case 7:
		{
			return false;
		}break;
		case 0:
		case 4:
		{
			return false;
		}break;
		case 1:
		$params = $__hx__t->params[1]; $name = $__hx__t->params[0];
		{
			$e = Type::resolveEnum($name);
			if(null === $e) {
				return false;
			}
			if(!Std::is($value, $e)) {
				return false;
			}
			$values = Type::enumParameters($value);
			if($values->length !== $params->length) {
				return false;
			}
			$i = 0;
			if(null == $params) throw new HException('null iterable');
			$__hx__it = $params->iterator();
			while($__hx__it->hasNext()) {
				$param = $__hx__it->next();
				if(ufront_web_mvc_ValueProviderResult::_ctypeCheck($values[$i++], $param)) {
					return false;
				}
			}
		}break;
		case 2:
		$params = $__hx__t->params[1]; $name = $__hx__t->params[0];
		{
			$c = Type::resolveClass($name);
			if(null === $c) {
				return false;
			}
			if(!Std::is($value, $c)) {
				return false;
			}
		}break;
		case 3:
		$params = $__hx__t->params[1]; $name = $__hx__t->params[0];
		{
			if("Null" === $name) {
				return ufront_web_mvc_ValueProviderResult::_ctypeCheck($value, $params->first());
			} else {
				return false;
			}
		}break;
		case 5:
		$fields = $__hx__t->params[0];
		{
			$valueFields = Reflect::fields($value);
			if(null == $fields) throw new HException('null iterable');
			$__hx__it = $fields->iterator();
			while($__hx__it->hasNext()) {
				$field = $__hx__it->next();
				if(!$valueFields->remove($field->name)) {
					return false;
				}
				if(!ufront_web_mvc_ValueProviderResult::_ctypeCheck(Reflect::field($value, $field->name), $field->type)) {
					return false;
				}
			}
			if($valueFields->length > 0) {
				return false;
			}
		}break;
		case 6:
		$t1 = $__hx__t->params[0];
		{
			if(!Reflect::isObject($value)) {
				return false;
			}
			if(null !== $t1) {
				$_g = 0; $_g1 = Reflect::fields($value);
				while($_g < $_g1->length) {
					$field = $_g1[$_g];
					++$_g;
					if(!ufront_web_mvc_ValueProviderResult::_ctypeCheck(Reflect::field($value, $field), $t1)) {
						return false;
					}
					unset($field);
				}
			}
		}break;
		}
		return true;
	}
	static function convertEnum($value, $e) {
		try {
			return Type::createEnum($e, $value, null);
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e1 = $_ex_;
			{
				return null;
			}
		}
	}
	static function convertSimpleType($value, $t) {
		$juggler = ufront_web_mvc_ValueProviderResult::getTypeJuggler($t);
		if($juggler === null) {
			return null;
		}
		try {
			return call_user_func_array($juggler, array($value));
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				return null;
			}
		}
	}
	static function convertSimpleTypeRtti($value, $t, $unserialize = null) {
		if($unserialize === null) {
			$unserialize = false;
		}
		$juggler = ufront_web_mvc_ValueProviderResult::getTypeJuggler(thx_type_Rttis::typeName($t, false));
		if($juggler === null) {
			if(!$unserialize) {
				return null;
			}
			$v = null;
			try {
				$v = haxe_Unserializer::run($value);
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				$e = $_ex_;
				{
					return null;
				}
			}
			if(ufront_web_mvc_ValueProviderResult::_ctypeCheck($v, $t)) {
				return $v;
			} else {
				return null;
			}
		} else {
			try {
				return call_user_func_array($juggler, array($value));
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				$e = $_ex_;
				{
					return null;
				}
			}
		}
	}
	function __toString() { return $this->toString(); }
}
{
	ufront_web_mvc_ValueProviderResult::$jugglers = new haxe_ds_StringMap();
	ufront_web_mvc_ValueProviderResult::registerTypeJuggler("String", array(new _hx_lambda(array(), "ufront_web_mvc_ValueProviderResult_0"), 'execute'));
	ufront_web_mvc_ValueProviderResult::registerTypeJuggler("Int", (isset(Std::$parseInt) ? Std::$parseInt: array("Std", "parseInt")));
	ufront_web_mvc_ValueProviderResult::registerTypeJuggler("Float", (isset(Std::$parseFloat) ? Std::$parseFloat: array("Std", "parseFloat")));
	ufront_web_mvc_ValueProviderResult::registerTypeJuggler("Date", (isset(Date::$fromString) ? Date::$fromString: array("Date", "fromString")));
	ufront_web_mvc_ValueProviderResult::registerTypeJuggler("Bool", array(new _hx_lambda(array(), "ufront_web_mvc_ValueProviderResult_1"), 'execute'));
	ufront_web_mvc_ValueProviderResult::registerTypeJuggler("Array", array(new _hx_lambda(array(), "ufront_web_mvc_ValueProviderResult_2"), 'execute'));
	ufront_web_mvc_ValueProviderResult::registerTypeJuggler("Array<String>", array(new _hx_lambda(array(), "ufront_web_mvc_ValueProviderResult_3"), 'execute'));
	ufront_web_mvc_ValueProviderResult::registerTypeJuggler("Array<Int>", array(new _hx_lambda(array(), "ufront_web_mvc_ValueProviderResult_4"), 'execute'));
	ufront_web_mvc_ValueProviderResult::registerTypeJuggler("Array<Float>", array(new _hx_lambda(array(), "ufront_web_mvc_ValueProviderResult_5"), 'execute'));
	ufront_web_mvc_ValueProviderResult::registerTypeJuggler("Array<Bool>", array(new _hx_lambda(array(), "ufront_web_mvc_ValueProviderResult_6"), 'execute'));
	ufront_web_mvc_ValueProviderResult::registerTypeJuggler("Array<Date>", array(new _hx_lambda(array(), "ufront_web_mvc_ValueProviderResult_7"), 'execute'));
}
function ufront_web_mvc_ValueProviderResult_0($s) {
	{
		return $s;
	}
}
function ufront_web_mvc_ValueProviderResult_1($s) {
	{
		$_g = strtolower($s);
		switch($_g) {
		case "true":case "1":case "yes":case "y":case "ok":case "on":{
			return true;
		}break;
		case "false":case "0":case "no":case "n":case "off":{
			return false;
		}break;
		default:{
			return null;
		}break;
		}
	}
}
function ufront_web_mvc_ValueProviderResult_2($s) {
	{
		return ufront_web_mvc_ValueProviderResult::arraySplitter("String", $s);
	}
}
function ufront_web_mvc_ValueProviderResult_3($s) {
	{
		return ufront_web_mvc_ValueProviderResult::arraySplitter("String", $s);
	}
}
function ufront_web_mvc_ValueProviderResult_4($s) {
	{
		return ufront_web_mvc_ValueProviderResult::arraySplitter("Int", $s);
	}
}
function ufront_web_mvc_ValueProviderResult_5($s) {
	{
		return ufront_web_mvc_ValueProviderResult::arraySplitter("Float", $s);
	}
}
function ufront_web_mvc_ValueProviderResult_6($s) {
	{
		return ufront_web_mvc_ValueProviderResult::arraySplitter("Bool", $s);
	}
}
function ufront_web_mvc_ValueProviderResult_7($s) {
	{
		return ufront_web_mvc_ValueProviderResult::arraySplitter("Date", $s);
	}
}
