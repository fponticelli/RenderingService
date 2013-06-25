<?php

class model_ConfigPdf {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->grayscale = false;
		$this->lowQuality = false;
		$this->portrait = true;
		$this->usePrintMediaType = false;
		$this->disableSmartShrinking = false;
		$this->footerLine = false;
		$this->headerLine = false;
	}}
	public function toString() {
		return "ConfigPdf: " . _hx_string_or_null(model_ConfigObjects::fieldsToString($this));
	}
	public $headerLine;
	public $headerSpacing;
	public $headerHtml;
	public $headerFontSize;
	public $headerFontName;
	public $headerRight;
	public $headerLeft;
	public $headerCenter;
	public $footerLine;
	public $footerSpacing;
	public $footerHtml;
	public $footerFontSize;
	public $footerFontName;
	public $footerRight;
	public $footerLeft;
	public $footerCenter;
	public $disableSmartShrinking;
	public $usePrintMediaType;
	public $title;
	public $pageWidth;
	public $pageSize;
	public $pageHeight;
	public $portrait;
	public $marginRight;
	public $marginLeft;
	public $marginBottom;
	public $marginTop;
	public $lowQuality;
	public $imageQuality;
	public $imageDpi;
	public $grayscale;
	public $dpi;
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
	function __toString() { return $this->toString(); }
}
