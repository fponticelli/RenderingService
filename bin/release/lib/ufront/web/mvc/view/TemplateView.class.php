<?php

class ufront_web_mvc_view_TemplateView implements ufront_web_mvc_view_ITemplateView{
	public function __construct($template) {
		if(!php_Boot::$skip_constructor) {
		$this->template = $template;
		$this->wrappers = new thx_collection_HashList();
	}}
	public function executeTemplate($template, $data) {
		ufront_web_mvc_view_TemplateView_0($this, $data, $template);
	}
	public function data() {
		ufront_web_mvc_view_TemplateView_1($this);
	}
	public function render($viewContext, $outputData) {
		$helpers = $viewContext->viewHelpers->copy();
		$urlHelper = new ufront_web_mvc_view_UrlHelper(null, $viewContext->requestContext);
		$helpers->push($urlHelper);
		$helpers->push(new ufront_web_mvc_view_TemplateHelper($viewContext, $this));
		$helpers->push(new ufront_web_mvc_view_FormatHelper());
		{
			$_g = $viewContext->response->get_contentType();
			switch($_g) {
			case "application/xhtml+xml":{
				$helpers->push(new ufront_web_mvc_view_XHtmlHelper(null, $urlHelper->inst));
			}break;
			case "text/html":{
				$helpers->push(new ufront_web_mvc_view_HtmlHelper(null, $urlHelper->inst));
			}break;
			}
		}
		{
			$_g1 = 0;
			while($_g1 < $helpers->length) {
				$helper = $helpers[$_g1];
				++$_g1;
				$helper->register($viewContext->viewData);
				unset($helper);
			}
		}
		$result = $this->executeTemplate($this->template, $viewContext->viewData);
		$hash = $this->data();
		if(null == $this->wrappers) throw new HException('null iterable');
		$__hx__it = $this->wrappers->keys();
		while($__hx__it->hasNext()) {
			$key = $__hx__it->next();
			$hash->set($key, $result);
			$wrapper = $this->wrappers->get($key);
			$result = $this->executeTemplate($wrapper, $hash);
			unset($wrapper);
		}
		if(null == $hash) throw new HException('null iterable');
		$__hx__it = $hash->keys();
		while($__hx__it->hasNext()) {
			$key = $__hx__it->next();
			$value = $hash->get($key);
			$outputData->set($key, $value);
			unset($value);
		}
		return $result;
	}
	public $wrappers;
	public $template;
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
	function __toString() { return 'ufront.web.mvc.view.TemplateView'; }
}
function ufront_web_mvc_view_TemplateView_0(&$__hx__this, &$data, &$template) {
	throw new HException(new thx_error_Error("abstract method", null, null, _hx_anonymous(array("fileName" => "TemplateView.hx", "lineNumber" => 75, "className" => "ufront.web.mvc.view.TemplateView", "methodName" => "executeTemplate"))));
}
function ufront_web_mvc_view_TemplateView_1(&$__hx__this) {
	throw new HException(new thx_error_Error("abstract method", null, null, _hx_anonymous(array("fileName" => "TemplateView.hx", "lineNumber" => 70, "className" => "ufront.web.mvc.view.TemplateView", "methodName" => "data"))));
}
