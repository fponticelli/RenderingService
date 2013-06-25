<?php

class model_WKHtml {
	public function __construct($cmd) {
		if(!php_Boot::$skip_constructor) {
		$this->cmd = $cmd;
	}}
	public function set_wkConfig($c) {
		return $this->_wkConfig = $c;
	}
	public function get_wkConfig() {
		if(null === $this->_wkConfig) {
			$this->_wkConfig = new model_ConfigWKHtml();
		}
		return $this->_wkConfig;
	}
	public function set_format($f) {
		if(!thx_core_Arrays::exists($this->allowedFormats, $f, null)) {
			throw new HException(new thx_error_Error("invalid format {0}, you can use any of: {1}", new _hx_array(array($f, $this->allowedFormats)), null, _hx_anonymous(array("fileName" => "WKHtml.hx", "lineNumber" => 139, "className" => "model.WKHtml", "methodName" => "set_format"))));
		}
		return $this->format = $f;
	}
	public function get_format() {
		return $this->format;
	}
	public function commandOptions() {
		$args = new _hx_array(array());
		$args->push("--use-xserver");
		$args->push("--disable-local-file-access");
		$args->push("--javascript-delay");
		$args->push("" . _hx_string_rec(model_WKHtml::$JS_DELAY, ""));
		$args->push("--user-style-sheet");
		$args->push(App::$RESET_CSS);
		$args->push("--run-script");
		$args->push(model_WKHtml::finalscript());
		$cfg = $this->get_wkConfig();
		if(null !== $cfg->zoom && !_hx_equal($cfg->zoom, 1)) {
			$args->push("--zoom");
			$args->push("" . _hx_string_rec($cfg->zoom, ""));
		}
		return $args;
	}
	public function execute($args) {
		$process = new sys_io_Process($this->cmd, $args->map(array(new _hx_lambda(array(&$args), "model_WKHtml_0"), 'execute')));
		$process->close();
		$r = $process->exitCode();
		$this->err = $process->stderr->readAll(null)->toString();
		$out = $process->stdout->readAll(null)->toString();
		return $r === 0;
	}
	public $err;
	public function cleanErr($err) {
		return _hx_deref(new EReg("(\x0A\x0D|\x0A|\x0D)", "gm"))->split($err)->map(array(new _hx_lambda(array(&$err), "model_WKHtml_1"), 'execute'))->filter(array(new _hx_lambda(array(&$err), "model_WKHtml_2"), 'execute'))->join("\x0A");
	}
	public function renderUrl($path) {
		$args = $this->commandOptions(); $out = model_WKHtml::tmp($this->get_format());
		$args->push($path);
		$args->push($out);
		$ok = true;
		if(!$this->execute($args)) {
			$ok = false;
			haxe_Log::trace(_hx_string_or_null(model_WKHtml::cmdToString($this->cmd, $args)) . "\x0A" . _hx_string_or_null($this->cleanErr($this->err)), _hx_anonymous(array("fileName" => "WKHtml.hx", "lineNumber" => 56, "className" => "model.WKHtml", "methodName" => "renderUrl")));
		} else {
		}
		if($ok) {
			$result = sys_io_File::getContent($out);
			@unlink($out);
			return $this->modify($result);
		} else {
			if(file_exists($out)) {
				@unlink($out);
			}
			return null;
		}
	}
	public function modify($content) {
		return $content;
	}
	public function render($content) {
		$ext = ((_hx_index_of($content, "-//W3C//DTD XHTML 1.0", null) >= 0) ? "xhtml" : "html");
		$t = model_WKHtml::tmp($ext);
		sys_io_File::saveContent($t, $content);
		$this->err = null;
		$r = $this->renderUrl($t);
		@unlink($t);
		if(null === $r) {
			throw new HException(new thx_error_Error("unable to render the result", null, null, _hx_anonymous(array("fileName" => "WKHtml.hx", "lineNumber" => 35, "className" => "model.WKHtml", "methodName" => "render"))));
		}
		return $r;
	}
	public $allowedFormats;
	public $format;
	public $_wkConfig;
	public $cmd;
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
	static $JS_DELAY = 30000;
	static function cmdToString($cmd, $args) {
		$args = $args->map(array(new _hx_lambda(array(&$args, &$cmd), "model_WKHtml_3"), 'execute'));
		return _hx_string_or_null($cmd) . _hx_string_or_null(((($args->length > 0) ? " " : ""))) . _hx_string_or_null($args->join(" "));
	}
	static function tmp($ext) {
		$uid = null;
		do {
			$uid = model_WKHtml::tmpuid($ext);
		} while(file_exists($uid));
		return $uid;
	}
	static function tmpuid($ext) {
		$id = uniqid("WK_");
		return "/tmp/" . _hx_string_or_null($id) . "." . _hx_string_or_null($ext);
	}
	static function finalscript() {
		$script = "(function(){\x0Afunction log(s)\x0A{\x0A\x09if(\"undefined\" != typeof console)\x0A\x09{\x0A\x09\x09console.log(s);\x0A\x09} else {\x0A\x09\x09var el = document.createElement(\"div\");\x0A\x09\x09el.innerHTML = s;\x0A\x09\x09document.body.appendChild(el);\x0A\x09}\x0A}\x0A\x0Afunction rgcomplete()\x0A{\x0A\x09var images = document.getElementsByTagName(\"img\");\x0A\x09for(var i = 0; i < images.length; i++)\x0A\x09{\x0A\x09\x09var image = images[i];\x0A\x09\x09if(!image.complete)\x0A\x09\x09{\x0A\x09\x09\x09setTimeout(rgcomplete, 50);\x0A\x09\x09\x09return;\x0A\x09\x09}\x0A\x09}\x0A\x09/* if contains \"image\" elements allow for extra 500ms */\x0A\x09if(document.getElementsByTagName(\"image\").length > 0)\x0A\x09\x09setTimeout(window.print, 500);\x0A\x09else\x0A\x09\x09window.print();\x0A}\x0Aif(\"undefined\" != typeof ReportGrid && \"undefined\" != typeof ReportGrid.charts && \"undefined\" != typeof ReportGrid.charts.ready)\x0A{\x0A\x09ReportGrid.charts.ready(rgcomplete);\x0A} else {\x0A\x09setTimeout(window.print, 250);\x0A}\x0A})()";
		return model_WKHtml::minifyJs($script);
	}
	static function minifyJs($js) {
		return _hx_deref(new EReg("\\s+", "mg"))->replace($js, " ");
	}
	static $__properties__ = array("set_wkConfig" => "set_wkConfig","get_wkConfig" => "get_wkConfig","set_format" => "set_format","get_format" => "get_format");
	function __toString() { return 'model.WKHtml'; }
}
function model_WKHtml_0(&$args, $arg) {
	{
		return str_replace("\"", "\\\"", $arg);
	}
}
function model_WKHtml_1(&$err, $line) {
	{
		return trim($line);
	}
}
function model_WKHtml_2(&$err, $line) {
	{
		return $line !== "" && !(_hx_substr($line, 0, 1) === "[" && _hx_substr($line, strlen($line) - 1, 1) === "%");
	}
}
function model_WKHtml_3(&$args, &$cmd, $arg) {
	{
		return model_WKHtml_4($arg, $args, $cmd);
	}
}
function model_WKHtml_4(&$arg, &$args, &$cmd) {
	if(thx_core_Floats::canParse($arg, null) || _hx_substr($arg, 0, 1) === "-") {
		return $arg;
	} else {
		return "'" . _hx_string_or_null(str_replace("'", "\"", $arg)) . "'";
	}
}
