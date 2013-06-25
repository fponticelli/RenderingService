<?php

class ufront_web_module_TraceToFileModule implements ufront_web_module_ITraceModule{
	public function __construct($path) {
		if(!php_Boot::$skip_constructor) {
		$this->path = $path;
	}}
	public function getFile() {
		if(null === $this->file) {
			$this->file = sys_io_File::append($this->path, null);
		}
		return $this->file;
	}
	public function dispose() {
		$this->path = null;
		if(null === $this->file) {
			return;
		}
		$this->file->close();
		$this->file = null;
	}
	public function trace($msg, $pos = null) {
		$this->getFile()->writeString(_hx_string_or_null(ufront_web_module_TraceToFileModule::format($msg, $pos)) . "\x0A");
	}
	public function init($application) {
	}
	public $path;
	public $file;
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
	static $REMOVENL;
	static function format($msg, $pos) {
		$msg = ufront_web_module_TraceToFileModule::$REMOVENL->replace($msg, "\\n");
		return "" . Std::string(Date::now()) . ": " . _hx_string_or_null($pos->className) . "." . _hx_string_or_null($pos->methodName) . "(" . _hx_string_rec($pos->lineNumber, "") . ") " . _hx_string_or_null(thx_core_Dynamics::string($msg));
	}
	function __toString() { return 'ufront.web.module.TraceToFileModule'; }
}
ufront_web_module_TraceToFileModule::$REMOVENL = new EReg("[\x0A\x0D]", "g");
