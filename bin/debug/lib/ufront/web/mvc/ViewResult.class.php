<?php

class ufront_web_mvc_ViewResult extends ufront_web_mvc_ActionResult {
	public function __construct($data = null, $dataObj = null) {
		if(!php_Boot::$skip_constructor) {
		if(null === $data) {
			$this->viewData = new haxe_ds_StringMap();
		} else {
			$this->viewData = $data;
		}
		if(null !== $dataObj) {
			thx_core_Hashes::importObject($this->viewData, $dataObj);
		}
	}}
	public function findView($context, $viewName) {
		if(null === $viewName) {
			throw new HException(new thx_error_NullArgument("viewName", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "ViewResult.hx", "lineNumber" => 63, "className" => "ufront.web.mvc.ViewResult", "methodName" => "findView"))));
		}
		if(null == ufront_web_mvc_ViewEngines::get_engines()) throw new HException('null iterable');
		$__hx__it = ufront_web_mvc_ViewEngines::get_engines()->iterator();
		while($__hx__it->hasNext()) {
			$engine = $__hx__it->next();
			$result = $engine->findView($context, $viewName);
			if(null !== $result) {
				return $result;
			}
			unset($result);
		}
		return null;
	}
	public function writeResponse($context, $content, $data) {
		$context->response->write($content);
	}
	public function executeResult($context) {
		if(null === $context) {
			throw new HException(new thx_error_NullArgument("context", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "ViewResult.hx", "lineNumber" => 31, "className" => "ufront.web.mvc.ViewResult", "methodName" => "executeResult"))));
		}
		if(null === $this->viewName || "" === $this->viewName) {
			$this->viewName = $context->routeData->getRequired("action");
		}
		$result = null;
		if(null === $this->view) {
			$result = $this->findView($context, $this->viewName);
			if(null === $result) {
				throw new HException(new thx_error_Error("unable to find a view for '{0}'", null, _hx_string_or_null(thx_core_Types::typeName($context->controller)) . "/" . _hx_string_or_null($this->viewName), _hx_anonymous(array("fileName" => "ViewResult.hx", "lineNumber" => 40, "className" => "ufront.web.mvc.ViewResult", "methodName" => "executeResult"))));
			}
			$this->view = $result->view;
		}
		$viewContext = $this->createContext($result, $context);
		$data = new haxe_ds_StringMap();
		$r = null;
		try {
			$r = $this->view->render($viewContext, $data);
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				throw new HException(new thx_error_Error("error in the template processing: {0}", null, Std::string($e), _hx_anonymous(array("fileName" => "ViewResult.hx", "lineNumber" => 49, "className" => "ufront.web.mvc.ViewResult", "methodName" => "executeResult"))));
			}
		}
		$this->writeResponse($context, $r, $data);
		if(null !== $result) {
			$result->viewEngine->releaseView($context, $this->view);
		}
	}
	public function createContext($result, $controllerContext) {
		return new ufront_web_mvc_ViewContext($controllerContext, $this->view, $result->viewEngine, $this->viewData, $controllerContext->controller->getViewHelpers());
	}
	public $viewName;
	public $viewData;
	public $view;
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
	function __toString() { return 'ufront.web.mvc.ViewResult'; }
}
