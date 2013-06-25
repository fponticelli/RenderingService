<?php

class thx_data_ValueEncoder {
	public function __construct($handler) {
		if(!php_Boot::$skip_constructor) {
		$this->handler = $handler;
	}}
	public function encodeArray($a) {
		$this->handler->arrayStart();
		{
			$_g = 0;
			while($_g < $a->length) {
				$item = $a[$_g];
				++$_g;
				$this->handler->arrayItemStart();
				$this->encodeValue($item);
				$this->handler->arrayItemEnd();
				unset($item);
			}
		}
		$this->handler->arrayEnd();
	}
	public function encodeList($list) {
		$this->handler->arrayStart();
		if(null == $list) throw new HException('null iterable');
		$__hx__it = $list->iterator();
		while($__hx__it->hasNext()) {
			$item = $__hx__it->next();
			$this->handler->arrayItemStart();
			$this->encodeValue($item);
			$this->handler->arrayItemEnd();
		}
		$this->handler->arrayEnd();
	}
	public function encodeHash($o) {
		$this->handler->objectStart();
		if(null == $o) throw new HException('null iterable');
		$__hx__it = $o->keys();
		while($__hx__it->hasNext()) {
			$key = $__hx__it->next();
			$this->handler->objectFieldStart($key);
			$this->encodeValue($o->get($key));
			$this->handler->objectFieldEnd();
		}
		$this->handler->objectEnd();
	}
	public function encodeObject($o) {
		$this->handler->objectStart();
		{
			$_g = 0; $_g1 = Reflect::fields($o);
			while($_g < $_g1->length) {
				$key = $_g1[$_g];
				++$_g;
				$this->handler->objectFieldStart($key);
				$this->encodeValue(Reflect::field($o, $key));
				$this->handler->objectFieldEnd();
				unset($key);
			}
		}
		$this->handler->objectEnd();
	}
	public function encodeValue($o) {
		$_g = Type::typeof($o);
		$__hx__t = ($_g);
		switch($__hx__t->index) {
		case 0:
		{
			$this->handler->valueNull();
		}break;
		case 1:
		{
			$this->handler->valueInt($o);
		}break;
		case 2:
		{
			$this->handler->valueFloat($o);
		}break;
		case 3:
		{
			$this->handler->valueBool($o);
		}break;
		case 4:
		{
			$this->encodeObject($o);
		}break;
		case 5:
		{
			throw new HException(new thx_error_Error("unable to encode TFunction type", null, null, _hx_anonymous(array("fileName" => "ValueEncoder.hx", "lineNumber" => 39, "className" => "thx.data.ValueEncoder", "methodName" => "encodeValue"))));
		}break;
		case 6:
		$c = $__hx__t->params[0];
		{
			if(Std::is($o, _hx_qtype("String"))) {
				$this->handler->valueString($o);
			} else {
				if(Std::is($o, _hx_qtype("Array"))) {
					$this->encodeArray($o);
				} else {
					if(Std::is($o, _hx_qtype("Date"))) {
						$this->handler->valueDate($o);
					} else {
						if(Std::is($o, _hx_qtype("_Map.Map_Impl_"))) {
							$this->encodeHash($o);
						} else {
							if(Std::is($o, _hx_qtype("List"))) {
								$this->encodeList($o);
							} else {
								throw new HException(new thx_error_Error("unable to encode class '{0}'", null, Type::getClassName($c), _hx_anonymous(array("fileName" => "ValueEncoder.hx", "lineNumber" => 53, "className" => "thx.data.ValueEncoder", "methodName" => "encodeValue"))));
							}
						}
					}
				}
			}
		}break;
		case 7:
		$e = $__hx__t->params[0];
		{
			throw new HException(new thx_error_Error("unable to encode TEnum type '{0}'", null, Type::getEnumName($e), _hx_anonymous(array("fileName" => "ValueEncoder.hx", "lineNumber" => 55, "className" => "thx.data.ValueEncoder", "methodName" => "encodeValue"))));
		}break;
		case 8:
		{
			throw new HException(new thx_error_Error("unable to encode TUnknown type", null, null, _hx_anonymous(array("fileName" => "ValueEncoder.hx", "lineNumber" => 57, "className" => "thx.data.ValueEncoder", "methodName" => "encodeValue"))));
		}break;
		}
	}
	public function encode($o) {
		$this->handler->start();
		$this->encodeValue($o);
		$this->handler->end();
	}
	public $handler;
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
	function __toString() { return 'thx.data.ValueEncoder'; }
}
