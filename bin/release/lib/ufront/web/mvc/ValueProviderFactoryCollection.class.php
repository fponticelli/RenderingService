<?php

class ufront_web_mvc_ValueProviderFactoryCollection {
	public function __construct($array = null) {
		if(!php_Boot::$skip_constructor) {
		$this->internalArray = new _hx_array(array());
		if($array !== null) {
			$_g = 0;
			while($_g < $array->length) {
				$v = $array[$_g];
				++$_g;
				$this->internalArray->push($v);
				unset($v);
			}
		}
	}}
	public function getValueProvider($controllerContext) {
		$output = Lambda::map($this->internalArray, array(new _hx_lambda(array(&$controllerContext), "ufront_web_mvc_ValueProviderFactoryCollection_0"), 'execute'));
		return new ufront_web_mvc_ValueProviderCollection(Lambda::harray($output));
	}
	public $internalArray;
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
	function __toString() { return 'ufront.web.mvc.ValueProviderFactoryCollection'; }
}
function ufront_web_mvc_ValueProviderFactoryCollection_0(&$controllerContext, $v) {
	{
		return $v->getValueProvider($controllerContext);
	}
}
