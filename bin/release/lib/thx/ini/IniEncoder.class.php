<?php

class thx_ini_IniEncoder implements thx_data_IDataHandler{
	public function __construct($newline = null, $ignorecomments = null) {
		if(!php_Boot::$skip_constructor) {
		if($ignorecomments === null) {
			$ignorecomments = true;
		}
		if($newline === null) {
			$newline = "\x0A";
		}
		$this->newline = $newline;
		$this->ignorecomments = $ignorecomments;
	}}
	public function valueBool($b) {
		$this->value .= _hx_string_or_null((($b) ? "ON" : "OFF"));
	}
	public function comment($s) {
		if(!$this->ignorecomments) {
			$this->value .= "#" . _hx_string_or_null($s);
		}
	}
	public function valueNull() {
		$this->value .= "";
	}
	public function valueFloat($f) {
		$this->value .= _hx_string_rec($f, "");
	}
	public function valueInt($i) {
		$this->value .= _hx_string_rec($i, "");
	}
	public function quote($s) {
		return "\"" . _hx_string_or_null(thx_ini_IniEncoder_0($this, $s)) . "\"";
	}
	public function enc($s) {
		{
			$_g1 = 0; $_g = thx_ini_IniEncoder::$decoded->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$s = thx_ini_IniEncoder_1($this, $_g, $_g1, $i, $s);
				unset($i);
			}
		}
		return $s;
	}
	public function valueString($s) {
		if(trim($s) === $s) {
			$this->value .= _hx_string_or_null($this->enc($s));
		} else {
			$this->value .= _hx_string_or_null($this->quote($s));
		}
	}
	public function valueDate($d) {
		if($d->getSeconds() === 0 && $d->getMinutes() === 0 && $d->getHours() === 0) {
			$this->value .= _hx_string_or_null(thx_core_Dates::format($d, "C", new _hx_array(array("%Y-%m-%d")), null));
		} else {
			$this->value .= _hx_string_or_null(thx_core_Dates::format($d, "C", new _hx_array(array("%Y-%m-%d %H:%M:%S")), null));
		}
	}
	public function arrayEnd() {
		$this->inarray = 0;
	}
	public function arrayItemEnd() {
	}
	public function arrayItemStart() {
		if($this->inarray === 1) {
			$this->inarray = 2;
		} else {
			$this->value .= ", ";
		}
	}
	public function arrayStart() {
		if($this->inarray > 0) {
			throw new HException(new thx_error_Error("nested arrays are not supported in the .ini format", null, null, _hx_anonymous(array("fileName" => "IniEncoder.hx", "lineNumber" => 99, "className" => "thx.ini.IniEncoder", "methodName" => "arrayStart"))));
		}
		$this->inarray = 1;
		$this->value = "";
	}
	public function objectEnd() {
		$this->stack->pop();
	}
	public function getSection($name) {
		$section = $this->cache->get($name);
		if(null === $section) {
			$section = new _hx_array(array());
			$this->cache->set($name, $section);
		}
		return $section;
	}
	public function objectFieldEnd() {
		if(null === $this->value) {
			return;
		}
		$key = $this->stack->pop();
		$name = $this->stack->join(".");
		$section = $this->getSection($name);
		$section->push(_hx_string_or_null($key) . "=" . _hx_string_or_null($this->value));
		$this->value = null;
	}
	public function objectFieldStart($name) {
		$this->stack->push($this->enc($name));
		$this->value = "";
	}
	public function objectStart() {
		if($this->inarray > 0) {
			throw new HException(new thx_error_Error("arrays must contain only primitive values", null, null, _hx_anonymous(array("fileName" => "IniEncoder.hx", "lineNumber" => 60, "className" => "thx.ini.IniEncoder", "methodName" => "objectStart"))));
		}
	}
	public function end() {
		$keys = thx_ini_IniEncoder_2($this);
		$lines = new _hx_array(array());
		{
			$_g = 0;
			while($_g < $keys->length) {
				$key = $keys[$_g];
				++$_g;
				if("" !== $key) {
					$lines->push("");
					$lines->push("[" . _hx_string_or_null($key) . "]");
				}
				$lines = $lines->concat($this->cache->get($key));
				unset($key);
			}
		}
		$this->encodedString = trim($lines->join($this->newline));
	}
	public function start() {
		$this->inarray = 0;
		$this->stack = new _hx_array(array());
		$this->cache = new haxe_ds_StringMap();
	}
	public $stack;
	public $value;
	public $cache;
	public $inarray;
	public $encodedString;
	public $buf;
	public $newline;
	public $ignorecomments;
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
	static $decoded;
	static $encoded;
	function __toString() { return 'thx.ini.IniEncoder'; }
}
thx_ini_IniEncoder::$decoded = new _hx_array(array("\\", chr(0), "\x07", "\x08", "\x09", "\x0D", "\x0A", ";", "#", "=", ":"));
thx_ini_IniEncoder::$encoded = new _hx_array(array("\\\\", "\\0", "\\a", "\\b", "\\t", "\\r", "\\n", "\\;", "\\#", "\\=", "\\:"));
function thx_ini_IniEncoder_0(&$__hx__this, &$s) {
	{
		$s1 = $__hx__this->enc($s);
		return str_replace("\"", "\\\"", $s1);
	}
}
function thx_ini_IniEncoder_1(&$__hx__this, &$_g, &$_g1, &$i, &$s) {
	{
		$sub = thx_ini_IniEncoder::$decoded[$i]; $by = thx_ini_IniEncoder::$encoded[$i];
		if($sub === "") {
			return implode(str_split ($s), $by);
		} else {
			return str_replace($sub, $by, $s);
		}
		unset($sub,$by);
	}
}
function thx_ini_IniEncoder_2(&$__hx__this) {
	{
		$arr = thx_core_Iterators::harray($__hx__this->cache->keys());
		$arr->sort((isset(thx_core_Dynamics::$compare) ? thx_core_Dynamics::$compare: array("thx_core_Dynamics", "compare")));
		return $arr;
	}
}
