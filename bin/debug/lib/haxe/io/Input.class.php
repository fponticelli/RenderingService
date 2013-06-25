<?php

class haxe_io_Input {
	public function __construct(){}
	public function readString($len) {
		$b = haxe_io_Bytes::alloc($len);
		$this->readFullBytes($b, 0, $len);
		return $b->toString();
	}
	public function readFullBytes($s, $pos, $len) {
		while($len > 0) {
			$k = $this->readBytes($s, $pos, $len);
			$pos += $k;
			$len -= $k;
			unset($k);
		}
	}
	public function readAll($bufsize = null) {
		if($bufsize === null) {
			$bufsize = 8192;
		}
		$buf = haxe_io_Bytes::alloc($bufsize);
		$total = new haxe_io_BytesBuffer();
		try {
			while(true) {
				$len = $this->readBytes($buf, 0, $bufsize);
				if($len === 0) {
					throw new HException(haxe_io_Error::$Blocked);
				}
				{
					if($len < 0 || $len > $buf->length) {
						throw new HException(haxe_io_Error::$OutsideBounds);
					}
					$total->b .= _hx_string_or_null(substr($buf->b, 0, $len));
				}
				unset($len);
			}
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			if(($e = $_ex_) instanceof haxe_io_Eof){
			} else throw $__hx__e;;
		}
		return $total->getBytes();
	}
	public function close() {
	}
	public function readBytes($s, $pos, $len) {
		$k = $len;
		$b = $s->b;
		if($pos < 0 || $len < 0 || $pos + $len > $s->length) {
			throw new HException(haxe_io_Error::$OutsideBounds);
		}
		while($k > 0) {
			$b[$pos] = chr($this->readByte());
			$pos++;
			$k--;
		}
		return $len;
	}
	public function readByte() {
		haxe_io_Input_0($this);
	}
	function __toString() { return 'haxe.io.Input'; }
}
function haxe_io_Input_0(&$__hx__this) {
	throw new HException("Not implemented");
}
