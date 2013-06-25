<?php

class template_Error extends erazor_macro_Template {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function execute() {
		$__b__ = new StringBuf();
		{
			$__b__->add("<!DOCTYPE html>\x0A<html>\x0A<head>\x0A  <title>Download Error</title>\x0A  <link rel=\"stylesheet\" type=\"text/css\" href=\"");
			$__b__->add($this->baseurl);
			$__b__->add($this->url->base("css/style.css"));
			$__b__->add("\">\x0A  <style>\x0Abody {\x0A  padding: 0;\x0A  font-size: 80%;\x0A}\x0A  </style>\x0A</head>\x0A<body>\x0A<div class=\"error\">");
			$__b__->add($this->data->error);
			$__b__->add("</div>\x0A</body>\x0A</html>");
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
	function __toString() { return 'template.Error'; }
}
