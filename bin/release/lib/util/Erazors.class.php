<?php

class util_Erazors {
	public function __construct(){}
	static function apply($template, $ob) {
		Reflect::fields($ob)->map(array(new _hx_lambda(array(&$ob, &$template), "util_Erazors_0"), 'execute'));
		return $template;
	}
	function __toString() { return 'util.Erazors'; }
}
function util_Erazors_0(&$ob, &$template, $field) {
	{
		$template->{$field} = Reflect::field($ob, $field);
	}
}
