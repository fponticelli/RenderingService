<?php

class template_RenderableDisplay extends erazor_macro_Template {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function execute() {
		$__b__ = new StringBuf();
		{
			$__b__->add("<!DOCTYPE html>\x0A<html>\x0A<head>\x0A  <title>Visualization Info</title>\x0A  <link rel=\"stylesheet\" type=\"text/css\" href=\"");
			$__b__->add($this->baseurl);
			$__b__->add($this->url->base("css/style.css"));
			$__b__->add("\">\x0A</head>\x0A<body>\x0A<h1>Visualization Info</h1>\x0A<h2>General</h2>\x0A<dl>\x0A  <dt>uid:</dt>\x0A  <dd>");
			$__b__->add($this->data->uid);
			$__b__->add("</dd>\x0A  <dt>created on:</dt>\x0A  <dd>");
			$__b__->add($this->data->createdOn);
			$__b__->add("</dd>\x0A</dl>\x0A<h2>Duration</h2>\x0A<dl>\x0A  <dt>will be erased on:</dt>\x0A");
			if(null === $this->data->expiresOn) {
				$__b__->add("\x0A  <dd>will be erased after not being used for ");
				$__b__->add($this->milliToString($this->data->preserveTimeAfterLastUsage, false));
				$__b__->add("</dd>\x0A");
				null;
			} else {
				$__b__->add("\x0A  <dd>");
				$__b__->add($this->data->expiresOn->toString());
				$__b__->add("</dd>\x0A");
				null;
			}
			$__b__->add("\x0A</dl>\x0A<h2>Cache</h2>\x0A<dl>\x0A  <dt>cache expires after:</dt>\x0A  <dd>");
			$__b__->add($this->milliToString($this->data->cacheExpirationTime, false));
			$__b__->add("</dd>\x0A</dl>\x0A<h2>Download</h2>\x0A<dl class=\"bullet\">\x0A");
			{
				$_g = 0; $_g1 = $this->data->formats;
				while($_g < $_g1->length) {
					$format = $_g1[$_g];
					++$_g;
					$__b__->add("\x0A");
					$p = $this->reflectField($this->data->service, $format);
					$__b__->add("\x0A  <dt>");
					$__b__->add(strtoupper($format));
					$__b__->add(":</dt>\x0A  <dd><a href=\"");
					$__b__->add($p);
					$__b__->add("\">");
					$__b__->add($p);
					$__b__->add("</a></dd>\x0A");
					null;
					unset($p,$format);
				}
			}
			$__b__->add("\x0A</dl>\x0A</body>\x0A</html>");
		}
		return $__b__->b;
	}
	public $reflectField;
	public $milliToString;
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
	function __toString() { return 'template.RenderableDisplay'; }
}
