<?php

class template_Logs extends erazor_macro_Template {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function execute() {
		$__b__ = new StringBuf();
		{
			$__b__->add("<!DOCTYPE html>\x0A<html>\x0A<head>\x0A  <title>Logs</title>\x0A  <link rel=\"stylesheet\" type=\"text/css\" href=\"");
			$__b__->add($this->baseurl);
			$__b__->add($this->url->base("css/style.css"));
			$__b__->add("\">\x0A</head>\x0A<body>\x0A<h1>Logs</h1>\x0A<ol class=\"logs\">\x0A");
			if($this->data->length === 0) {
				$__b__->add("\x0A\x09<div class=\"message\">no logs are available</div>\x0A");
				null;
			} else {
				$__b__->add("\x0A\x09");
				{
					$_g = 0; $_g1 = $this->data;
					while($_g < $_g1->length) {
						$log = $_g1[$_g];
						++$_g;
						$__b__->add("\x0A\x09  <li>\x0A\x09    <div class=\"loc\">");
						$__b__->add(Date::fromTime($log->time)->toString());
						$__b__->add(" on ");
						$__b__->add($log->server);
						$__b__->add("</div>\x0A\x09    <div class=\"info\">");
						$__b__->add(template_Logs_0($this, $__b__, $_g, $_g1, $log));
						$__b__->add($log->pos->className);
						$__b__->add(".");
						$__b__->add($log->pos->methodName);
						$__b__->add("(");
						$__b__->add($log->pos->lineNumber);
						$__b__->add(")</div>\x0A\x09    <div class=\"msg\">");
						$__b__->add(StringTools::htmlEscape($log->msg, null));
						$__b__->add("</div>\x0A\x09  </li>\x0A\x09");
						null;
						unset($log);
					}
				}
				$__b__->add("\x0A");
				null;
			}
			$__b__->add("\x0A</ol>\x0A</body>\x0A</html>");
		}
		return $__b__->b;
	}
	public $data;
	public $url;
	public $baseurl;
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
	function __toString() { return 'template.Logs'; }
}
function template_Logs_0(&$__hx__this, &$__b__, &$_g, &$_g1, &$log) {
	if(_hx_explode(".", $log->pos->fileName)->shift() === _hx_explode(".", $log->pos->className)->pop()) {
		return "";
	} else {
		return _hx_string_or_null($log->pos->fileName) . ": ";
	}
}
