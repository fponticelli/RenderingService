<?php

class ufront_web_HttpApplication {
	public function __construct($httpContext = null) {
		if(!php_Boot::$skip_constructor) {
		$this->httpContext = (($httpContext === null) ? ufront_web_HttpContext::createWebContext(null, null, null) : $httpContext);
		$this->onBeginRequest = new hxevents_AsyncDispatcher();
		$this->onResolveRequestCache = new hxevents_AsyncDispatcher();
		$this->onPostResolveRequestCache = new hxevents_AsyncDispatcher();
		$this->onMapRequestHandler = new hxevents_AsyncDispatcher();
		$this->onPostMapRequestHandler = new hxevents_AsyncDispatcher();
		$this->onAcquireRequestState = new hxevents_AsyncDispatcher();
		$this->onPostAcquireRequestState = new hxevents_AsyncDispatcher();
		$this->onPreRequestHandlerExecute = new hxevents_AsyncDispatcher();
		$this->onPostRequestHandlerExecute = new hxevents_AsyncDispatcher();
		$this->onReleaseRequestState = new hxevents_AsyncDispatcher();
		$this->onPostReleaseRequestState = new hxevents_AsyncDispatcher();
		$this->onUpdateRequestCache = new hxevents_AsyncDispatcher();
		$this->onPostUpdateRequestCache = new hxevents_AsyncDispatcher();
		$this->onLogRequest = new hxevents_AsyncDispatcher();
		$this->onLogRequest->add((isset($this->_executingLogRequest) ? $this->_executingLogRequest: array($this, "_executingLogRequest")));
		$this->onPostLogRequest = new hxevents_AsyncDispatcher();
		$this->onEndRequest = new hxevents_Dispatcher();
		$this->onApplicationError = new hxevents_AsyncDispatcher();
		$this->modules = new HList();
		$this->_completed = false;
	}}
	public function get_session() {
		return $this->httpContext->get_session();
	}
	public function get_response() {
		return $this->httpContext->get_response();
	}
	public function get_request() {
		return $this->httpContext->get_request();
	}
	public function completeRequest() {
		$this->_completed = true;
	}
	public function _dispose() {
		if(null == $this->modules) throw new HException('null iterable');
		$__hx__it = $this->modules->iterator();
		while($__hx__it->hasNext()) {
			$module = $__hx__it->next();
			$module->dispose();
		}
		$this->httpContext->dispose();
	}
	public function _dispatchError($e) {
		if(!$this->_logDispatched) {
			$this->_dispatchChain(new _hx_array(array($this->onLogRequest, $this->onPostLogRequest)), ufront_web_HttpApplication_0($this, $e));
			return;
		}
		$event = _hx_anonymous(array("application" => $this, "error" => ((Std::is($e, _hx_qtype("thx.error.Error"))) ? $e : new thx_error_Error(Std::string($e), null, null, _hx_anonymous(array("fileName" => "HttpApplication.hx", "lineNumber" => 298, "className" => "ufront.web.HttpApplication", "methodName" => "_dispatchError"))))));
		if(!$this->onApplicationError->has(null)) {
			throw new HException($event->error);
		} else {
			$this->onApplicationError->dispatch($event, null, null);
		}
		$this->_conclude();
	}
	public function _dispatchChain($dispatchers, $afterEffect) {
		{
			$_g = 0;
			while($_g < $dispatchers->length) {
				$dispatcher = $dispatchers[$_g];
				++$_g;
				if($this->_completed) {
					break;
				}
				$dispatcher->dispatch($this, null, (isset($this->_dispatchError) ? $this->_dispatchError: array($this, "_dispatchError")));
				unset($dispatcher);
			}
		}
		if(null !== $afterEffect) {
			call_user_func($afterEffect);
		}
	}
	public function _dispatchEnd() {
		try {
			$this->onEndRequest->dispatch($this);
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				$this->_dispatchError($e);
			}
		}
	}
	public function _initModule($module) {
		try {
			$module->init($this);
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				$this->_dispatchError($e);
			}
		}
	}
	public function _flush() {
		try {
			if(!$this->_flushed) {
				$this->_flushed = true;
				$this->get_response()->flush();
			}
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				$this->_dispatchError($e);
			}
		}
	}
	public function _conclude() {
		$this->_flush();
		$this->_dispatchEnd();
		$this->_dispose();
	}
	public function execute() {
		$this->_flushed = $this->_logDispatched = false;
		if(null == $this->modules) throw new HException('null iterable');
		$__hx__it = $this->modules->iterator();
		while($__hx__it->hasNext()) {
			$module = $__hx__it->next();
			$this->_initModule($module);
		}
		$this->_dispatchChain(new _hx_array(array($this->onBeginRequest, $this->onResolveRequestCache, $this->onPostResolveRequestCache, $this->onMapRequestHandler, $this->onPostMapRequestHandler, $this->onAcquireRequestState, $this->onPostAcquireRequestState, $this->onPreRequestHandlerExecute, $this->onPostRequestHandlerExecute, $this->onReleaseRequestState, $this->onPostReleaseRequestState, $this->onUpdateRequestCache, $this->onPostUpdateRequestCache, $this->onLogRequest, $this->onPostLogRequest)), (isset($this->_conclude) ? $this->_conclude: array($this, "_conclude")));
	}
	public function _executingLogRequest($_) {
		$this->_logDispatched = true;
	}
	public $_flushed;
	public $_logDispatched;
	public $onApplicationError;
	public $onEndRequest;
	public $onPostLogRequest;
	public $onLogRequest;
	public $onPostUpdateRequestCache;
	public $onUpdateRequestCache;
	public $onPostReleaseRequestState;
	public $onReleaseRequestState;
	public $onPostRequestHandlerExecute;
	public $onPreRequestHandlerExecute;
	public $onPostAcquireRequestState;
	public $onAcquireRequestState;
	public $onPostMapRequestHandler;
	public $onMapRequestHandler;
	public $onPostResolveRequestCache;
	public $onResolveRequestCache;
	public $onBeginRequest;
	public $_completed;
	public $_handler;
	public $modules;
	public $session;
	public $response;
	public $request;
	public $httpContext;
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
	static $__properties__ = array("get_request" => "get_request","get_response" => "get_response","get_session" => "get_session");
	function __toString() { return 'ufront.web.HttpApplication'; }
}
function ufront_web_HttpApplication_0(&$__hx__this, &$e) {
	{
		$f = (isset($__hx__this->_dispatchError) ? $__hx__this->_dispatchError: array($__hx__this, "_dispatchError")); $e1 = $e;
		return array(new _hx_lambda(array(&$e, &$e1, &$f), "ufront_web_HttpApplication_1"), 'execute');
	}
}
function ufront_web_HttpApplication_1(&$e, &$e1, &$f) {
	{
		call_user_func_array($f, array($e1));
		return;
	}
}
