<?php

class haxe_rtti_XmlParser {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->root = new _hx_array(array());
	}}
	public function defplat() {
		$l = new HList();
		if($this->curplatform !== null) {
			$l->add($this->curplatform);
		}
		return $l;
	}
	public function xtypeparams($x) {
		$p = new HList();
		if(null == $x) throw new HException('null iterable');
		$__hx__it = $x->get_elements();
		while($__hx__it->hasNext()) {
			$c = $__hx__it->next();
			$p->add($this->xtype($c));
		}
		return $p;
	}
	public function xtype($x) {
		return haxe_rtti_XmlParser_0($this, $x);
	}
	public function xtypedef($x) {
		$doc = null;
		$t = null;
		$meta = new _hx_array(array());
		if(null == $x) throw new HException('null iterable');
		$__hx__it = $x->get_elements();
		while($__hx__it->hasNext()) {
			$c = $__hx__it->next();
			if($c->get_name() === "haxe_doc") {
				$doc = $c->get_innerData();
			} else {
				if($c->get_name() === "meta") {
					$meta = $this->xmeta($c);
				} else {
					$t = $this->xtype($c);
				}
			}
		}
		$types = new haxe_ds_StringMap();
		if($this->curplatform !== null) {
			$types->set($this->curplatform, $t);
		}
		return _hx_anonymous(array("file" => (($x->has->resolve("file")) ? $x->att->resolve("file") : null), "path" => $this->mkPath($x->att->resolve("path")), "module" => (($x->has->resolve("module")) ? $this->mkPath($x->att->resolve("module")) : null), "doc" => $doc, "isPrivate" => $x->x->exists("private"), "params" => $this->mkTypeParams($x->att->resolve("params")), "type" => $t, "types" => $types, "platforms" => $this->defplat(), "meta" => $meta));
	}
	public function xabstract($x) {
		$doc = null;
		$meta = new _hx_array(array()); $subs = new _hx_array(array()); $supers = new _hx_array(array());
		if(null == $x) throw new HException('null iterable');
		$__hx__it = $x->get_elements();
		while($__hx__it->hasNext()) {
			$c = $__hx__it->next();
			$_g = $c->get_name();
			switch($_g) {
			case "haxe_doc":{
				$doc = $c->get_innerData();
			}break;
			case "meta":{
				$meta = $this->xmeta($c);
			}break;
			case "to":{
				if(null == $c) throw new HException('null iterable');
				$__hx__it2 = $c->get_elements();
				while($__hx__it2->hasNext()) {
					$t = $__hx__it2->next();
					$subs->push($this->xtype($t));
				}
			}break;
			case "from":{
				if(null == $c) throw new HException('null iterable');
				$__hx__it2 = $c->get_elements();
				while($__hx__it2->hasNext()) {
					$t = $__hx__it2->next();
					$supers->push($this->xtype($t));
				}
			}break;
			default:{
				$this->xerror($c);
			}break;
			}
			unset($_g);
		}
		return _hx_anonymous(array("file" => (($x->has->resolve("file")) ? $x->att->resolve("file") : null), "path" => $this->mkPath($x->att->resolve("path")), "module" => (($x->has->resolve("module")) ? $this->mkPath($x->att->resolve("module")) : null), "doc" => $doc, "isPrivate" => $x->x->exists("private"), "params" => $this->mkTypeParams($x->att->resolve("params")), "platforms" => $this->defplat(), "meta" => $meta, "subs" => $subs, "supers" => $supers));
	}
	public function xenumfield($x) {
		$args = null;
		$xdoc = $x->x->elementsNamed("haxe_doc")->next();
		$meta = (($x->hasNode->resolve("meta")) ? $this->xmeta($x->node->resolve("meta")) : new _hx_array(array()));
		if($x->has->resolve("a")) {
			$names = _hx_explode(":", $x->att->resolve("a"));
			$elts = $x->get_elements();
			$args = new HList();
			{
				$_g = 0;
				while($_g < $names->length) {
					$c = $names[$_g];
					++$_g;
					$opt = false;
					if(_hx_char_at($c, 0) === "?") {
						$opt = true;
						$c = _hx_substr($c, 1, null);
					}
					$args->add(_hx_anonymous(array("name" => $c, "opt" => $opt, "t" => $this->xtype($elts->next()))));
					unset($opt,$c);
				}
			}
		}
		return _hx_anonymous(array("name" => $x->get_name(), "args" => $args, "doc" => (($xdoc === null) ? null : _hx_deref(new haxe_xml_Fast($xdoc))->get_innerData()), "meta" => $meta, "platforms" => $this->defplat()));
	}
	public function xenum($x) {
		$cl = new HList();
		$doc = null;
		$meta = new _hx_array(array());
		if(null == $x) throw new HException('null iterable');
		$__hx__it = $x->get_elements();
		while($__hx__it->hasNext()) {
			$c = $__hx__it->next();
			if($c->get_name() === "haxe_doc") {
				$doc = $c->get_innerData();
			} else {
				if($c->get_name() === "meta") {
					$meta = $this->xmeta($c);
				} else {
					$cl->add($this->xenumfield($c));
				}
			}
		}
		return _hx_anonymous(array("file" => (($x->has->resolve("file")) ? $x->att->resolve("file") : null), "path" => $this->mkPath($x->att->resolve("path")), "module" => (($x->has->resolve("module")) ? $this->mkPath($x->att->resolve("module")) : null), "doc" => $doc, "isPrivate" => $x->x->exists("private"), "isExtern" => $x->x->exists("extern"), "params" => $this->mkTypeParams($x->att->resolve("params")), "constructors" => $cl, "platforms" => $this->defplat(), "meta" => $meta));
	}
	public function xclassfield($x, $defPublic = null) {
		$e = $x->get_elements();
		$t = $this->xtype($e->next());
		$doc = null;
		$meta = new _hx_array(array());
		$__hx__it = $e;
		while($__hx__it->hasNext()) {
			$c = $__hx__it->next();
			$_g = $c->get_name();
			switch($_g) {
			case "haxe_doc":{
				$doc = $c->get_innerData();
			}break;
			case "meta":{
				$meta = $this->xmeta($c);
			}break;
			default:{
				$this->xerror($c);
			}break;
			}
			unset($_g);
		}
		return _hx_anonymous(array("name" => $x->get_name(), "type" => $t, "isPublic" => $x->x->exists("public") || $defPublic, "isOverride" => $x->x->exists("override"), "line" => (($x->has->resolve("line")) ? Std::parseInt($x->att->resolve("line")) : null), "doc" => $doc, "get" => (($x->has->resolve("get")) ? $this->mkRights($x->att->resolve("get")) : haxe_rtti_Rights::$RNormal), "set" => (($x->has->resolve("set")) ? $this->mkRights($x->att->resolve("set")) : haxe_rtti_Rights::$RNormal), "params" => (($x->has->resolve("params")) ? $this->mkTypeParams($x->att->resolve("params")) : null), "platforms" => $this->defplat(), "meta" => $meta));
	}
	public function xclass($x) {
		$csuper = null;
		$doc = null;
		$tdynamic = null;
		$interfaces = new HList();
		$fields = new HList();
		$statics = new HList();
		$meta = new _hx_array(array());
		if(null == $x) throw new HException('null iterable');
		$__hx__it = $x->get_elements();
		while($__hx__it->hasNext()) {
			$c = $__hx__it->next();
			$_g = $c->get_name();
			switch($_g) {
			case "haxe_doc":{
				$doc = $c->get_innerData();
			}break;
			case "extends":{
				$csuper = $this->xpath($c);
			}break;
			case "implements":{
				$interfaces->add($this->xpath($c));
			}break;
			case "haxe_dynamic":{
				$tdynamic = $this->xtype(new haxe_xml_Fast($c->x->firstElement()));
			}break;
			case "meta":{
				$meta = $this->xmeta($c);
			}break;
			default:{
				if($c->x->exists("static")) {
					$statics->add($this->xclassfield($c, null));
				} else {
					$fields->add($this->xclassfield($c, null));
				}
			}break;
			}
			unset($_g);
		}
		return _hx_anonymous(array("file" => (($x->has->resolve("file")) ? $x->att->resolve("file") : null), "path" => $this->mkPath($x->att->resolve("path")), "module" => (($x->has->resolve("module")) ? $this->mkPath($x->att->resolve("module")) : null), "doc" => $doc, "isPrivate" => $x->x->exists("private"), "isExtern" => $x->x->exists("extern"), "isInterface" => $x->x->exists("interface"), "params" => $this->mkTypeParams($x->att->resolve("params")), "superClass" => $csuper, "interfaces" => $interfaces, "fields" => $fields, "statics" => $statics, "tdynamic" => $tdynamic, "platforms" => $this->defplat(), "meta" => $meta));
	}
	public function xpath($x) {
		$path = $this->mkPath($x->att->resolve("path"));
		$params = new HList();
		if(null == $x) throw new HException('null iterable');
		$__hx__it = $x->get_elements();
		while($__hx__it->hasNext()) {
			$c = $__hx__it->next();
			$params->add($this->xtype($c));
		}
		return _hx_anonymous(array("path" => $path, "params" => $params));
	}
	public function xmeta($x) {
		$ml = new _hx_array(array());
		if(null == $x->nodes->resolve("m")) throw new HException('null iterable');
		$__hx__it = $x->nodes->resolve("m")->iterator();
		while($__hx__it->hasNext()) {
			$m = $__hx__it->next();
			$pl = new _hx_array(array());
			if(null == $m->nodes->resolve("e")) throw new HException('null iterable');
			$__hx__it2 = $m->nodes->resolve("e")->iterator();
			while($__hx__it2->hasNext()) {
				$p = $__hx__it2->next();
				$pl->push($p->get_innerHTML());
			}
			$ml->push(_hx_anonymous(array("name" => $m->att->resolve("n"), "params" => $pl)));
			unset($pl);
		}
		return $ml;
	}
	public function processElement($x) {
		$c = new haxe_xml_Fast($x);
		return haxe_rtti_XmlParser_1($this, $c, $x);
	}
	public function xerror($c) {
		haxe_rtti_XmlParser_2($this, $c);
	}
	public function mkRights($r) {
		return haxe_rtti_XmlParser_3($this, $r);
	}
	public function mkTypeParams($p) {
		$pl = _hx_explode(":", $p);
		if($pl[0] === "") {
			return new _hx_array(array());
		}
		return $pl;
	}
	public function mkPath($p) {
		return $p;
	}
	public $curplatform;
	public $root;
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
	function __toString() { return 'haxe.rtti.XmlParser'; }
}
function haxe_rtti_XmlParser_0(&$__hx__this, &$x) {
	{
		$_g = $x->get_name();
		switch($_g) {
		case "unknown":{
			return haxe_rtti_CType::$CUnknown;
		}break;
		case "e":{
			return haxe_rtti_CType::CEnum($__hx__this->mkPath($x->att->resolve("path")), $__hx__this->xtypeparams($x));
		}break;
		case "c":{
			return haxe_rtti_CType::CClass($__hx__this->mkPath($x->att->resolve("path")), $__hx__this->xtypeparams($x));
		}break;
		case "t":{
			return haxe_rtti_CType::CTypedef($__hx__this->mkPath($x->att->resolve("path")), $__hx__this->xtypeparams($x));
		}break;
		case "x":{
			return haxe_rtti_CType::CAbstract($__hx__this->mkPath($x->att->resolve("path")), $__hx__this->xtypeparams($x));
		}break;
		case "f":{
			$args = new HList();
			$aname = _hx_explode(":", $x->att->resolve("a"));
			$eargs = $aname->iterator();
			if(null == $x) throw new HException('null iterable');
			$__hx__it = $x->get_elements();
			while($__hx__it->hasNext()) {
				$e = $__hx__it->next();
				$opt = false;
				$a = $eargs->next();
				if($a === null) {
					$a = "";
				}
				if(_hx_char_at($a, 0) === "?") {
					$opt = true;
					$a = _hx_substr($a, 1, null);
				}
				$args->add(_hx_anonymous(array("name" => $a, "opt" => $opt, "t" => $__hx__this->xtype($e))));
				unset($opt,$a);
			}
			$ret = $args->last();
			$args->remove($ret);
			return haxe_rtti_CType::CFunction($args, $ret->t);
		}break;
		case "a":{
			$fields = new HList();
			if(null == $x) throw new HException('null iterable');
			$__hx__it = $x->get_elements();
			while($__hx__it->hasNext()) {
				$f = $__hx__it->next();
				$f1 = $__hx__this->xclassfield($f, true);
				$f1->platforms = new HList();
				$fields->add($f1);
				unset($f1);
			}
			return haxe_rtti_CType::CAnonymous($fields);
		}break;
		case "d":{
			$t = null;
			$tx = $x->x->firstElement();
			if($tx !== null) {
				$t = $__hx__this->xtype(new haxe_xml_Fast($tx));
			}
			return haxe_rtti_CType::CDynamic($t);
		}break;
		default:{
			return $__hx__this->xerror($x);
		}break;
		}
		unset($_g);
	}
}
function haxe_rtti_XmlParser_1(&$__hx__this, &$c, &$x) {
	{
		$_g = $c->get_name();
		switch($_g) {
		case "class":{
			return haxe_rtti_TypeTree::TClassdecl($__hx__this->xclass($c));
		}break;
		case "enum":{
			return haxe_rtti_TypeTree::TEnumdecl($__hx__this->xenum($c));
		}break;
		case "typedef":{
			return haxe_rtti_TypeTree::TTypedecl($__hx__this->xtypedef($c));
		}break;
		case "abstract":{
			return haxe_rtti_TypeTree::TAbstractdecl($__hx__this->xabstract($c));
		}break;
		default:{
			return $__hx__this->xerror($c);
		}break;
		}
		unset($_g);
	}
}
function haxe_rtti_XmlParser_2(&$__hx__this, &$c) {
	throw new HException("Invalid " . _hx_string_or_null($c->get_name()));
}
function haxe_rtti_XmlParser_3(&$__hx__this, &$r) {
	switch($r) {
	case "null":{
		return haxe_rtti_Rights::$RNo;
	}break;
	case "method":{
		return haxe_rtti_Rights::$RMethod;
	}break;
	case "dynamic":{
		return haxe_rtti_Rights::$RDynamic;
	}break;
	case "inline":{
		return haxe_rtti_Rights::$RInline;
	}break;
	default:{
		return haxe_rtti_Rights::RCall($r);
	}break;
	}
}
