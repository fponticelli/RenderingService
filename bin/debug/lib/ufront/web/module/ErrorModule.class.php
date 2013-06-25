<?php

class ufront_web_module_ErrorModule implements ufront_web_IHttpModule{
	public function __construct() { 
	}
	public function dispose() {
	}
	public function getErrorController() {
		return new ufront_web_module_ErrorController();
	}
	public function _onError($e, $async) {
		$controller = $this->getErrorController();
		$httpError = null;
		if(Std::is($e->error, _hx_qtype("ufront.web.error.HttpError"))) {
			$httpError = $e->error;
		} else {
			$httpError = new ufront_web_error_InternalServerError(_hx_anonymous(array("fileName" => "ErrorModule.hx", "lineNumber" => 38, "className" => "ufront.web.module.ErrorModule", "methodName" => "_onError")));
			$httpError->setInner($e->error);
		}
		$action = ufront_web_module_ErrorModule_0($this, $async, $controller, $e, $httpError);
		if("httpError" === $action) {
			$action = "internalServerError";
		}
		$routeData = new ufront_web_routing_RouteData(ufront_web_routing_EmptyRoute::$instance, new ufront_web_mvc_MvcRouteHandler(), thx_core_DynamicsT::toMap(_hx_anonymous(array("action" => $action, "error" => haxe_Serializer::run($httpError)))));
		$requestContext = null;
		if(null == $e->application->modules) throw new HException('null iterable');
		$__hx__it = $e->application->modules->iterator();
		while($__hx__it->hasNext()) {
			$module = $__hx__it->next();
			if(Std::is($module, _hx_qtype("ufront.web.routing.UrlRoutingModule"))) {
				$umodule = $module;
				$requestContext = new ufront_web_routing_RequestContext($e->application->httpContext, $routeData, $umodule->routeCollection);
				break;
				unset($umodule);
			}
		}
		if(null === $requestContext) {
			$requestContext = new ufront_web_routing_RequestContext($e->application->httpContext, $routeData, new ufront_web_routing_RouteCollection(null));
		}
		$controller->execute($requestContext, $async);
	}
	public function init($application) {
		$application->onApplicationError->addAsync((isset($this->_onError) ? $this->_onError: array($this, "_onError")));
	}
	function __toString() { return 'ufront.web.module.ErrorModule'; }
}
function ufront_web_module_ErrorModule_0(&$__hx__this, &$async, &$controller, &$e, &$httpError) {
	{
		$value = _hx_explode(".", Type::getClassName(Type::getClass($httpError)))->pop();
		if($value === null) {
			return null;
		} else {
			return _hx_string_or_null(strtolower(_hx_char_at($value, 0))) . _hx_string_or_null(_hx_substr($value, 1, null));
		}
		unset($value);
	}
}
