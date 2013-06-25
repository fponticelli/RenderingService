<?php

class sys_io__Process_Stdin extends haxe_io_Output {
	public function __construct($p) {
		if(!php_Boot::$skip_constructor) {
		$this->p = $p;
		$this->buf = haxe_io_Bytes::alloc(1);
	}}
	public function writeBytes($b, $pos, $l) {
		$s = $b->readString($pos, $l);
		if(feof($this->p)) {
			sys_io__Process_Stdin_0($this, $b, $l, $pos, $s);
		}
		$r = fwrite($this->p, $s, $l);
		if(($r === false)) {
			sys_io__Process_Stdin_1($this, $b, $l, $pos, $r, $s);
		}
		return $r;
	}
	public function writeByte($c) {
		$this->buf->b[0] = chr($c);
		$this->writeBytes($this->buf, 0, 1);
	}
	public function close() {
		parent::close();
		fclose($this->p);
	}
	public $buf;
	public $p;
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
	function __toString() { return 'sys.io._Process.Stdin'; }
}
function sys_io__Process_Stdin_0(&$__hx__this, &$b, &$l, &$pos, &$s) {
	throw new HException(new haxe_io_Eof());
}
function sys_io__Process_Stdin_1(&$__hx__this, &$b, &$l, &$pos, &$r, &$s) {
	throw new HException(haxe_io_Error::Custom("An error occurred"));
}
