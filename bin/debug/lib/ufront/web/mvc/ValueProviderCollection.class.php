<?php

class ufront_web_mvc_ValueProviderCollection extends HList implements ufront_web_mvc_IValueProvider{
	public function __construct($list = null) { if(!php_Boot::$skip_constructor) {
		parent::__construct();
		if($list !== null) {
			$_g = 0;
			while($_g < $list->length) {
				$v = $list[$_g];
				++$_g;
				$this->add($v);
				unset($v);
			}
		}
	}}
	public function getValue($key) {
		if(null == $this) throw new HException('null iterable');
		$__hx__it = $this->iterator();
		while($__hx__it->hasNext()) {
			$v = $__hx__it->next();
			$output = $v->getValue($key);
			if($output !== null) {
				return $output;
			}
			unset($output);
		}
		return null;
	}
	public function containsPrefix($prefix) {
		if(null == $this) throw new HException('null iterable');
		$__hx__it = $this->iterator();
		while($__hx__it->hasNext()) {
			$v = $__hx__it->next();
			if($v->containsPrefix($prefix)) {
				return true;
			}
		}
		return false;
	}
	function __toString() { return 'ufront.web.mvc.ValueProviderCollection'; }
}
