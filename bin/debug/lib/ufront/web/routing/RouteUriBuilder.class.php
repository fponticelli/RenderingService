<?php

class ufront_web_routing_RouteUriBuilder {
	public function __construct($ast) {
		if(!php_Boot::$skip_constructor) {
		$this->ast = $ast;
	}}
	public function buildSegment($segment, $params) {
		$result = "";
		{
			$_g = 0; $_g1 = $segment->parts;
			while($_g < $_g1->length) {
				$part = $_g1[$_g];
				++$_g;
				$__hx__t = ($part);
				switch($__hx__t->index) {
				case 0:
				$value = $__hx__t->params[0];
				{
					$result .= _hx_string_or_null($value);
				}break;
				case 1:
				$name = $__hx__t->params[0];
				{
					if(!$params->exists($name)) {
						return null;
					}
					$result .= _hx_string_or_null(ufront_web_routing_RouteUriBuilder_0($this, $_g, $_g1, $name, $params, $part, $result, $segment));
				}break;
				case 6:
				$name = $__hx__t->params[0];
				{
					if(!$params->exists($name)) {
						return null;
					}
					$result .= _hx_string_or_null(ufront_web_routing_RouteUriBuilder::getRestEncoded($params, $name));
				}break;
				case 2:
				$name = $__hx__t->params[0];
				{
					if($params->exists($name)) {
						$result .= _hx_string_or_null(ufront_web_routing_RouteUriBuilder_1($this, $_g, $_g1, $name, $params, $part, $result, $segment));
					}
				}break;
				case 7:
				$name = $__hx__t->params[0];
				{
					if($params->exists($name)) {
						$result .= _hx_string_or_null(ufront_web_routing_RouteUriBuilder::getRestEncoded($params, $name));
					}
				}break;
				case 3:
				$left = $__hx__t->params[1]; $name = $__hx__t->params[0];
				{
					if($params->exists($name)) {
						$result .= _hx_string_or_null($left) . _hx_string_or_null(ufront_web_routing_RouteUriBuilder_2($this, $_g, $_g1, $left, $name, $params, $part, $result, $segment));
					}
				}break;
				case 8:
				$left = $__hx__t->params[1]; $name = $__hx__t->params[0];
				{
					if($params->exists($name)) {
						$result .= _hx_string_or_null($left) . _hx_string_or_null(ufront_web_routing_RouteUriBuilder::getRestEncoded($params, $name));
					}
				}break;
				case 4:
				$right = $__hx__t->params[1]; $name = $__hx__t->params[0];
				{
					if($params->exists($name)) {
						$result .= _hx_string_or_null(ufront_web_routing_RouteUriBuilder_3($this, $_g, $_g1, $name, $params, $part, $result, $right, $segment)) . _hx_string_or_null($right);
					}
				}break;
				case 9:
				$right = $__hx__t->params[1]; $name = $__hx__t->params[0];
				{
					if($params->exists($name)) {
						$result .= _hx_string_or_null(ufront_web_routing_RouteUriBuilder::getRestEncoded($params, $name)) . _hx_string_or_null($right);
					}
				}break;
				case 5:
				$right = $__hx__t->params[2]; $left = $__hx__t->params[1]; $name = $__hx__t->params[0];
				{
					if($params->exists($name)) {
						$result .= _hx_string_or_null($left) . _hx_string_or_null(ufront_web_routing_RouteUriBuilder_4($this, $_g, $_g1, $left, $name, $params, $part, $result, $right, $segment)) . _hx_string_or_null($right);
					}
				}break;
				case 10:
				$right = $__hx__t->params[2]; $left = $__hx__t->params[1]; $name = $__hx__t->params[0];
				{
					if($params->exists($name)) {
						$result .= _hx_string_or_null($left) . _hx_string_or_null(ufront_web_routing_RouteUriBuilder::getRestEncoded($params, $name)) . _hx_string_or_null($right);
					}
				}break;
				}
				unset($part);
			}
		}
		return $result;
	}
	public function build($params) {
		$buf = new StringBuf();
		{
			$_g = 0; $_g1 = $this->ast;
			while($_g < $_g1->length) {
				$segment = $_g1[$_g];
				++$_g;
				$s = $this->buildSegment($segment, $params);
				if(null === $s) {
					return null;
				} else {
					if("" !== $s) {
						$buf->add("/" . _hx_string_or_null($s));
					}
				}
				unset($segment,$s);
			}
		}
		$result = $buf->b;
		if("" === $result) {
			return "/";
		} else {
			return $result;
		}
	}
	public $ast;
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
	static function getEncoded($p, $k) {
		$r = rawurlencode($p->get($k));
		$p->remove($k);
		return $r;
	}
	static function getRestEncoded($p, $k) {
		$parts = _hx_explode("/", $p->get($k));
		{
			$_g1 = 0; $_g = $parts->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$parts[$i] = rawurlencode($parts[$i]);
				unset($i);
			}
		}
		$r = $parts->join("/");
		$p->remove($k);
		return $r;
	}
	function __toString() { return 'ufront.web.routing.RouteUriBuilder'; }
}
function ufront_web_routing_RouteUriBuilder_0(&$__hx__this, &$_g, &$_g1, &$name, &$params, &$part, &$result, &$segment) {
	{
		$r = rawurlencode($params->get($name));
		$params->remove($name);
		return $r;
	}
}
function ufront_web_routing_RouteUriBuilder_1(&$__hx__this, &$_g, &$_g1, &$name, &$params, &$part, &$result, &$segment) {
	{
		$r = rawurlencode($params->get($name));
		$params->remove($name);
		return $r;
	}
}
function ufront_web_routing_RouteUriBuilder_2(&$__hx__this, &$_g, &$_g1, &$left, &$name, &$params, &$part, &$result, &$segment) {
	{
		$r = rawurlencode($params->get($name));
		$params->remove($name);
		return $r;
	}
}
function ufront_web_routing_RouteUriBuilder_3(&$__hx__this, &$_g, &$_g1, &$name, &$params, &$part, &$result, &$right, &$segment) {
	{
		$r = rawurlencode($params->get($name));
		$params->remove($name);
		return $r;
	}
}
function ufront_web_routing_RouteUriBuilder_4(&$__hx__this, &$_g, &$_g1, &$left, &$name, &$params, &$part, &$result, &$right, &$segment) {
	{
		$r = rawurlencode($params->get($name));
		$params->remove($name);
		return $r;
	}
}
