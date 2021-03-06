<?php

class thx_core_Objects {
	public function __construct(){}
	static function field($o, $fieldname, $alt = null) {
		return ((_hx_has_field($o, $fieldname)) ? Reflect::field($o, $fieldname) : $alt);
	}
	static function keys($o) {
		return Reflect::fields($o);
	}
	static function values($o) {
		$arr = new _hx_array(array());
		{
			$_g = 0; $_g1 = Reflect::fields($o);
			while($_g < $_g1->length) {
				$key = $_g1[$_g];
				++$_g;
				$arr->push(Reflect::field($o, $key));
				unset($key);
			}
		}
		return $arr;
	}
	static function entries($o) {
		$arr = new _hx_array(array());
		{
			$_g = 0; $_g1 = Reflect::fields($o);
			while($_g < $_g1->length) {
				$key = $_g1[$_g];
				++$_g;
				$arr->push(_hx_anonymous(array("key" => $key, "value" => Reflect::field($o, $key))));
				unset($key);
			}
		}
		return $arr;
	}
	static function each($o, $handler) {
		$_g = 0; $_g1 = Reflect::fields($o);
		while($_g < $_g1->length) {
			$key = $_g1[$_g];
			++$_g;
			call_user_func_array($handler, array($key, Reflect::field($o, $key)));
			unset($key);
		}
	}
	static function map($o, $handler) {
		$results = new _hx_array(array());
		{
			$_g = 0; $_g1 = Reflect::fields($o);
			while($_g < $_g1->length) {
				$key = $_g1[$_g];
				++$_g;
				$results->push(call_user_func_array($handler, array($key, Reflect::field($o, $key))));
				unset($key);
			}
		}
		return $results;
	}
	static function with($ob, $f) {
		call_user_func_array($f, array($ob));
		return $ob;
	}
	static function toMap($ob) {
		$map = new haxe_ds_StringMap();
		return thx_core_Objects::copyToMap($ob, $map);
	}
	static function copyToMap($ob, $map) {
		{
			$_g = 0; $_g1 = Reflect::fields($ob);
			while($_g < $_g1->length) {
				$field = $_g1[$_g];
				++$_g;
				$value = Reflect::field($ob, $field);
				$map->set($field, $value);
				unset($value,$field);
			}
		}
		return $map;
	}
	static function interpolate($v, $a, $b, $equation = null) {
		return call_user_func_array(thx_core_Objects::interpolatef($a, $b, $equation), array($v));
	}
	static function interpolatef($a, $b, $equation = null) {
		$i = _hx_anonymous(array()); $c = _hx_anonymous(array()); $keys = Reflect::fields($a);
		{
			$_g = 0;
			while($_g < $keys->length) {
				$key = $keys[$_g];
				++$_g;
				if(_hx_has_field($b, $key)) {
					$va = Reflect::field($a, $key);
					$i->{$key} = thx_core_Dynamics::interpolatef($va, Reflect::field($b, $key), null);
					unset($va);
				} else {
					$c->{$key} = Reflect::field($a, $key);
				}
				unset($key);
			}
		}
		$keys = Reflect::fields($b);
		{
			$_g = 0;
			while($_g < $keys->length) {
				$key = $keys[$_g];
				++$_g;
				if(!_hx_has_field($a, $key)) {
					$c->{$key} = Reflect::field($b, $key);
				}
				unset($key);
			}
		}
		return array(new _hx_lambda(array(&$a, &$b, &$c, &$equation, &$i, &$keys), "thx_core_Objects_0"), 'execute');
	}
	static function copyTo($src, $dst) {
		{
			$_g = 0; $_g1 = Reflect::fields($src);
			while($_g < $_g1->length) {
				$field = $_g1[$_g];
				++$_g;
				$sv = thx_core_Dynamics::hclone(Reflect::field($src, $field), null);
				$dv = Reflect::field($dst, $field);
				if(Reflect::isObject($sv) && null === Type::getClass($sv) && (Reflect::isObject($dv) && null === Type::getClass($dv))) {
					thx_core_Objects::copyTo($sv, $dv);
				} else {
					$dst->{$field} = $sv;
				}
				unset($sv,$field,$dv);
			}
		}
		return $dst;
	}
	static function hclone($src) {
		$dst = _hx_anonymous(array());
		return thx_core_Objects::copyTo($src, $dst);
	}
	static function mergef($ob, $new_ob, $f) {
		$_g = 0; $_g1 = Reflect::fields($new_ob);
		while($_g < $_g1->length) {
			$field = $_g1[$_g];
			++$_g;
			$new_val = Reflect::field($new_ob, $field);
			if(_hx_has_field($ob, $field)) {
				$old_val = Reflect::field($ob, $field);
				$ob->{$field} = call_user_func_array($f, array($field, $old_val, $new_val));
				unset($old_val);
			} else {
				$ob->{$field} = $new_val;
			}
			unset($new_val,$field);
		}
	}
	static function merge($ob, $new_ob) {
		thx_core_Objects::mergef($ob, $new_ob, array(new _hx_lambda(array(&$new_ob, &$ob), "thx_core_Objects_1"), 'execute'));
	}
	static function _flatten($src, $cum, $arr, $levels, $level) {
		$_g = 0; $_g1 = Reflect::fields($src);
		while($_g < $_g1->length) {
			$field = $_g1[$_g];
			++$_g;
			$clone = thx_core_Objects::hclone($cum);
			$v = Reflect::field($src, $field);
			$clone->fields->push($field);
			if(Reflect::isObject($v) && null === Type::getClass($v) && ($levels === 0 || $level + 1 < $levels)) {
				thx_core_Objects::_flatten($v, $clone, $arr, $levels, $level + 1);
			} else {
				$clone->value = $v;
				$arr->push($clone);
			}
			unset($v,$field,$clone);
		}
	}
	static function flatten($src, $levels = null) {
		if($levels === null) {
			$levels = 0;
		}
		$arr = new _hx_array(array());
		{
			$_g = 0; $_g1 = Reflect::fields($src);
			while($_g < $_g1->length) {
				$field = $_g1[$_g];
				++$_g;
				$v = Reflect::field($src, $field);
				if(Reflect::isObject($v) && null === Type::getClass($v) && $levels !== 1) {
					$item = _hx_anonymous(array("fields" => new _hx_array(array($field)), "value" => null));
					thx_core_Objects::_flatten($v, $item, $arr, $levels, 1);
					unset($item);
				} else {
					$arr->push(_hx_anonymous(array("fields" => new _hx_array(array($field)), "value" => $v)));
				}
				unset($v,$field);
			}
		}
		return $arr;
	}
	static function compare($a, $b) {
		$v = null; $fields = null;
		if(($v = thx_core_Arrays::compare($fields = Reflect::fields($a), Reflect::fields($b))) !== 0) {
			return $v;
		}
		{
			$_g = 0;
			while($_g < $fields->length) {
				$field = $fields[$_g];
				++$_g;
				if(($v = thx_core_Dynamics::compare(Reflect::field($a, $field), Reflect::field($b, $field))) !== 0) {
					return $v;
				}
				unset($field);
			}
		}
		return 0;
	}
	static function addFields($o, $fields, $values) {
		{
			$_g1 = 0; $_g = $fields->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				thx_core_Objects::addField($o, $fields[$i], $values[$i]);
				unset($i);
			}
		}
		return $o;
	}
	static function addField($o, $field, $value) {
		$o->{$field} = $value;
		return $o;
	}
	static function format($v, $param = null, $params = null, $culture = null) {
		return call_user_func_array(thx_core_Objects::formatf($param, $params, $culture), array($v));
	}
	static function formatf($param = null, $params = null, $culture = null) {
		$params = thx_culture_FormatParams::params($param, $params, "R");
		$format = $params->shift();
		switch($format) {
		case "O":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Objects_2"), 'execute');
		}break;
		case "R":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Objects_3"), 'execute');
		}break;
		default:{
			thx_core_Objects_4($culture, $format, $param, $params);
		}break;
		}
	}
	function __toString() { return 'thx.core.Objects'; }
}
function thx_core_Objects_0(&$a, &$b, &$c, &$equation, &$i, &$keys, $t) {
	{
		{
			$_g = 0; $_g1 = Reflect::fields($i);
			while($_g < $_g1->length) {
				$k = $_g1[$_g];
				++$_g;
				$c->{$k} = Reflect::callMethod($i, Reflect::field($i, $k), new _hx_array(array($t)));
				unset($k);
			}
		}
		return $c;
	}
}
function thx_core_Objects_1(&$new_ob, &$ob, $key, $old_v, $new_v) {
	{
		return $new_v;
	}
}
function thx_core_Objects_2(&$culture, &$format, &$param, &$params, $v) {
	{
		return Std::string($v);
	}
}
function thx_core_Objects_3(&$culture, &$format, &$param, &$params, $v) {
	{
		$buf = new _hx_array(array());
		{
			$_g = 0; $_g1 = Reflect::fields($v);
			while($_g < $_g1->length) {
				$field = $_g1[$_g];
				++$_g;
				$buf->push(_hx_string_or_null($field) . ":" . _hx_string_or_null(thx_core_Dynamics::format(Reflect::field($v, $field), null, null, null, $culture)));
				unset($field);
			}
		}
		return "{" . _hx_string_or_null($buf->join(",")) . "}";
	}
}
function thx_core_Objects_4(&$culture, &$format, &$param, &$params) {
	throw new HException(new thx_error_Error("Unsupported number format: {0}", null, $format, _hx_anonymous(array("fileName" => "Objects.hx", "lineNumber" => 243, "className" => "thx.core.Objects", "methodName" => "formatf"))));
}
