<?php

class erazor_hscript_EnhancedInterp extends hscript_Interp {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
		$add = (isset(_hx_deref(new StringBuf())->add) ? _hx_deref(new StringBuf())->add: array(new StringBuf(), "add"));
	}}
	public function expr($e) {
		$__hx__t = ($e);
		switch($__hx__t->index) {
		case 14:
		$ret = $__hx__t->params[3]; $name = $__hx__t->params[2]; $fexpr = $__hx__t->params[1]; $params = $__hx__t->params[0];
		{
			$capturedLocals = $this->duplicate($this->locals);
			$me = $this;
			$f = array(new _hx_lambda(array(&$capturedLocals, &$e, &$fexpr, &$me, &$name, &$params, &$ret), "erazor_hscript_EnhancedInterp_0"), 'execute');
			$f1 = Reflect::makeVarArgs($f);
			if($name !== null) {
				$this->variables->set($name, $f1);
			}
			return $f1;
		}break;
		default:{
			return parent::expr($e);
		}break;
		}
		return null;
	}
	public function call($o, $f, $args) {
		while(true) {
			try {
				return Reflect::callMethod($o, $f, $args);
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				if(is_string($e = $_ex_)){
					if(_hx_substr($e, 0, 16) !== "Missing argument") {
						php_Lib::rethrow($e);
					}
					$expected = $args->length + 1;
					if(erazor_hscript_EnhancedInterp::$re->match($e)) {
						$expected = Std::parseInt(erazor_hscript_EnhancedInterp::$re->matched(1));
					}
					if($expected > 15) {
						throw new HException("invalid number of arguments");
					} else {
						if($expected < $args->length) {
							$args = $args->slice(0, $expected);
						} else {
							while($expected > $args->length) {
								$args->push(null);
							}
						}
					}
					unset($expected);
				} else throw $__hx__e;;
			}
			unset($e);
		}
		return null;
	}
	public function get($o, $f) {
		if($o === null) {
			throw new HException(hscript_Error::EInvalidAccess($f));
		}
		return Reflect::field($o, $f);
	}
	static $re;
	function __toString() { return 'erazor.hscript.EnhancedInterp'; }
}
erazor_hscript_EnhancedInterp::$re = new EReg("^[^0-9]+(\\d+)", "");
function erazor_hscript_EnhancedInterp_0(&$capturedLocals, &$e, &$fexpr, &$me, &$name, &$params, &$ret, $args) {
	{
		$old = $me->locals;
		$me->locals = $me->duplicate($capturedLocals);
		{
			$_g1 = 0; $_g = $params->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$me->locals->set(_hx_array_get($params, $i)->name, _hx_anonymous(array("r" => $args[$i])));
				unset($i);
			}
		}
		$r = null;
		try {
			$r = $me->exprReturn($fexpr);
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e1 = $_ex_;
			{
				$me->locals = $old;
				throw new HException($e1);
			}
		}
		$me->locals = $old;
		return $r;
	}
}
