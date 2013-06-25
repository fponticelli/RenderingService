<?php

class thx_type_Rttis {
	public function __construct(){}
	static function typeName($type, $opt) {
		$__hx__t = ($type);
		switch($__hx__t->index) {
		case 4:
		{
			return (($opt) ? "Null<function>" : "function");
		}break;
		case 0:
		{
			return (($opt) ? "Null<unknown>" : "unknown");
		}break;
		case 5:
		case 6:
		{
			return (($opt) ? "Null<Dynamic>" : "Dynamic");
		}break;
		case 3:
		$params = $__hx__t->params[1]; $name = $__hx__t->params[0];
		{
			if($name === "Null") {
				if($opt) {
					$t = $name;
					if($params !== null && $params->length > 0) {
						$types = new _hx_array(array());
						if(null == $params) throw new HException('null iterable');
						$__hx__it = $params->iterator();
						while($__hx__it->hasNext()) {
							$p = $__hx__it->next();
							$types->push(thx_type_Rttis::typeName($p, false));
						}
						$t .= "<" . _hx_string_or_null($types->join(",")) . ">";
					}
					return $t;
				} else {
					return thx_type_Rttis::typeName($params->first(), false);
				}
			} else {
				$t = $name;
				if($params !== null && $params->length > 0) {
					$types = new _hx_array(array());
					if(null == $params) throw new HException('null iterable');
					$__hx__it = $params->iterator();
					while($__hx__it->hasNext()) {
						$p = $__hx__it->next();
						$types->push(thx_type_Rttis::typeName($p, false));
					}
					$t .= "<" . _hx_string_or_null($types->join(",")) . ">";
				}
				return thx_type_Rttis_0($name, $opt, $params, $t, $type);
			}
		}break;
		case 7:
		$params = $__hx__t->params[1]; $name = $__hx__t->params[0];
		{
			if($name === "Null") {
				if($opt) {
					$t = $name;
					if($params !== null && $params->length > 0) {
						$types = new _hx_array(array());
						if(null == $params) throw new HException('null iterable');
						$__hx__it = $params->iterator();
						while($__hx__it->hasNext()) {
							$p = $__hx__it->next();
							$types->push(thx_type_Rttis::typeName($p, false));
						}
						$t .= "<" . _hx_string_or_null($types->join(",")) . ">";
					}
					return $t;
				} else {
					return thx_type_Rttis::typeName($params->first(), false);
				}
			} else {
				$t = $name;
				if($params !== null && $params->length > 0) {
					$types = new _hx_array(array());
					if(null == $params) throw new HException('null iterable');
					$__hx__it = $params->iterator();
					while($__hx__it->hasNext()) {
						$p = $__hx__it->next();
						$types->push(thx_type_Rttis::typeName($p, false));
					}
					$t .= "<" . _hx_string_or_null($types->join(",")) . ">";
				}
				return thx_type_Rttis_1($name, $opt, $params, $t, $type);
			}
		}break;
		case 1:
		$params = $__hx__t->params[1]; $name = $__hx__t->params[0];
		{
			$t = $name;
			if($params !== null && $params->length > 0) {
				$types = new _hx_array(array());
				if(null == $params) throw new HException('null iterable');
				$__hx__it = $params->iterator();
				while($__hx__it->hasNext()) {
					$p = $__hx__it->next();
					$types->push(thx_type_Rttis::typeName($p, false));
				}
				$t .= "<" . _hx_string_or_null($types->join(",")) . ">";
			}
			return thx_type_Rttis_2($name, $opt, $params, $t, $type);
		}break;
		case 2:
		$params = $__hx__t->params[1]; $name = $__hx__t->params[0];
		{
			$t = $name;
			if($params !== null && $params->length > 0) {
				$types = new _hx_array(array());
				if(null == $params) throw new HException('null iterable');
				$__hx__it = $params->iterator();
				while($__hx__it->hasNext()) {
					$p = $__hx__it->next();
					$types->push(thx_type_Rttis::typeName($p, false));
				}
				$t .= "<" . _hx_string_or_null($types->join(",")) . ">";
			}
			return thx_type_Rttis_3($name, $opt, $params, $t, $type);
		}break;
		}
	}
	static function typePath($type) {
		$__hx__t = ($type);
		switch($__hx__t->index) {
		case 4:
		case 0:
		case 5:
		case 6:
		case 3:
		case 7:
		{
			return null;
		}break;
		case 1:
		$type_eCEnum_1 = $__hx__t->params[1]; $name = $__hx__t->params[0];
		{
			return $name;
		}break;
		case 2:
		$type_eCClass_1 = $__hx__t->params[1]; $name = $__hx__t->params[0];
		{
			return $name;
		}break;
		}
	}
	static function methodArgumentTypes($cls, $method) {
		$fields = thx_type_Rttis::getClassFields($cls);
		if(null === $fields) {
			return null;
		}
		$field = $fields->get($method);
		if(null === $field) {
			return null;
		}
		$result = new _hx_array(array());
		{
			$_g = 0; $_g1 = thx_type_Rttis::methodArguments($field);
			while($_g < $_g1->length) {
				$arg = $_g1[$_g];
				++$_g;
				$result->push(thx_type_Rttis::typeName($arg->t, $arg->opt));
				unset($arg);
			}
		}
		return $result;
	}
	static function methodArguments($field) {
		$__hx__t = ($field->type);
		switch($__hx__t->index) {
		case 4:
		$field_ftype_eCFunction_1 = $__hx__t->params[1]; $args = $__hx__t->params[0];
		{
			return Lambda::harray($args);
		}break;
		default:{
			return null;
		}break;
		}
	}
	static function methodReturnType($field) {
		$__hx__t = ($field->type);
		switch($__hx__t->index) {
		case 4:
		$ret = $__hx__t->params[1]; $field_ftype_eCFunction_0 = $__hx__t->params[0];
		{
			return $ret;
		}break;
		default:{
			return null;
		}break;
		}
	}
	static function argumentAcceptNull($arg) {
		if($arg->opt) {
			return true;
		}
		$__hx__t = ($arg->t);
		switch($__hx__t->index) {
		case 3:
		$arg_ft_eCTypedef_1 = $__hx__t->params[1]; $n = $__hx__t->params[0];
		{
			return "Null" === $n;
		}break;
		default:{
			return false;
		}break;
		}
	}
	static function getClassFields($cls) {
		return thx_type_Rttis::unifyFields(thx_type_Rttis::getClassDef($cls), null);
	}
	static function typeParametersMap($cls, $Map = null) {
		if(null === $Map) {
			$Map = new haxe_ds_StringMap();
		}
		$c = thx_type_Rttis::getClassDef($cls);
		if(null !== _hx_field($c, "superClass")) {
			$sp = $c->superClass->path;
			$sc = Type::resolveClass($sp);
			thx_type_Rttis::typeParametersMap($sc, $Map);
			$s = thx_type_Rttis::getClassDef($sc);
			$i = 0;
			if(null == $c->superClass->params) throw new HException('null iterable');
			$__hx__it = $c->superClass->params->iterator();
			while($__hx__it->hasNext()) {
				$param = $__hx__it->next();
				$Map->set(_hx_string_or_null($sp) . "." . _hx_string_or_null($s->params[$i++]), $param);
			}
		}
		return $Map;
	}
	static function unifyFields($cls, $h = null) {
		if($h === null) {
			$h = new haxe_ds_StringMap();
		}
		if(null == $cls->fields) throw new HException('null iterable');
		$__hx__it = $cls->fields->iterator();
		while($__hx__it->hasNext()) {
			$f = $__hx__it->next();
			if(!$h->exists($f->name)) {
				$h->set($f->name, $f);
			}
		}
		$parent = $cls->superClass;
		if($parent !== null) {
			$pcls = Type::resolveClass($parent->path);
			$x = Xml::parse($pcls->__rtti)->firstElement();
			{
				$_g = _hx_deref(new haxe_rtti_XmlParser())->processElement($x);
				$__hx__t = ($_g);
				switch($__hx__t->index) {
				case 1:
				$c = $__hx__t->params[0];
				{
					thx_type_Rttis::unifyFields($c, $h);
				}break;
				default:{
					throw new HException(new thx_error_Error("Invalid type parent type ({0}) for class: {1}", new _hx_array(array($parent->path, $cls)), null, _hx_anonymous(array("fileName" => "Rttis.hx", "lineNumber" => 158, "className" => "thx.type.Rttis", "methodName" => "unifyFields"))));
				}break;
				}
			}
		}
		return $h;
	}
	static function hasInfo($cls) {
		return null !== _hx_field($cls, "__rtti");
	}
	static $_cache;
	static function getClassDef($cls) {
		$name = Type::getClassName($cls);
		if(thx_type_Rttis::$_cache->exists($name)) {
			return thx_type_Rttis::$_cache->get($name);
		}
		$x = Xml::parse($cls->__rtti)->firstElement();
		$infos = _hx_deref(new haxe_rtti_XmlParser())->processElement($x);
		$__hx__t = ($infos);
		switch($__hx__t->index) {
		case 1:
		$c = $__hx__t->params[0];
		{
			thx_type_Rttis::$_cache->set($name, $c);
			return $c;
		}break;
		default:{
			thx_type_Rttis_4($cls, $infos, $name, $x);
		}break;
		}
	}
	static function isMethod($field) {
		return thx_type_Rttis_5($field);
	}
	function __toString() { return 'thx.type.Rttis'; }
}
thx_type_Rttis::$_cache = new haxe_ds_StringMap();
function thx_type_Rttis_0(&$name, &$opt, &$params, &$t, &$type) {
	if($opt) {
		return "Null<" . _hx_string_or_null($t) . ">";
	} else {
		return $t;
	}
}
function thx_type_Rttis_1(&$name, &$opt, &$params, &$t, &$type) {
	if($opt) {
		return "Null<" . _hx_string_or_null($t) . ">";
	} else {
		return $t;
	}
}
function thx_type_Rttis_2(&$name, &$opt, &$params, &$t, &$type) {
	if($opt) {
		return "Null<" . _hx_string_or_null($t) . ">";
	} else {
		return $t;
	}
}
function thx_type_Rttis_3(&$name, &$opt, &$params, &$t, &$type) {
	if($opt) {
		return "Null<" . _hx_string_or_null($t) . ">";
	} else {
		return $t;
	}
}
function thx_type_Rttis_4(&$cls, &$infos, &$name, &$x) {
	throw new HException(new thx_error_Error("not a class!", null, null, _hx_anonymous(array("fileName" => "Rttis.hx", "lineNumber" => 185, "className" => "thx.type.Rttis", "methodName" => "getClassDef"))));
}
function thx_type_Rttis_5(&$field) {
	$__hx__t = ($field->type);
	switch($__hx__t->index) {
	case 4:
	{
		return true;
	}break;
	default:{
		return false;
	}break;
	}
}
