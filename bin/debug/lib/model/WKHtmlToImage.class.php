<?php

class model_WKHtmlToImage extends model_WKHtml {
	public function __construct($binpath) {
		if(!php_Boot::$skip_constructor) {
		$this->allowedFormats = new _hx_array(array("png", "jpg", "svg", "bmp", "tif"));
		parent::__construct($binpath);
	}}
	public function commandOptions() {
		$args = new _hx_array(array()); $cfg = $this->get_imageConfig();
		if(null !== $cfg->x) {
			$args->push("--crop-x");
			$args->push("" . _hx_string_rec($cfg->x, ""));
		}
		if(null !== $cfg->y) {
			$args->push("--crop-y");
			$args->push("" . _hx_string_rec($cfg->y, ""));
		}
		if(null !== $cfg->width) {
			$args->push("--crop-w");
			$args->push("" . _hx_string_rec($cfg->width, ""));
		}
		if(null !== $cfg->height) {
			$args->push("--crop-h");
			$args->push("" . _hx_string_rec($cfg->height, ""));
		}
		if(null !== $cfg->screenWidth) {
			$args->push("--width");
			$args->push("" . _hx_string_rec($cfg->screenWidth, ""));
		}
		if(null !== $cfg->screenHeight) {
			$args->push("--height");
			$args->push("" . _hx_string_rec($cfg->screenHeight, ""));
		}
		if(null !== $cfg->quality) {
			$args->push("--quality");
			$args->push("" . _hx_string_rec($cfg->quality, ""));
		}
		if(true === $cfg->disableSmartWidth) {
			$args->push("--disable-smart-width");
		}
		if(true === $cfg->transparent) {
			$args->push("--transparent");
		}
		if($this->get_format() === "svg") {
			$args->push("--run-script");
			$args->push(model_WKHtmlToImage::svgAdjust());
		}
		return parent::commandOptions()->concat($args);
	}
	public function modify($content) {
		{
			$_g = $this->get_format();
			switch($_g) {
			case "svg":{
				$content = str_replace("xml:id", "id", $content);
				$content = str_replace("gradientUnits=\"userSpaceOnUse\"", "gradientUnits=\"objectBoundingBox\"", $content);
			}break;
			}
		}
		return $content;
	}
	public function set_imageConfig($c) {
		return $this->_imageConfig = $c;
	}
	public function get_imageConfig() {
		if(null === $this->_imageConfig) {
			$this->_imageConfig = new model_ConfigImage();
		}
		return $this->_imageConfig;
	}
	public $_imageConfig;
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
	static $MATCHX;
	static function svgAdjust() {
		return model_WKHtml::minifyJs("(function(){\x0Afunction fixSvg()\x0A{\x0A\x09var ns = 'http://www.w3.org/2000/svg';\x0A\x09var els = document.getElementsByTagNameNS(ns, 'line');\x0A\x09console.log(els.length);\x0A\x0A\x09function g(node, name)\x0A\x09{\x0A\x09\x09return node.getAttribute(name);\x0A\x09}\x0A\x0A\x09function s(node, name, value)\x0A\x09{\x0A\x09\x09return node.setAttribute(name, value);\x0A\x09}\x0A\x0A\x09function inc(node, name, value)\x0A\x09{\x0A\x09\x09return s(node, name, g(node, name)+value);\x0A\x09}\x0A\x0A\x09for(var i = 0; i < els.length; i++)\x0A\x09{\x0A\x09\x09var el = els[i];\x0A\x09\x09if(g(el, 'x1') == g(el, 'x2')) inc(el, 'x2', 0.0000000001);\x0A\x09\x09if(g(el, 'y1') == g(el, 'y2')) inc(el, 'y2', 0.0000000001);\x0A\x09}\x0A}\x0A\x0Aif('undefined' != typeof ReportGrid && 'undefined' != typeof ReportGrid.charts && 'undefined' != typeof ReportGrid.charts.ready)\x0A{\x0A\x09ReportGrid.charts.ready(fixSvg);\x0A} else {\x0A\x09fixSvg();\x0A}\x0A})()");
	}
	static $__properties__ = array("set_imageConfig" => "set_imageConfig","get_imageConfig" => "get_imageConfig","set_wkConfig" => "set_wkConfig","get_wkConfig" => "get_wkConfig","set_format" => "set_format","get_format" => "get_format");
	function __toString() { return 'model.WKHtmlToImage'; }
}
model_WKHtmlToImage::$MATCHX = new EReg("x1=\"((?:\\d+\\.)\\d+)\"\\s+y1=\"((?:\\d+\\.)\\d+)\"\\s+x2=\"((?:\\d+\\.)\\d+)\"\\s+y2=\"((?:\\d+\\.)\\d+)\"", "ig");
