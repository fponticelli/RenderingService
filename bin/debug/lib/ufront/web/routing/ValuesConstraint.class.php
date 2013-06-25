<?php

class ufront_web_routing_ValuesConstraint implements ufront_web_routing_IRouteConstraint{
	public function __construct($parametername, $values, $caseInsesitive = null, $validatedefault = null) {
		if(!php_Boot::$skip_constructor) {
		if($validatedefault === null) {
			$validatedefault = false;
		}
		if($caseInsesitive === null) {
			$caseInsesitive = false;
		}
		if(null === $parametername) {
			throw new HException(new thx_error_NullArgument("parametername", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "ValuesConstraint.hx", "lineNumber" => 20, "className" => "ufront.web.routing.ValuesConstraint", "methodName" => "new"))));
		}
		if(null === $values) {
			throw new HException(new thx_error_NullArgument("values", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "ValuesConstraint.hx", "lineNumber" => 21, "className" => "ufront.web.routing.ValuesConstraint", "methodName" => "new"))));
		}
		$this->parameterName = $parametername;
		if($caseInsesitive) {
			$this->values = $values->map(array(new _hx_lambda(array(&$caseInsesitive, &$parametername, &$validatedefault, &$values), "ufront_web_routing_ValuesConstraint_0"), 'execute'));
		} else {
			$this->values = $values;
		}
		$this->caseInsesitive = $caseInsesitive;
		$this->validateDefault = $validatedefault;
	}}
	public function match($context, $route, $params, $direction) {
		$value = $params->get($this->parameterName);
		if(null === $value && $this->validateDefault) {
			$value = $route->defaults->get($this->parameterName);
		}
		if(null === $value) {
			return true;
		}
		return thx_core_Arrays::exists($this->values, strtolower($value), null);
	}
	public $caseInsesitive;
	public $validateDefault;
	public $values;
	public $parameterName;
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
	function __toString() { return 'ufront.web.routing.ValuesConstraint'; }
}
function ufront_web_routing_ValuesConstraint_0(&$caseInsesitive, &$parametername, &$validatedefault, &$values, $d) {
	{
		return strtolower($d);
	}
}
