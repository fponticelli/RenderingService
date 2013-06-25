<?php

class controller_BaseController extends ufront_web_mvc_Controller {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function normalizeFormat($f) {
		$f = strtolower($f);
		return controller_BaseController_0($this, $f);
	}
	public function output($data, $format, $templateClass) {
		$format = $this->normalizeFormat($format);
		switch($format) {
		case "html":{
			$template = Type::createInstance($templateClass, new _hx_array(array()));
			$content = _hx_anonymous(array("baseurl" => App::baseUrl(), "url" => $this->get_urlHelper(), "data" => $data, "milliToString" => (isset(thx_date_Milli::$toString) ? thx_date_Milli::$toString: array("thx_date_Milli", "toString")), "reflectField" => (isset(Reflect::$field) ? Reflect::$field: array("Reflect", "field"))));
			return new ufront_web_mvc_ContentResult(util_Erazors::apply($template, $content)->execute(), null);
		}break;
		case "json":{
			return ufront_web_mvc_JsonPResult::auto($data, $this->controllerContext->request->get_query()->get("callback"));
		}break;
		default:{
			controller_BaseController_1($this, $data, $format, $templateClass);
		}break;
		}
	}
	public function error($message, $format) {
		return $this->output(_hx_anonymous(array("error" => $message)), $format, _hx_qtype("template.Error"));
	}
	public function get_urlHelper() {
		if(null === $this->urlHelper) {
			$this->urlHelper = new ufront_web_mvc_view_UrlHelperInst($this->controllerContext->requestContext);
		}
		return $this->urlHelper;
	}
	public $urlHelper;
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
	static $__rtti = "<class path=\"controller.BaseController\" params=\"\">\x0A\x09<extends path=\"ufront.web.mvc.Controller\"/>\x0A\x09<urlHelper public=\"1\" get=\"accessor\" set=\"null\"><c path=\"ufront.web.mvc.view.UrlHelperInst\"/></urlHelper>\x0A\x09<get_urlHelper set=\"method\" line=\"14\"><f a=\"\"><c path=\"ufront.web.mvc.view.UrlHelperInst\"/></f></get_urlHelper>\x0A\x09<error set=\"method\" line=\"23\"><f a=\"message:format\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"ufront.web.mvc.ActionResult\"/>\x0A</f></error>\x0A\x09<output params=\"T\" set=\"method\" line=\"28\"><f a=\"data:format:templateClass\">\x0A\x09<c path=\"output.T\"/>\x0A\x09<c path=\"String\"/>\x0A\x09<x path=\"Class\"><d/></x>\x0A\x09<c path=\"ufront.web.mvc.ActionResult\"/>\x0A</f></output>\x0A\x09<normalizeFormat set=\"method\" line=\"49\"><f a=\"f\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A</f></normalizeFormat>\x0A\x09<new public=\"1\" set=\"method\" line=\"11\"><f a=\"\"><x path=\"Void\"/></f></new>\x0A</class>";
	static $__properties__ = array("get_urlHelper" => "get_urlHelper","set_invoker" => "set_invoker","get_invoker" => "get_invoker","set_valueProvider" => "set_valueProvider","get_valueProvider" => "get_valueProvider");
	function __toString() { return 'controller.BaseController'; }
}
function controller_BaseController_0(&$__hx__this, &$f) {
	switch($f) {
	case "html":case "json":{
		return $f;
	}break;
	default:{
		return "html";
	}break;
	}
}
function controller_BaseController_1(&$__hx__this, &$data, &$format, &$templateClass) {
	throw new HException(new thx_error_Error("invalid format '{0}'", new _hx_array(array($format)), null, _hx_anonymous(array("fileName" => "BaseController.hx", "lineNumber" => 45, "className" => "controller.BaseController", "methodName" => "output"))));
}
