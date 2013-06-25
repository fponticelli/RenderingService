<?php

class ufront_web_mvc_MvcHandler implements ufront_web_IHttpHandler{
	public function __construct($requestContext) {
		if(!php_Boot::$skip_constructor) {
		if(null === $requestContext) {
			throw new HException(new thx_error_NullArgument("requestContext", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "MvcHandler.hx", "lineNumber" => 15, "className" => "ufront.web.mvc.MvcHandler", "methodName" => "new"))));
		}
		$this->requestContext = $requestContext;
	}}
	public function set_controllerBuilder($v) {
		return $this->controllerBuilder = $v;
	}
	public function get_controllerBuilder() {
		if(null === $this->controllerBuilder) {
			return ufront_web_mvc_ControllerBuilder::$current;
		} else {
			return $this->controllerBuilder;
		}
	}
	public function processRequest($httpContext, $async) {
		$controllerName = $this->requestContext->routeData->getRequired("controller");
		$factory = $this->get_controllerBuilder()->get_controllerFactory();
		$controller = $factory->createController($this->requestContext, $controllerName);
		if(null === $controller) {
			throw new HException(new ufront_web_error_BadRequestError(_hx_anonymous(array("fileName" => "MvcHandler.hx", "lineNumber" => 25, "className" => "ufront.web.mvc.MvcHandler", "methodName" => "processRequest"))));
		}
		try {
			$controller->execute($this->requestContext, $async);
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				$factory->releaseController($controller);
				$async->error($e);
			}
		}
		$factory->releaseController($controller);
	}
	public $controllerBuilder;
	public $requestContext;
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
	static $__properties__ = array("set_controllerBuilder" => "set_controllerBuilder","get_controllerBuilder" => "get_controllerBuilder");
	function __toString() { return 'ufront.web.mvc.MvcHandler'; }
}
