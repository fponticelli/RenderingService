<?php

class ufront_web_mvc_FilterInfo {
	public function __construct($filters) {
		if(!php_Boot::$skip_constructor) {
		$this->authorizationFilters = new _hx_array(array());
		$this->actionFilters = new _hx_array(array());
		$this->exceptionFilters = new _hx_array(array());
		$this->resultFilters = new _hx_array(array());
		if($filters !== null) {
			$this->addFilters($filters);
		}
	}}
	public function mergeControllerFilters($controller) {
		if(Std::is($controller, _hx_qtype("ufront.web.mvc.IAuthorizationFilter"))) {
			$this->authorizationFilters->unshift($controller);
		}
		if(Std::is($controller, _hx_qtype("ufront.web.mvc.IActionFilter"))) {
			$this->actionFilters->unshift($controller);
		}
		if(Std::is($controller, _hx_qtype("ufront.web.mvc.IResultFilter"))) {
			$this->resultFilters->unshift($controller);
		}
		if(Std::is($controller, _hx_qtype("ufront.web.mvc.IExceptionFilter"))) {
			$this->exceptionFilters->unshift($controller);
		}
	}
	public function addFilter($attribute) {
		if(Std::is($attribute, _hx_qtype("ufront.web.mvc.IAuthorizationFilter"))) {
			$this->authorizationFilters->push($attribute);
		}
		if(Std::is($attribute, _hx_qtype("ufront.web.mvc.IActionFilter"))) {
			$this->actionFilters->push($attribute);
		}
		if(Std::is($attribute, _hx_qtype("ufront.web.mvc.IResultFilter"))) {
			$this->resultFilters->push($attribute);
		}
		if(Std::is($attribute, _hx_qtype("ufront.web.mvc.IExceptionFilter"))) {
			$this->exceptionFilters->push($attribute);
		}
	}
	public function addFilters($filters) {
		if(null == $filters) throw new HException('null iterable');
		$__hx__it = $filters->iterator();
		while($__hx__it->hasNext()) {
			$filter = $__hx__it->next();
			$this->addFilter($filter);
		}
	}
	public $resultFilters;
	public $exceptionFilters;
	public $actionFilters;
	public $authorizationFilters;
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
	function __toString() { return 'ufront.web.mvc.FilterInfo'; }
}
