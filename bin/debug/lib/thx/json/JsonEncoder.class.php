<?php

class thx_json_JsonEncoder implements thx_data_IDataHandler{
	public function __construct() {
		;
	}
	public function quote($s) {
		return "\"" . _hx_string_or_null(_hx_deref(new EReg(".", ""))->map(_hx_deref(new EReg("(\x0A)", "g"))->replace(_hx_deref(new EReg("(\"|\\\\)", "g"))->replace($s, "\\\$1"), "\\n"), array(new _hx_lambda(array(&$s), "thx_json_JsonEncoder_0"), 'execute'))) . "\"";
	}
	public function comment($s) {
	}
	public function valueBool($b) {
		$this->buf->add((($b) ? "true" : "false"));
	}
	public function valueNull() {
		$this->buf->add("null");
	}
	public function valueFloat($f) {
		$this->buf->add($f);
	}
	public function valueInt($i) {
		$this->buf->add($i);
	}
	public function valueString($s) {
		$this->buf->add($this->quote($s));
	}
	public function valueDate($d) {
		$this->buf->add($d->getTime());
	}
	public function arrayEnd() {
		$this->buf->add("]");
		$this->count->pop();
	}
	public function arrayItemEnd() {
	}
	public function arrayItemStart() {
		if($this->count->a[$this->count->length - 1]++ > 0) {
			$this->buf->add(",");
		}
	}
	public function arrayStart() {
		$this->buf->add("[");
		$this->count->push(0);
	}
	public function objectEnd() {
		$this->buf->add("}");
		$this->count->pop();
	}
	public function objectFieldEnd() {
	}
	public function objectFieldStart($name) {
		if($this->count->a[$this->count->length - 1]++ > 0) {
			$this->buf->add(",");
		}
		$this->buf->add(_hx_string_or_null($this->quote($name)) . ":");
	}
	public function objectStart() {
		$this->buf->add("{");
		$this->count->push(0);
	}
	public function end() {
		$this->encodedString = $this->buf->b;
		$this->buf = null;
	}
	public function start() {
		$this->lvl = 0;
		$this->buf = new StringBuf();
		$this->encodedString = null;
		$this->count = new _hx_array(array());
	}
	public $count;
	public $lvl;
	public $buf;
	public $encodedString;
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
	function __toString() { return 'thx.json.JsonEncoder'; }
}
function thx_json_JsonEncoder_0(&$s, $r) {
	{
		$c = _hx_char_code_at($r->matched(0), 0);
		return thx_json_JsonEncoder_1($__hx__this, $c, $r, $s);
	}
}
function thx_json_JsonEncoder_1(&$__hx__this, &$c, &$r, &$s) {
	if($c >= 32 && $c <= 127) {
		return chr($c);
	} else {
		return "\\u" . _hx_string_or_null(StringTools::hex($c, 4));
	}
}
