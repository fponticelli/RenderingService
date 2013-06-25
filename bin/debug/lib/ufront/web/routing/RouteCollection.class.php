<?php

class ufront_web_routing_RouteCollection {
	public function __construct($routes = null) {
		if(!php_Boot::$skip_constructor) {
		$this->_routes = new _hx_array(array());
		if(null !== $routes) {
			if(null == $routes) throw new HException('null iterable');
			$__hx__it = $routes->iterator();
			while($__hx__it->hasNext()) {
				$route = $__hx__it->next();
				$this->add($route);
			}
		}
	}}
	public function iterator() {
		return $this->_routes->iterator();
	}
	public function addRoute($uri, $defaults = null, $constraint = null, $constraints = null) {
		if(null !== $constraint) {
			$constraints = new _hx_array(array($constraint));
		}
		return $this->add(new ufront_web_routing_Route($uri, new ufront_web_mvc_MvcRouteHandler(), ((null === $defaults) ? null : thx_core_DynamicsT::toMap($defaults)), $constraints));
	}
	public function add($route) {
		$this->_routes->push($route);
		$r = $route;
		$r->setRoutes($this);
		return $this;
	}
	public $_routes;
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
	function __toString() { return 'ufront.web.routing.RouteCollection'; }
}
