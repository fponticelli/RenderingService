<?php

class controller_Site extends ufront_web_mvc_Controller {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function contact($message = null) {
		return controller_Site_0($this, $message);
	}
	static $__rtti = "<class path=\"controller.Site\" params=\"\">\x0A\x09<extends path=\"ufront.web.mvc.Controller\"/>\x0A\x09<contact public=\"1\" set=\"method\" line=\"17\"><f a=\"?message\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A</f></contact>\x0A\x09<new public=\"1\" set=\"method\" line=\"12\"><f a=\"\"><x path=\"Void\"/></f></new>\x0A</class>";
	static $__properties__ = array("set_invoker" => "set_invoker","get_invoker" => "get_invoker","set_valueProvider" => "set_valueProvider","get_valueProvider" => "get_valueProvider");
	function __toString() { return 'controller.Site'; }
}
function controller_Site_0(&$__hx__this, &$message) {
	if(null === $message) {
		return "NO MESSAGE";
	} else {
		return "MESSAGE IS: " . _hx_string_or_null($message);
	}
}
