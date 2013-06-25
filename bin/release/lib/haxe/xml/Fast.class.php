<?php

class haxe_xml_Fast {
	public function __construct($x) {
		if(!php_Boot::$skip_constructor) {
		if($x->nodeType != Xml::$Document && $x->nodeType != Xml::$Element) {
			throw new HException("Invalid nodeType " . Std::string($x->nodeType));
		}
		$this->x = $x;
		$this->node = new haxe_xml__Fast_NodeAccess($x);
		$this->nodes = new haxe_xml__Fast_NodeListAccess($x);
		$this->att = new haxe_xml__Fast_AttribAccess($x);
		$this->has = new haxe_xml__Fast_HasAttribAccess($x);
		$this->hasNode = new haxe_xml__Fast_HasNodeAccess($x);
	}}
	public function get_elements() {
		$it = $this->x->elements();
		return _hx_anonymous(array("hasNext" => (isset($it->hasNext) ? $it->hasNext: array($it, "hasNext")), "next" => array(new _hx_lambda(array(&$it), "haxe_xml_Fast_0"), 'execute')));
	}
	public function get_innerHTML() {
		$s = new StringBuf();
		if(null == $this->x) throw new HException('null iterable');
		$__hx__it = $this->x->iterator();
		while($__hx__it->hasNext()) {
			$x = $__hx__it->next();
			$s->add($x->toString());
		}
		return $s->b;
	}
	public function get_innerData() {
		$it = $this->x->iterator();
		if(!$it->hasNext()) {
			throw new HException(_hx_string_or_null($this->get_name()) . " does not have data");
		}
		$v = $it->next();
		$n = $it->next();
		if($n !== null) {
			if($v->nodeType == Xml::$PCData && $n->nodeType == Xml::$CData && trim($v->get_nodeValue()) === "") {
				$n2 = $it->next();
				if($n2 === null || $n2->nodeType == Xml::$PCData && trim($n2->get_nodeValue()) === "" && $it->next() === null) {
					return $n->get_nodeValue();
				}
			}
			throw new HException(_hx_string_or_null($this->get_name()) . " does not only have data");
		}
		if($v->nodeType != Xml::$PCData && $v->nodeType != Xml::$CData) {
			throw new HException(_hx_string_or_null($this->get_name()) . " does not have data");
		}
		return $v->get_nodeValue();
	}
	public function get_name() {
		return (($this->x->nodeType == Xml::$Document) ? "Document" : $this->x->get_nodeName());
	}
	public $hasNode;
	public $has;
	public $att;
	public $nodes;
	public $node;
	public $x;
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
	function __toString() { return 'haxe.xml.Fast'; }
}
function haxe_xml_Fast_0(&$it) {
	{
		$x = $it->next();
		if($x === null) {
			return null;
		}
		return new haxe_xml_Fast($x);
	}
}
