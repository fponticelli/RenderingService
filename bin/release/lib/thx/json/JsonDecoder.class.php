<?php

class thx_json_JsonDecoder {
	public function __construct($handler, $tabsize = null) {
		if(!php_Boot::$skip_constructor) {
		if($tabsize === null) {
			$tabsize = 4;
		}
		$this->handler = $handler;
		$this->tabsize = $tabsize;
	}}
	public function error($msg) {
		$context = thx_json_JsonDecoder_0($this, $msg);
		throw new HException(new thx_error_Error("error at L {0} C {1}: {2}{3}", new _hx_array(array($this->line, $this->col, $msg, $context)), null, _hx_anonymous(array("fileName" => "JsonDecoder.hx", "lineNumber" => 353, "className" => "thx.json.JsonDecoder", "methodName" => "error"))));
	}
	public function parseDigits($atleast = null) {
		if($atleast === null) {
			$atleast = 0;
		}
		$buf = "";
		while(true) {
			$c = null;
			try {
				$c = $this->readChar();
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				if(($e = $_ex_) instanceof thx_json__JsonDecoder_StreamError){
					if(strlen($buf) < $atleast) {
						$this->error("expected digit");
					}
					return $buf;
				} else throw $__hx__e;;
			}
			$i = _hx_char_code_at($c, 0);
			if($i < 48 || $i > 57) {
				if(strlen($buf) < $atleast) {
					$this->error("expected digit");
				}
				$this->col += strlen($buf);
				$this->char = $c;
				return $buf;
			} else {
				$buf .= _hx_string_or_null($c);
			}
			unset($i,$e,$c);
		}
		return null;
	}
	public function parseFloat() {
		$v = "";
		if($this->expect("-")) {
			$v = "-";
		}
		if($this->expect("0")) {
			$v .= "0";
		} else {
			$c = $this->readChar();
			$i = _hx_char_code_at($c, 0);
			if($i < 49 || $i > 57) {
				$this->error("expected digit between 1 and 9");
			}
			$v .= _hx_string_or_null($c);
			$this->col++;
		}
		try {
			$v .= _hx_string_or_null($this->parseDigits(null));
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			if(($e = $_ex_) instanceof thx_json__JsonDecoder_StreamError){
				$this->handler->valueInt(Std::parseInt($v));
				return;
			} else throw $__hx__e;;
		}
		try {
			if($this->expect(".")) {
				$v .= "." . _hx_string_or_null($this->parseDigits(1));
			} else {
				$this->handler->valueInt(Std::parseInt($v));
				return;
			}
			if($this->expect("e") || $this->expect("E")) {
				$v .= "e";
				if($this->expect("+")) {
				} else {
					if($this->expect("-")) {
						$v .= "-";
					}
				}
				$v .= _hx_string_or_null($this->parseDigits(1));
			}
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			if(($e2 = $_ex_) instanceof thx_json__JsonDecoder_StreamError){
				$this->handler->valueFloat(Std::parseFloat($v));
				return;
			} else throw $__hx__e;;
		}
		$this->handler->valueFloat(Std::parseFloat($v));
	}
	public function parseHexa() {
		$v = new _hx_array(array());
		{
			$_g = 0;
			while($_g < 4) {
				$i = $_g++;
				$c = $this->readChar();
				$i1 = _hx_char_code_at(strtolower($c), 0);
				if(!($i1 >= 48 && $i1 <= 57 || $i1 >= 97 && $i1 <= 102)) {
					$this->error("invalid hexadecimal value " . _hx_string_or_null($c));
				}
				$v->push($c);
				unset($i1,$i,$c);
			}
		}
		$this->handler->valueInt(Std::parseInt("0x" . _hx_string_or_null($v->join(""))));
		return Std::parseInt("0x" . _hx_string_or_null($v->join("")));
	}
	public function _parseString() {
		if(!$this->expect("\"")) {
			$this->error("expected double quote");
		}
		$buf = "";
		$esc = false;
		while(true) {
			$c = $this->readChar();
			$this->col++;
			if($esc) {
				switch($c) {
				case "\"":{
					$buf .= "\"";
				}break;
				case "\\":{
					$buf .= "\\";
				}break;
				case "/":{
					$buf .= "/";
				}break;
				case "b":{
					$buf .= "\x08";
				}break;
				case "f":{
					$buf .= "\x0C";
				}break;
				case "n":{
					$buf .= "\x0A";
				}break;
				case "r":{
					$buf .= "\x0D";
				}break;
				case "t":{
					$buf .= "\x09";
				}break;
				case "u":{
					$utf = new haxe_Utf8(null);
					$utf->addChar($this->parseHexa());
					$buf .= _hx_string_or_null($utf->toString());
				}break;
				default:{
					$this->error("unexpected char " . _hx_string_or_null($c));
				}break;
				}
				$esc = false;
			} else {
				switch($c) {
				case "\\":{
					$esc = true;
				}break;
				case "\"":{
					break 2;
				}break;
				default:{
					$buf .= _hx_string_or_null($c);
				}break;
				}
			}
			unset($c);
		}
		return $buf;
	}
	public function parseString() {
		$this->handler->valueString($this->_parseString());
	}
	public function parseValue() {
		if($this->expect("true")) {
			$this->handler->valueBool(true);
		} else {
			if($this->expect("false")) {
				$this->handler->valueBool(false);
			} else {
				if($this->expect("null")) {
					$this->handler->valueNull();
				} else {
					$this->parseFloat();
				}
			}
		}
	}
	public function parseArray() {
		$this->ignoreWhiteSpace();
		$first = true;
		$this->handler->arrayStart();
		while(true) {
			$this->ignoreWhiteSpace();
			if($this->expect("]")) {
				break;
			} else {
				if($first) {
					$first = false;
				} else {
					if($this->expect(",")) {
						$this->ignoreWhiteSpace();
					} else {
						$this->error("expected ','");
					}
				}
			}
			$this->handler->arrayItemStart();
			$this->parse();
			$this->handler->arrayItemEnd();
		}
		$this->handler->arrayEnd();
	}
	public function parseObject() {
		$first = true;
		$this->handler->objectStart();
		while(true) {
			$this->ignoreWhiteSpace();
			if($this->expect("}")) {
				break;
			} else {
				if($first) {
					$first = false;
				} else {
					if($this->expect(",")) {
						$this->ignoreWhiteSpace();
					} else {
						$this->error("expected ','");
					}
				}
			}
			$k = $this->_parseString();
			$this->ignoreWhiteSpace();
			if(!$this->expect(":")) {
				$this->error("expected ':'");
			}
			$this->ignoreWhiteSpace();
			$this->handler->objectFieldStart($k);
			$this->parse();
			$this->handler->objectFieldEnd();
			unset($k);
		}
		$this->handler->objectEnd();
	}
	public function expect($word) {
		$test = thx_json_JsonDecoder_1($this, $word);
		if($test === $word) {
			if(null === $this->char) {
				$this->pos += strlen($word);
			} else {
				$this->pos += strlen($word) - 1;
				$this->char = null;
			}
			return true;
		} else {
			return false;
		}
	}
	public function readChar() {
		if(null === $this->char) {
			if($this->pos === strlen($this->src)) {
				throw new HException(thx_json__JsonDecoder_StreamError::$Eof);
			}
			return _hx_char_at($this->src, $this->pos++);
		} else {
			$c = $this->char;
			$this->char = null;
			return $c;
		}
	}
	public function parse() {
		$c = $this->readChar();
		switch($c) {
		case "{":{
			$this->col++;
			$this->ignoreWhiteSpace();
			$this->parseObject();
		}break;
		case "[":{
			$this->col++;
			$this->ignoreWhiteSpace();
			$this->parseArray();
		}break;
		case "\"":{
			$this->char = $c;
			$this->parseString();
		}break;
		default:{
			$this->char = $c;
			$this->parseValue();
		}break;
		}
	}
	public function ignoreWhiteSpace() {
		while($this->pos < strlen($this->src)) {
			$c = $this->readChar();
			switch($c) {
			case " ":{
				$this->col++;
			}break;
			case "\x0A":{
				$this->col = 0;
				$this->line++;
			}break;
			case "\x0D":{
			}break;
			case "\x09":{
				$this->col += $this->tabsize;
			}break;
			default:{
				$this->char = $c;
				return;
			}break;
			}
			unset($c);
		}
	}
	public function decode($s) {
		$this->col = 0;
		$this->line = 0;
		$this->src = $s;
		$this->char = null;
		$this->pos = 0;
		$this->ignoreWhiteSpace();
		$this->handler->start();
		try {
			$this->parse();
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			if(($e = $_ex_) instanceof thx_json__JsonDecoder_StreamError){
				$this->error("unexpected end of stream");
			} else throw $__hx__e;;
		}
		$this->ignoreWhiteSpace();
		if($this->pos < strlen($this->src)) {
			$this->error("the stream contains unrecognized characters at its end");
		}
		$this->handler->end();
	}
	public $handler;
	public $pos;
	public $char;
	public $src;
	public $tabsize;
	public $line;
	public $col;
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
	function __toString() { return 'thx.json.JsonDecoder'; }
}
function thx_json_JsonDecoder_0(&$__hx__this, &$msg) {
	if($__hx__this->pos === strlen($__hx__this->src)) {
		return "";
	} else {
		return "\x0Arest: " . _hx_string_or_null((thx_json_JsonDecoder_2($__hx__this, $msg))) . _hx_string_or_null(_hx_substr($__hx__this->src, $__hx__this->pos, null)) . "...";
	}
}
function thx_json_JsonDecoder_1(&$__hx__this, &$word) {
	if(null === $__hx__this->char) {
		return _hx_substr($__hx__this->src, $__hx__this->pos, strlen($word));
	} else {
		return _hx_string_or_null($__hx__this->char) . _hx_string_or_null(_hx_substr($__hx__this->src, $__hx__this->pos, strlen($word) - 1));
	}
}
function thx_json_JsonDecoder_2(&$__hx__this, &$msg) {
	if(null !== $__hx__this->char) {
		return $__hx__this->char;
	} else {
		return "";
	}
}
