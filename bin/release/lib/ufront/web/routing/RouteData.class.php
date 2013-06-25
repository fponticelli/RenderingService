<?php

class ufront_web_routing_RouteData {
	public function __construct($route, $routeHandler, $data) {
		if(!php_Boot::$skip_constructor) {
		$this->route = $route;
		$this->routeHandler = $routeHandler;
		$this->data = $data;
	}}
	public function get($key, $alt = null) {
		$v = $this->data->get($key);
		if(null === $v) {
			$v = $alt;
		}
		return $v;
	}
	public function getRequired($key) {
		if($this->data->exists($key)) {
			return $this->data->get($key);
		} else {
			throw new HException(new thx_error_Error("required parameter '{0} is missing'", null, $key, _hx_anonymous(array("fileName" => "RouteData.hx", "lineNumber" => 20, "className" => "ufront.web.routing.RouteData", "methodName" => "getRequired"))));
		}
	}
	public $data;
	public $routeHandler;
	public $route;
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
	function __toString() { return 'ufront.web.routing.RouteData'; }
}
