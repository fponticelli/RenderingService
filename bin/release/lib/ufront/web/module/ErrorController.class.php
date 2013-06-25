<?php

class ufront_web_module_ErrorController extends ufront_web_mvc_Controller {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function unprocessableEntityErrory($error) {
		return $this->_errorView($error, null);
	}
	public function methodNotAllowedError($error) {
		return $this->_errorView($error, null);
	}
	public function pageNotFoundError($error) {
		return $this->_errorView($error, null);
	}
	public function unauthorizedError($error) {
		return $this->_errorView($error, null);
	}
	public function badRequestError($error) {
		return $this->_errorView($error, null);
	}
	public function internalServerError($error) {
		return $this->_errorView($error, true);
	}
	public function _errorStack() {
		$arr = new _hx_array(array());
		$stack = haxe_CallStack::exceptionStack();
		$stack->pop();
		$stack = $stack->slice(2, null);
		{
			$_g = 0;
			while($_g < $stack->length) {
				$item = $stack[$_g];
				++$_g;
				$arr->push(ufront_web_module_ErrorController::_stackItemToString($item));
				unset($item);
			}
		}
		return $arr;
	}
	public function _errorView($error, $showStack = null) {
		if($showStack === null) {
			$showStack = false;
		}
		$this->controllerContext->httpContext->get_response()->status = $error->code;
		$inner = ufront_web_module_ErrorController_0($this, $error, $showStack);
		$items = $this->_errorStack();
		$stack = ufront_web_module_ErrorController_1($this, $error, $inner, $items, $showStack);
		return "<!doctype html>\x0A<html>\x0A<head>\x0A<title>" . _hx_string_or_null($error->toString()) . "</title>\x0A<style>\x0Abody { text-align: center;}\x0Ah1 { font-size: 50px; }\x0Abody { font: 20px Constantia, \"Hoefler Text\",  \"Adobe Caslon Pro\", Baskerville, Georgia, Times, serif; color: #999; text-shadow: 2px 2px 2px rgba(200, 200, 200, 0.5)}\x0Aa { color: rgb(36, 109, 56); text-decoration:none; }\x0Aa:hover { color: rgb(96, 73, 141) ; text-shadow: 2px 2px 2px rgba(36, 109, 56, 0.5) }\x0Aspan[frown] { transform: rotate(90deg); display:inline-block; color: #bbb; }\x0A</style>\x0A</head>\x0A<bofy>\x0A<details>\x0A  <summary><h1>" . _hx_string_or_null($error->toString()) . "</h1></summary>  \x0A  " . _hx_string_or_null($inner) . _hx_string_or_null($stack) . " \x0A  <p><span frown>:(</p>\x0A</details>\x0A</body>\x0A</html>";
	}
	static $__rtti = "<class path=\"ufront.web.module.ErrorController\" params=\"\">\x0A\x09<extends path=\"ufront.web.mvc.Controller\"/>\x0A\x09<_stackItemToString set=\"method\" line=\"57\" static=\"1\"><f a=\"s\">\x0A\x09<e path=\"haxe.StackItem\"/>\x0A\x09<c path=\"String\"/>\x0A</f></_stackItemToString>\x0A\x09<_errorView set=\"method\" line=\"16\"><f a=\"error:?showStack\">\x0A\x09<c path=\"ufront.web.error.HttpError\"/>\x0A\x09<x path=\"Bool\"/>\x0A\x09<c path=\"String\"/>\x0A</f></_errorView>\x0A\x09<_errorStack set=\"method\" line=\"79\"><f a=\"\"><c path=\"Array\"><c path=\"String\"/></c></f></_errorStack>\x0A\x09<internalServerError public=\"1\" set=\"method\" line=\"94\"><f a=\"error\">\x0A\x09<c path=\"ufront.web.error.HttpError\"/>\x0A\x09<c path=\"String\"/>\x0A</f></internalServerError>\x0A\x09<badRequestError public=\"1\" set=\"method\" line=\"99\"><f a=\"error\">\x0A\x09<c path=\"ufront.web.error.HttpError\"/>\x0A\x09<c path=\"String\"/>\x0A</f></badRequestError>\x0A\x09<unauthorizedError public=\"1\" set=\"method\" line=\"104\"><f a=\"error\">\x0A\x09<c path=\"ufront.web.error.HttpError\"/>\x0A\x09<c path=\"String\"/>\x0A</f></unauthorizedError>\x0A\x09<pageNotFoundError public=\"1\" set=\"method\" line=\"109\"><f a=\"error\">\x0A\x09<c path=\"ufront.web.error.HttpError\"/>\x0A\x09<c path=\"String\"/>\x0A</f></pageNotFoundError>\x0A\x09<methodNotAllowedError public=\"1\" set=\"method\" line=\"114\"><f a=\"error\">\x0A\x09<c path=\"ufront.web.error.HttpError\"/>\x0A\x09<c path=\"String\"/>\x0A</f></methodNotAllowedError>\x0A\x09<unprocessableEntityErrory public=\"1\" set=\"method\" line=\"119\"><f a=\"error\">\x0A\x09<c path=\"ufront.web.error.HttpError\"/>\x0A\x09<c path=\"String\"/>\x0A</f></unprocessableEntityErrory>\x0A\x09<new public=\"1\" set=\"method\" line=\"11\"><f a=\"\"><x path=\"Void\"/></f></new>\x0A</class>";
	static function _stackItemToString($s) {
		$__hx__t = ($s);
		switch($__hx__t->index) {
		case 0:
		{
			return "a C function";
		}break;
		case 1:
		$m = $__hx__t->params[0];
		{
			return "module " . _hx_string_or_null($m);
		}break;
		case 2:
		$line = $__hx__t->params[2]; $file = $__hx__t->params[1]; $s1 = $__hx__t->params[0];
		{
			$r = "";
			if($s1 !== null) {
				$r .= _hx_string_or_null(ufront_web_module_ErrorController::_stackItemToString($s1)) . " (";
			}
			$r .= _hx_string_or_null($file) . " line " . _hx_string_rec($line, "");
			if($s1 !== null) {
				$r .= ")";
			}
			return $r;
		}break;
		case 3:
		$meth = $__hx__t->params[1]; $cname = $__hx__t->params[0];
		{
			return _hx_string_or_null($cname) . "." . _hx_string_or_null($meth);
		}break;
		case 4:
		$n = $__hx__t->params[0];
		{
			return "local function #" . _hx_string_rec($n, "");
		}break;
		}
	}
	static $__properties__ = array("set_invoker" => "set_invoker","get_invoker" => "get_invoker","set_valueProvider" => "set_valueProvider","get_valueProvider" => "get_valueProvider");
	function __toString() { return 'ufront.web.module.ErrorController'; }
}
function ufront_web_module_ErrorController_0(&$__hx__this, &$error, &$showStack) {
	if(null !== $error->inner) {
		return "<p>" . _hx_string_or_null($error->inner->toString()) . "<p>";
	} else {
		return "";
	}
}
function ufront_web_module_ErrorController_1(&$__hx__this, &$error, &$inner, &$items, &$showStack) {
	if($showStack && $items->length > 0) {
		return "<div><p><i>error stack:</i></p>\x0A<ul><li>" . _hx_string_or_null($items->join("</li><li>")) . "</li></ul></div>";
	} else {
		return "";
	}
}
