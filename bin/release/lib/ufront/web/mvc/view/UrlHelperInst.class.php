<?php

class ufront_web_mvc_view_UrlHelperInst {
	public function __construct($requestContext) {
		if(!php_Boot::$skip_constructor) {
		$this->__req = $requestContext;
	}}
	public function route($data = null) {
		$hash = null;
		if(null === $data) {
			$hash = new haxe_ds_StringMap();
		} else {
			if(Std::is($data, _hx_qtype("haxe.ds.StringMap"))) {
				$hash = thx_core_Hashes::hclone($data);
			} else {
				$hash = thx_core_DynamicsT::toMap($data);
			}
		}
		if(null === $hash->get("controller")) {
			$route = thx_core_Types::has($this->__req->routeData->route, _hx_qtype("ufront.web.routing.Route"));
			if(null === $route) {
				throw new HException(new thx_error_Error("unable to find a controller for {0}", null, Std::string($hash), _hx_anonymous(array("fileName" => "UrlHelper.hx", "lineNumber" => 79, "className" => "ufront.web.mvc.view.UrlHelperInst", "methodName" => "route"))));
			}
			$hash->set("controller", $route->defaults->get("controller"));
			if(null === $hash->get("controller")) {
				throw new HException(new thx_error_Error("the routed data doesn't include the 'controller' parameter", null, null, _hx_anonymous(array("fileName" => "UrlHelper.hx", "lineNumber" => 82, "className" => "ufront.web.mvc.view.UrlHelperInst", "methodName" => "route"))));
			}
		}
		if(null == $this->__req->routeData->route->routes) throw new HException('null iterable');
		$__hx__it = $this->__req->routeData->route->routes->iterator();
		while($__hx__it->hasNext()) {
			$route = $__hx__it->next();
			$url = $route->getPath($this->__req->httpContext, thx_core_Hashes::hclone($hash));
			if(null !== $url) {
				return $url;
			}
			unset($url);
		}
		throw new HException(new thx_error_Error("unable to find a suitable route for {0}", null, Std::string($hash), _hx_anonymous(array("fileName" => "UrlHelper.hx", "lineNumber" => 91, "className" => "ufront.web.mvc.view.UrlHelperInst", "methodName" => "route"))));
	}
	public function encode($s) {
		return rawurlencode($s);
	}
	public function current($params = null) {
		$url = $this->__req->httpContext->getRequestUri();
		if(null !== $params) {
			$qs = new _hx_array(array());
			{
				$_g = 0; $_g1 = Reflect::fields($params);
				while($_g < $_g1->length) {
					$field = $_g1[$_g];
					++$_g;
					$value = Reflect::field($params, $field);
					$qs->push(_hx_string_or_null($field) . "=" . _hx_string_or_null($this->encode($value)));
					unset($value,$field);
				}
			}
			if($qs->length > 0) {
				$url .= _hx_string_or_null((((_hx_index_of($url, "?", null) >= 0) ? "&" : "?"))) . _hx_string_or_null($qs->join("&"));
			}
		}
		return $this->__req->httpContext->generateUri($url);
	}
	public function base($uri = null) {
		if(null === $uri) {
			$uri = "/";
		}
		return $this->__req->httpContext->generateUri($uri);
	}
	public $__req;
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
	function __toString() { return 'ufront.web.mvc.view.UrlHelperInst'; }
}
