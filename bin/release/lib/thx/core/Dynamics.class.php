<?php

class thx_core_Dynamics {
	public function __construct(){}
	static function format($v, $param = null, $params = null, $nullstring = null, $culture = null) {
		return call_user_func_array(thx_core_Dynamics::formatf($param, $params, $nullstring, $culture), array($v));
	}
	static function formatf($param = null, $params = null, $nullstring = null, $culture = null) {
		if($nullstring === null) {
			$nullstring = "null";
		}
		return array(new _hx_lambda(array(&$culture, &$nullstring, &$param, &$params), "thx_core_Dynamics_0"), 'execute');
	}
	static function interpolate($v, $a, $b, $equation = null) {
		return call_user_func_array(thx_core_Dynamics::interpolatef($a, $b, $equation), array($v));
	}
	static function interpolatef($a, $b, $equation = null) {
		$ta = Type::typeof($a);
		$tb = Type::typeof($b);
		if(!((Std::is($a, _hx_qtype("Float")) || Std::is($a, _hx_qtype("Int"))) && (Std::is($b, _hx_qtype("Float")) || Std::is($b, _hx_qtype("Int")))) && !Type::enumEq($ta, $tb)) {
			throw new HException(new thx_error_Error("arguments a ({0}) and b ({0}) have different types", new _hx_array(array($a, $b)), null, _hx_anonymous(array("fileName" => "Dynamics.hx", "lineNumber" => 63, "className" => "thx.core.Dynamics", "methodName" => "interpolatef"))));
		}
		$__hx__t = ($ta);
		switch($__hx__t->index) {
		case 0:
		{
			return array(new _hx_lambda(array(&$a, &$b, &$equation, &$ta, &$tb), "thx_core_Dynamics_1"), 'execute');
		}break;
		case 1:
		{
			if(Std::is($b, _hx_qtype("Int"))) {
				return thx_core_Ints::interpolatef($a, $b, $equation);
			} else {
				return thx_core_Floats::interpolatef($a, $b, $equation);
			}
		}break;
		case 2:
		{
			return thx_core_Floats::interpolatef($a, $b, $equation);
		}break;
		case 3:
		{
			return thx_core_Bools::interpolatef($a, $b, $equation);
		}break;
		case 4:
		{
			return thx_core_Objects::interpolatef($a, $b, $equation);
		}break;
		case 6:
		$c = $__hx__t->params[0];
		{
			$name = Type::getClassName($c);
			switch($name) {
			case "String":{
				return thx_core_Strings::interpolatef($a, $b, $equation);
			}break;
			case "Date":{
				return thx_core_Dates::interpolatef($a, $b, $equation);
			}break;
			default:{
				throw new HException(new thx_error_Error("cannot interpolate on instances of {0}", null, $name, _hx_anonymous(array("fileName" => "Dynamics.hx", "lineNumber" => 81, "className" => "thx.core.Dynamics", "methodName" => "interpolatef"))));
			}break;
			}
		}break;
		default:{
			throw new HException(new thx_error_Error("cannot interpolate on functions/enums/unknown", null, null, _hx_anonymous(array("fileName" => "Dynamics.hx", "lineNumber" => 83, "className" => "thx.core.Dynamics", "methodName" => "interpolatef"))));
		}break;
		}
	}
	static function string($v) {
		$_g = Type::typeof($v);
		$__hx__t = ($_g);
		switch($__hx__t->index) {
		case 0:
		{
			return "null";
		}break;
		case 1:
		{
			return thx_core_Ints::format($v, null, null, null);
		}break;
		case 2:
		{
			return thx_core_Floats::format($v, null, null, null);
		}break;
		case 3:
		{
			return thx_core_Bools::format($v, null, null, null);
		}break;
		case 4:
		{
			$keys = thx_core_Dynamics_2($_g, $v);
			$result = new _hx_array(array());
			{
				$_g1 = 0;
				while($_g1 < $keys->length) {
					$key = $keys[$_g1];
					++$_g1;
					$result->push(_hx_string_or_null($key) . " : " . _hx_string_or_null(thx_core_Dynamics::string(Reflect::field($v, $key))));
					unset($key);
				}
			}
			return "{" . _hx_string_or_null($result->join(", ")) . "}";
		}break;
		case 6:
		$c = $__hx__t->params[0];
		{
			$name = Type::getClassName($c);
			switch($name) {
			case "Array":{
				return thx_core_Arrays::string($v);
			}break;
			case "String":{
				$s = $v;
				if(_hx_index_of($s, "\"", null) < 0) {
					return "\"" . _hx_string_or_null($s) . "\"";
				} else {
					if(_hx_index_of($s, "'", null) < 0) {
						return "'" . _hx_string_or_null($s) . "'";
					} else {
						return "\"" . _hx_string_or_null(str_replace("\"", "\\\"", $s)) . "\"";
					}
				}
			}break;
			case "Date":{
				return thx_core_Dates::format($v, null, null, null);
			}break;
			default:{
				return Std::string($v);
			}break;
			}
		}break;
		case 7:
		{
			return thx_core_Enums::string($v);
		}break;
		case 8:
		{
			return "<unknown>";
		}break;
		case 5:
		{
			return "<function>";
		}break;
		}
	}
	static function compare($a, $b) {
		if(null === $a && null === $b) {
			return 0;
		}
		if(null === $a) {
			return -1;
		}
		if(null === $b) {
			return 1;
		}
		{
			$_g = Type::typeof($a);
			$__hx__t = ($_g);
			switch($__hx__t->index) {
			case 1:
			case 2:
			{
				return thx_core_Dynamics_3($_g, $a, $b);
			}break;
			case 3:
			{
				return thx_core_Dynamics_4($_g, $a, $b);
			}break;
			case 4:
			{
				return thx_core_Objects::compare($a, $b);
			}break;
			case 6:
			$c = $__hx__t->params[0];
			{
				$name = Type::getClassName($c);
				switch($name) {
				case "Array":{
					return thx_core_Arrays::compare($a, $b);
				}break;
				case "String":{
					return thx_core_Strings::compare($a, $b);
				}break;
				case "Date":{
					return thx_core_Dynamics_5($_g, $a, $b, $c, $name);
				}break;
				default:{
					return thx_core_Strings::compare(Std::string($a), Std::string($b));
				}break;
				}
			}break;
			case 7:
			{
				return thx_core_Enums::compare($a, $b);
			}break;
			default:{
				return 0;
			}break;
			}
		}
	}
	static function comparef($sample) {
		$_g = Type::typeof($sample);
		$__hx__t = ($_g);
		switch($__hx__t->index) {
		case 1:
		case 2:
		{
			return (isset(thx_core_Floats::$compare) ? thx_core_Floats::$compare: array("thx_core_Floats", "compare"));
		}break;
		case 3:
		{
			return (isset(thx_core_Bools::$compare) ? thx_core_Bools::$compare: array("thx_core_Bools", "compare"));
		}break;
		case 4:
		{
			return (isset(thx_core_Objects::$compare) ? thx_core_Objects::$compare: array("thx_core_Objects", "compare"));
		}break;
		case 6:
		$c = $__hx__t->params[0];
		{
			$name = Type::getClassName($c);
			switch($name) {
			case "Array":{
				return (isset(thx_core_Arrays::$compare) ? thx_core_Arrays::$compare: array("thx_core_Arrays", "compare"));
			}break;
			case "String":{
				return (isset(thx_core_Strings::$compare) ? thx_core_Strings::$compare: array("thx_core_Strings", "compare"));
			}break;
			case "Date":{
				return (isset(thx_core_Dates::$compare) ? thx_core_Dates::$compare: array("thx_core_Dates", "compare"));
			}break;
			default:{
				return array(new _hx_lambda(array(&$_g, &$c, &$name, &$sample), "thx_core_Dynamics_6"), 'execute');
			}break;
			}
		}break;
		case 7:
		{
			return (isset(thx_core_Enums::$compare) ? thx_core_Enums::$compare: array("thx_core_Enums", "compare"));
		}break;
		default:{
			return (isset(thx_core_Dynamics::$compare) ? thx_core_Dynamics::$compare: array("thx_core_Dynamics", "compare"));
		}break;
		}
	}
	static function hclone($v, $cloneInstances = null) {
		if($cloneInstances === null) {
			$cloneInstances = false;
		}
		$_g = Type::typeof($v);
		$__hx__t = ($_g);
		switch($__hx__t->index) {
		case 0:
		{
			return null;
		}break;
		case 1:
		case 2:
		case 3:
		case 7:
		case 8:
		case 5:
		{
			return $v;
		}break;
		case 4:
		{
			$o = _hx_anonymous(array());
			thx_core_Objects::copyTo($v, $o);
			return $o;
		}break;
		case 6:
		$c = $__hx__t->params[0];
		{
			$name = Type::getClassName($c);
			switch($name) {
			case "Array":{
				$src = $v; $a = new _hx_array(array());
				{
					$_g1 = 0;
					while($_g1 < $src->length) {
						$i = $src[$_g1];
						++$_g1;
						$a->push(thx_core_Dynamics::hclone($i, null));
						unset($i);
					}
				}
				return $a;
			}break;
			case "String":case "Date":{
				return $v;
			}break;
			default:{
				if($cloneInstances) {
					$o = Type::createEmptyInstance($c);
					{
						$_g1 = 0; $_g2 = Reflect::fields($v);
						while($_g1 < $_g2->length) {
							$field = $_g2[$_g1];
							++$_g1;
							$o->{$field} = thx_core_Dynamics::hclone(Reflect::field($v, $field), null);
							unset($field);
						}
					}
					return $o;
				} else {
					return $v;
				}
			}break;
			}
		}break;
		}
	}
	static function same($a, $b) {
		$ta = thx_core_Types::typeName($a); $tb = thx_core_Types::typeName($b);
		if($ta !== $tb) {
			return false;
		}
		{
			$_g = Type::typeof($a);
			$__hx__t = ($_g);
			switch($__hx__t->index) {
			case 2:
			{
				return thx_core_Floats::equals($a, $b, null);
			}break;
			case 0:
			case 1:
			case 3:
			{
				return $a == $b;
			}break;
			case 5:
			{
				return Reflect::compareMethods($a, $b);
			}break;
			case 6:
			$c = $__hx__t->params[0];
			{
				$ca = Type::getClassName($c); $cb = Type::getClassName(Type::getClass($b));
				if($ca !== $cb) {
					return false;
				}
				if(Std::is($a, _hx_qtype("String")) && $a != $b) {
					return false;
				}
				if(Std::is($a, _hx_qtype("Array"))) {
					$aa = $a; $ab = $b;
					if($aa->length !== $ab->length) {
						return false;
					}
					{
						$_g2 = 0; $_g1 = $aa->length;
						while($_g2 < $_g1) {
							$i = $_g2++;
							if(!thx_core_Dynamics::same($aa[$i], $ab[$i])) {
								return false;
							}
							unset($i);
						}
					}
					return true;
				}
				if(Std::is($a, _hx_qtype("Date"))) {
					return _hx_equal($a->getTime(), $b->getTime());
				}
				if(Std::is($a, _hx_qtype("_Map.Map_Impl_")) || Std::is($a, _hx_qtype("haxe.ds.StringMap")) || Std::is($a, _hx_qtype("haxe.ds.IntMap"))) {
					$ha = $a; $hb = $b;
					$ka = thx_core_Iterators::harray($ha->keys()); $kb = thx_core_Iterators::harray($hb->keys());
					if($ka->length !== $kb->length) {
						return false;
					}
					{
						$_g1 = 0;
						while($_g1 < $ka->length) {
							$key = $ka[$_g1];
							++$_g1;
							if(!$hb->exists($key) || !thx_core_Dynamics::same($ha->get($key), $hb->get($key))) {
								return false;
							}
							unset($key);
						}
					}
					return true;
				}
				$t = false;
				if(($t = thx_core_Iterators::isIterator($a)) || thx_core_Iterables::isIterable($a)) {
					$va = (($t) ? thx_core_Iterators::harray($a) : thx_core_Iterators::harray($a->iterator())); $vb = (($t) ? thx_core_Iterators::harray($b) : thx_core_Iterators::harray($b->iterator()));
					if($va->length !== $vb->length) {
						return false;
					}
					{
						$_g2 = 0; $_g1 = $va->length;
						while($_g2 < $_g1) {
							$i = $_g2++;
							if(!thx_core_Dynamics::same($va[$i], $vb[$i])) {
								return false;
							}
							unset($i);
						}
					}
					return true;
				}
				$fields = Type::getInstanceFields(Type::getClass($a));
				{
					$_g1 = 0;
					while($_g1 < $fields->length) {
						$field = $fields[$_g1];
						++$_g1;
						$va = Reflect::field($a, $field);
						if(Reflect::isFunction($va)) {
							continue;
						}
						$vb = Reflect::field($b, $field);
						if(!thx_core_Dynamics::same($va, $vb)) {
							return false;
						}
						unset($vb,$va,$field);
					}
				}
				return true;
			}break;
			case 7:
			$e = $__hx__t->params[0];
			{
				$ea = Type::getEnumName($e); $teb = Type::getEnum($b); $eb = Type::getEnumName($teb);
				if($ea !== $eb) {
					return false;
				}
				if($a->index !== $b->index) {
					return false;
				}
				$pa = Type::enumParameters($a); $pb = Type::enumParameters($b);
				{
					$_g2 = 0; $_g1 = $pa->length;
					while($_g2 < $_g1) {
						$i = $_g2++;
						if(!thx_core_Dynamics::same($pa[$i], $pb[$i])) {
							return false;
						}
						unset($i);
					}
				}
				return true;
			}break;
			case 4:
			{
				$fa = Reflect::fields($a); $fb = Reflect::fields($b);
				{
					$_g1 = 0;
					while($_g1 < $fa->length) {
						$field = $fa[$_g1];
						++$_g1;
						$fb->remove($field);
						if(!_hx_has_field($b, $field)) {
							return false;
						}
						$va = Reflect::field($a, $field);
						if(Reflect::isFunction($va)) {
							continue;
						}
						$vb = Reflect::field($b, $field);
						if(!thx_core_Dynamics::same($va, $vb)) {
							return false;
						}
						unset($vb,$va,$field);
					}
				}
				if($fb->length > 0) {
					return false;
				}
				$t = false;
				if(($t = thx_core_Iterators::isIterator($a)) || thx_core_Iterables::isIterable($a)) {
					if($t && !thx_core_Iterators::isIterator($b)) {
						return false;
					}
					if(!$t && !thx_core_Iterables::isIterable($b)) {
						return false;
					}
					$aa = (($t) ? thx_core_Iterators::harray($a) : thx_core_Iterators::harray($a->iterator()));
					$ab = (($t) ? thx_core_Iterators::harray($b) : thx_core_Iterators::harray($b->iterator()));
					if($aa->length !== $ab->length) {
						return false;
					}
					{
						$_g2 = 0; $_g1 = $aa->length;
						while($_g2 < $_g1) {
							$i = $_g2++;
							if(!thx_core_Dynamics::same($aa[$i], $ab[$i])) {
								return false;
							}
							unset($i);
						}
					}
					return true;
				}
				return true;
			}break;
			case 8:
			{
				thx_core_Dynamics_7($_g, $a, $b, $ta, $tb);
			}break;
			}
		}
		thx_core_Dynamics_8($a, $b, $ta, $tb);
	}
	static function number($v) {
		if(Std::is($v, _hx_qtype("Bool"))) {
			return ((_hx_equal($v, true)) ? 1 : 0);
		} else {
			if(Std::is($v, _hx_qtype("Date"))) {
				return $v->getTime();
			} else {
				if(Std::is($v, _hx_qtype("String"))) {
					return Std::parseFloat($v);
				} else {
					return Math::$NaN;
				}
			}
		}
	}
	function __toString() { return 'thx.core.Dynamics'; }
}
function thx_core_Dynamics_0(&$culture, &$nullstring, &$param, &$params, $v) {
	{
		$_g = Type::typeof($v);
		$__hx__t = ($_g);
		switch($__hx__t->index) {
		case 0:
		{
			return $nullstring;
		}break;
		case 1:
		{
			return thx_core_Ints::format($v, $param, $params, $culture);
		}break;
		case 2:
		{
			return thx_core_Floats::format($v, $param, $params, $culture);
		}break;
		case 3:
		{
			return thx_core_Bools::format($v, $param, $params, $culture);
		}break;
		case 6:
		$c = $__hx__t->params[0];
		{
			if($c == _hx_qtype("String")) {
				return thx_core_Strings::formatOne($v, $param, $params, $culture);
			} else {
				if($c == _hx_qtype("Array")) {
					return thx_core_Arrays::format($v, $param, $params, $culture);
				} else {
					if($c == _hx_qtype("Date")) {
						return thx_core_Dates::format($v, $param, $params, $culture);
					} else {
						return thx_core_Objects::format($v, $param, $params, $culture);
					}
				}
			}
		}break;
		case 4:
		{
			return thx_core_Objects::format($v, $param, $params, $culture);
		}break;
		case 5:
		{
			return "function()";
		}break;
		default:{
			thx_core_Dynamics_9($_g, $culture, $nullstring, $param, $params, $v);
		}break;
		}
	}
}
function thx_core_Dynamics_1(&$a, &$b, &$equation, &$ta, &$tb, $_) {
	{
		return null;
	}
}
function thx_core_Dynamics_2(&$_g, &$v) {
	{
		$o = $v;
		return Reflect::fields($o);
	}
}
function thx_core_Dynamics_3(&$_g, &$a, &$b) {
	{
		$a1 = $a; $b1 = $b;
		if($a1 < $b1) {
			return -1;
		} else {
			if($a1 > $b1) {
				return 1;
			} else {
				return 0;
			}
		}
		unset($b1,$a1);
	}
}
function thx_core_Dynamics_4(&$_g, &$a, &$b) {
	{
		$a1 = $a; $b1 = $b;
		if($a1 === $b1) {
			return 0;
		} else {
			if($a1) {
				return -1;
			} else {
				return 1;
			}
		}
		unset($b1,$a1);
	}
}
function thx_core_Dynamics_5(&$_g, &$a, &$b, &$c, &$name) {
	{
		$a1 = $a; $b1 = $b;
		{
			$a2 = $a1->getTime(); $b2 = $b1->getTime();
			if($a2 < $b2) {
				return -1;
			} else {
				if($a2 > $b2) {
					return 1;
				} else {
					return 0;
				}
			}
			unset($b2,$a2);
		}
		unset($b1,$a1);
	}
}
function thx_core_Dynamics_6(&$_g, &$c, &$name, &$sample, $a, $b) {
	{
		return thx_core_Strings::compare(Std::string($a), Std::string($b));
	}
}
function thx_core_Dynamics_7(&$_g, &$a, &$b, &$ta, &$tb) {
	throw new HException("Unable to compare two unknown types");
}
function thx_core_Dynamics_8(&$a, &$b, &$ta, &$tb) {
	throw new HException(new thx_error_Error("Unable to compare values: {0} and {1}", new _hx_array(array($a, $b)), null, _hx_anonymous(array("fileName" => "Dynamics.hx", "lineNumber" => 372, "className" => "thx.core.Dynamics", "methodName" => "same"))));
}
function thx_core_Dynamics_9(&$_g, &$culture, &$nullstring, &$param, &$params, &$v) {
	throw new HException(new thx_error_Error("Unsupported type format: {0}", null, Type::typeof($v), _hx_anonymous(array("fileName" => "Dynamics.hx", "lineNumber" => 48, "className" => "thx.core.Dynamics", "methodName" => "formatf"))));
}
