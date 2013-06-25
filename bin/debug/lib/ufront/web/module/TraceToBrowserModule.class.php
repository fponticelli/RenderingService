<?php

class ufront_web_module_TraceToBrowserModule implements ufront_web_module_ITraceModule{
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->messages = new _hx_array(array());
	}}
	public function _formatMessage($m) {
		$type = ufront_web_module_TraceToBrowserModule_0($this, $m);
		if($type !== "warn" && $type !== "info" && $type !== "debug" && $type !== "error") {
			$type = ((_hx_field($m, "pos") === null) ? "error" : "log");
		}
		$msg = _hx_string_or_null(_hx_explode(".", $m->pos->className)->pop()) . "." . _hx_string_or_null($m->pos->methodName) . "(" . _hx_string_rec($m->pos->lineNumber, "") . "): " . Std::string($m->msg);
		return "console." . _hx_string_or_null($type) . "(decodeURIComponent(\"" . _hx_string_or_null(rawurlencode($msg)) . "\"))";
	}
	public function _sendContent($application) {
		if($application->get_response()->get_contentType() !== "text/html") {
			$this->messages = new _hx_array(array());
			return;
		}
		$results = new _hx_array(array());
		{
			$_g = 0; $_g1 = $this->messages;
			while($_g < $_g1->length) {
				$msg = $_g1[$_g];
				++$_g;
				$results->push($this->_formatMessage($msg));
				unset($msg);
			}
		}
		if($results->length > 0) {
			$application->get_response()->write("\x0A<script type=\"text/javascript\">\x0A" . _hx_string_or_null($results->join("\x0A")) . "\x0A</script>");
		}
		$this->messages = new _hx_array(array());
	}
	public function dispose() {
	}
	public function trace($msg, $pos = null) {
		$this->messages->push(_hx_anonymous(array("msg" => $msg, "pos" => $pos)));
	}
	public function init($application) {
		$application->onLogRequest->add((isset($this->_sendContent) ? $this->_sendContent: array($this, "_sendContent")));
	}
	public $messages;
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
	function __toString() { return 'ufront.web.module.TraceToBrowserModule'; }
}
function ufront_web_module_TraceToBrowserModule_0(&$__hx__this, &$m) {
	if(_hx_field($m, "pos") !== null && $m->pos->customParams !== null) {
		return $m->pos->customParams[0];
	}
}
