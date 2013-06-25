<?php

class controller_HomeController extends ufront_web_mvc_Controller {
	public function __construct($config) {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
		$this->config = $config;
	}}
	public function index($auth = null) {
		return new ufront_web_mvc_ContentResult(util_Erazors::apply(new template_Home(), _hx_anonymous(array("baseurl" => App::baseUrl(), "url" => new ufront_web_mvc_view_UrlHelperInst($this->controllerContext->requestContext), "sampleuid" => $this->config->getSampleUID(), "version" => App::$version, "authorized" => App::$AUTH === $auth, "auth" => $auth)))->execute(), null);
	}
	public $config;
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
	static $__rtti = "<class path=\"controller.HomeController\" params=\"\">\x0A\x09<extends path=\"ufront.web.mvc.Controller\"/>\x0A\x09<config><c path=\"model.ConfigGateway\"/></config>\x0A\x09<index public=\"1\" set=\"method\" line=\"15\"><f a=\"?auth\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"ufront.web.mvc.ContentResult\"/>\x0A</f></index>\x0A\x09<new public=\"1\" set=\"method\" line=\"10\"><f a=\"config\">\x0A\x09<c path=\"model.ConfigGateway\"/>\x0A\x09<x path=\"Void\"/>\x0A</f></new>\x0A</class>";
	static $__properties__ = array("set_invoker" => "set_invoker","get_invoker" => "get_invoker","set_valueProvider" => "set_valueProvider","get_valueProvider" => "get_valueProvider");
	function __toString() { return 'controller.HomeController'; }
}
