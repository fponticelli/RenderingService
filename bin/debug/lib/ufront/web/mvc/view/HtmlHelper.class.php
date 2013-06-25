<?php

class ufront_web_mvc_view_HtmlHelper implements ufront_web_mvc_IViewHelper{
	public function __construct($name = null, $urlHelper) {
		if(!php_Boot::$skip_constructor) {
		if($name === null) {
			$name = "Html";
		}
		$this->name = $name;
		$this->urlHelper = $urlHelper;
	}}
	public function register($data) {
		$data->set($this->name, new ufront_web_mvc_view_HtmlHelperInst($this->urlHelper));
	}
	public $urlHelper;
	public $name;
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
	function __toString() { return 'ufront.web.mvc.view.HtmlHelper'; }
}
