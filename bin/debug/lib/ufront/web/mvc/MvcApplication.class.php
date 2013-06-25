<?php

class ufront_web_mvc_MvcApplication extends ufront_web_HttpApplication {
	public function __construct($configuration = null, $routes = null, $httpContext = null) {
		if(!php_Boot::$skip_constructor) {
		$_g = $this;
		if($configuration === null) {
			$configuration = new ufront_web_AppConfiguration(null, null, null, null, null);
		}
		if($httpContext === null) {
			$httpContext = ufront_web_HttpContext::createWebContext(null, null, null);
			$path = trim($configuration->basePath, "/");
			if(strlen($path) > 0) {
				$httpContext->addUrlFilter(new ufront_web_DirectoryUrlFilter($path));
			}
			if($configuration->modRewrite !== true) {
				$httpContext->addUrlFilter(new ufront_web_PathInfoUrlFilter(null, null));
			}
		}
		parent::__construct($httpContext);
		$this->modules->add($this->routeModule = new ufront_web_routing_UrlRoutingModule((($routes === null) ? new ufront_web_routing_RouteCollection(ufront_web_mvc_MvcApplication::$defaultRoutes) : $routes)));
		{
			$_g1 = 0; $_g11 = $configuration->controllerPackages;
			while($_g1 < $_g11->length) {
				$pack = $_g11[$_g1];
				++$_g1;
				ufront_web_mvc_ControllerBuilder::$current->packages->add($pack);
				unset($pack);
			}
		}
		{
			$_g1 = 0; $_g11 = $configuration->attributePackages;
			while($_g1 < $_g11->length) {
				$pack = $_g11[$_g1];
				++$_g1;
				ufront_web_mvc_ControllerBuilder::$current->packages->add($pack);
				unset($pack);
			}
		}
		$this->modules->add(new ufront_web_module_ErrorModule());
		if(!$configuration->disableBrowserTrace) {
			$this->modules->add(new ufront_web_module_TraceToBrowserModule());
		}
		if(null !== $configuration->logFile) {
			$this->modules->add(new ufront_web_module_TraceToFileModule($configuration->logFile));
		}
		$old = haxe_Log::$trace;
		haxe_Log::$trace = array(new _hx_lambda(array(&$_g, &$configuration, &$httpContext, &$old, &$routes), "ufront_web_mvc_MvcApplication_0"), 'execute');
	}}
	public $routeModule;
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
	static $defaultRoutes;
	static $__properties__ = array("get_request" => "get_request","get_response" => "get_response","get_session" => "get_session");
	function __toString() { return 'ufront.web.mvc.MvcApplication'; }
}
ufront_web_mvc_MvcApplication::$defaultRoutes = new _hx_array(array(new ufront_web_routing_Route("/", new ufront_web_mvc_MvcRouteHandler(), thx_core_DynamicsT::toMap(_hx_anonymous(array("controller" => "home", "action" => "index"))), null), new ufront_web_routing_Route("/{controller}/{action}/{?id}", new ufront_web_mvc_MvcRouteHandler(), null, null)));
function ufront_web_mvc_MvcApplication_0(&$_g, &$configuration, &$httpContext, &$old, &$routes, $msg, $pos) {
	{
		$found = false;
		if(null == $_g->modules) throw new HException('null iterable');
		$__hx__it = $_g->modules->iterator();
		while($__hx__it->hasNext()) {
			$module = $__hx__it->next();
			$tracer = thx_core_Types::has($module, _hx_qtype("ufront.web.module.ITraceModule"));
			if(null !== $tracer) {
				$found = true;
				$tracer->trace($msg, $pos);
			}
			unset($tracer);
		}
		if(!$found) {
			call_user_func_array($old, array($msg, $pos));
		}
	}
}
