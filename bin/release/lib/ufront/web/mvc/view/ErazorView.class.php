<?php

class ufront_web_mvc_view_ErazorView extends ufront_web_mvc_view_TemplateView {
	public function __construct($template) { if(!php_Boot::$skip_constructor) {
		parent::__construct($template);
	}}
	public function data() {
		return $this->template->variables;
	}
	public function executeTemplate($template, $data) {
		return $template->execute($data);
	}
	function __toString() { return 'ufront.web.mvc.view.ErazorView'; }
}
