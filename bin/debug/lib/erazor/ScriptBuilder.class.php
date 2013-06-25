<?php

class erazor_ScriptBuilder {
	public function __construct($context) {
		if(!php_Boot::$skip_constructor) {
		$this->context = $context;
	}}
	public function blockToString($block) {
		$__hx__t = ($block);
		switch($__hx__t->index) {
		case 0:
		$s = $__hx__t->params[0];
		{
			return _hx_string_or_null($this->context) . ".add('" . _hx_string_or_null(str_replace("'", "\\'", $s)) . "');\x0A";
		}break;
		case 1:
		$s = $__hx__t->params[0];
		{
			return _hx_string_or_null($s) . "\x0A";
		}break;
		case 2:
		$s = $__hx__t->params[0];
		{
			return _hx_string_or_null($this->context) . ".add(" . _hx_string_or_null($s) . ");\x0A";
		}break;
		}
	}
	public function build($blocks) {
		$buffer = new StringBuf();
		{
			$_g = 0;
			while($_g < $blocks->length) {
				$block = $blocks[$_g];
				++$_g;
				$buffer->add($this->blockToString($block));
				unset($block);
			}
		}
		return $buffer->b;
	}
	public $context;
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
	function __toString() { return 'erazor.ScriptBuilder'; }
}
