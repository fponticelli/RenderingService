<?php

class ufront_web_routing_RouteBase {
	public function __construct(){}
	public function setRoutes($routes) {
		$this->routes = $routes;
	}
	public function getPath($context, $data) {
		return null;
	}
	public function getRouteData($context) {
		return null;
	}
	public $routes;
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
	function __toString() { return 'ufront.web.routing.RouteBase'; }
}
