<?php

class ufront_web_mvc_view_HtmlHelperInst {
	public function __construct($urlHelper) {
		if(!php_Boot::$skip_constructor) {
		$this->__url = $urlHelper;
	}}
	public function _qatt($value) {
		if(ufront_web_mvc_view_HtmlHelperInst::$WS_PATTERN->match($value)) {
			return "\"" . _hx_string_or_null($this->attributeEncode($value)) . "\"";
		} else {
			return $this->attributeEncode($value);
		}
	}
	public function _attrs($attrs) {
		$arr = new _hx_array(array());
		{
			$_g = 0; $_g1 = Reflect::fields($attrs);
			while($_g < $_g1->length) {
				$name = $_g1[$_g];
				++$_g;
				$value = Reflect::field($attrs, $name);
				if($value === $name) {
					$arr->push($name);
				} else {
					$arr->push(_hx_string_or_null($name) . "=" . _hx_string_or_null($this->_qatt(Reflect::field($attrs, $name))));
				}
				unset($value,$name);
			}
		}
		if($arr->length === 0) {
			return "";
		} else {
			return " " . _hx_string_or_null($arr->join(" "));
		}
	}
	public function tag($name, $attrs) {
		return "<" . _hx_string_or_null($name) . _hx_string_or_null($this->_attrs($attrs)) . ">";
	}
	public function close($name) {
		return "</" . _hx_string_or_null($name) . ">";
	}
	public function open($name, $attrs) {
		return "<" . _hx_string_or_null($name) . _hx_string_or_null($this->_attrs($attrs)) . ">";
	}
	public function routeif($test, $text, $data = null, $attrs = null) {
		return $this->linkif($test, $text, $this->__url->route($data), $attrs);
	}
	public function linkif($test, $text, $url, $attrs = null) {
		if(null === $attrs) {
			$attrs = _hx_anonymous(array());
		}
		if(null === $test) {
			$test = $this->__url->current(null);
		}
		if($url === $test) {
			return _hx_string_or_null($this->open("span", $attrs)) . _hx_string_or_null($text) . _hx_string_or_null($this->close("span"));
		} else {
			$attrs->href = $url;
			return _hx_string_or_null($this->open("a", $attrs)) . _hx_string_or_null($text) . _hx_string_or_null($this->close("a"));
		}
	}
	public function route($text, $data = null, $attrs = null) {
		return $this->link($text, $this->__url->route($data), $attrs);
	}
	public function link($text, $url, $attrs = null) {
		if(null === $attrs) {
			$attrs = _hx_anonymous(array());
		}
		$attrs->href = $url;
		return _hx_string_or_null($this->open("a", $attrs)) . _hx_string_or_null($text) . _hx_string_or_null($this->close("a"));
	}
	public function attributeEncode($s) {
		if($s === null) {
			return "";
		}
		return ufront_web_mvc_view_HtmlHelperInst_0($this, $s);
	}
	public function encode($s) {
		return StringTools::htmlEscape($s, null);
	}
	public $__url;
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
	static $WS_PATTERN;
	function __toString() { return 'ufront.web.mvc.view.HtmlHelperInst'; }
}
ufront_web_mvc_view_HtmlHelperInst::$WS_PATTERN = new EReg("\\s", "m");
function ufront_web_mvc_view_HtmlHelperInst_0(&$__hx__this, &$s) {
	{
		$s1 = ufront_web_mvc_view_HtmlHelperInst_1($s);
		return str_replace("\"", "&quote;", $s1);
	}
}
function ufront_web_mvc_view_HtmlHelperInst_1(&$s) {
	{
		$s2 = ufront_web_mvc_view_HtmlHelperInst_2($s);
		return str_replace("'", "&apos;", $s2);
	}
}
function ufront_web_mvc_view_HtmlHelperInst_2(&$s) {
	{
		$s3 = str_replace("&", "&amp;", $s);
		return str_replace("<", "&lt;", $s3);
	}
}
