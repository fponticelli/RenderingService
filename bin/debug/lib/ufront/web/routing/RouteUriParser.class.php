<?php

class ufront_web_routing_RouteUriParser {
	public function __construct() {
		;
	}
	public function _parseSegment($segment, $segments, $implicitOptionals, $capturedParams) {
		$stack = new _hx_array(array());
		$seg = $segment;
		while(strlen($seg) > 0) {
			if(ufront_web_routing_RouteUriParser::$constPattern->match($seg)) {
				$stack->push(ufront_web_routing_UriPart::UPConst(ufront_web_routing_RouteUriParser::$constPattern->matched(1)));
				$seg = ufront_web_routing_RouteUriParser::$constPattern->matchedRight();
			} else {
				if(ufront_web_routing_RouteUriParser::$paramPattern->match($seg)) {
					$name = ufront_web_routing_RouteUriParser::$paramPattern->matched(3);
					if($capturedParams->exists($name)) {
						throw new HException(new thx_error_Error("param '{0}' already used in path", null, $name, _hx_anonymous(array("fileName" => "RouteUriParser.hx", "lineNumber" => 216, "className" => "ufront.web.routing.RouteUriParser", "methodName" => "_parseSegment"))));
					} else {
						$capturedParams->add($name);
					}
					$isleftopt = ufront_web_routing_RouteUriParser::$paramPattern->matched(1) === "?";
					$isrest = ufront_web_routing_RouteUriParser::$paramPattern->matched(2) === "*";
					$isrightopt = ufront_web_routing_RouteUriParser::$paramPattern->matched(4) === "?";
					$isopt = ufront_web_routing_RouteUriParser::$paramPattern->matched(1) === "\$" || !$isleftopt && !$isrightopt && $implicitOptionals->exists($name);
					if($this->restUsed) {
						throw new HException(new thx_error_Error("there can be just one rest (*) parameter and it must be the last one", null, null, _hx_anonymous(array("fileName" => "RouteUriParser.hx", "lineNumber" => 226, "className" => "ufront.web.routing.RouteUriParser", "methodName" => "_parseSegment"))));
					}
					if($isrest) {
						$this->restUsed = true;
						if($isleftopt && $isrightopt) {
							$stack->push(ufront_web_routing_UriPart::UPOptBRest($name, null, null));
						} else {
							if($isleftopt) {
								$stack->push(ufront_web_routing_UriPart::UPOptLRest($name, null));
							} else {
								if($isrightopt) {
									$stack->push(ufront_web_routing_UriPart::UPOptRRest($name, null));
								} else {
									if($isopt) {
										$stack->push(ufront_web_routing_UriPart::UPOptRest($name));
									} else {
										$stack->push(ufront_web_routing_UriPart::UPRest($name));
									}
								}
							}
						}
						$seg = _hx_string_or_null(ufront_web_routing_RouteUriParser::$paramPattern->matchedRight()) . _hx_string_or_null(ufront_web_routing_RouteUriParser::reduceRestSegments($segments));
					} else {
						if($isleftopt && $isrightopt) {
							$stack->push(ufront_web_routing_UriPart::UPOptBParam($name, null, null));
						} else {
							if($isleftopt) {
								$stack->push(ufront_web_routing_UriPart::UPOptLParam($name, null));
							} else {
								if($isrightopt) {
									$stack->push(ufront_web_routing_UriPart::UPOptRParam($name, null));
								} else {
									if($isopt) {
										$stack->push(ufront_web_routing_UriPart::UPOptParam($name));
									} else {
										$stack->push(ufront_web_routing_UriPart::UPParam($name));
									}
								}
							}
						}
						$seg = ufront_web_routing_RouteUriParser::$paramPattern->matchedRight();
					}
					unset($name,$isrightopt,$isrest,$isopt,$isleftopt);
				} else {
					throw new HException(new thx_error_Error("invalid uri segment '{0}'", null, $seg, _hx_anonymous(array("fileName" => "RouteUriParser.hx", "lineNumber" => 257, "className" => "ufront.web.routing.RouteUriParser", "methodName" => "_parseSegment"))));
				}
			}
		}
		return $this->_assembleSegment($stack);
	}
	public function _assembleSegment($stack) {
		$parts = new _hx_array(array());
		$optional = true;
		$rest = false;
		$last = $stack->length - 1;
		$i = 0;
		while($i <= $last) {
			$seg = $stack[$i];
			if(0 === $i && $i === $last) {
				$__hx__t = ($seg);
				switch($__hx__t->index) {
				case 0:
				case 1:
				{
					$parts->push($seg);
					$optional = false;
				}break;
				case 6:
				{
					$parts->push($seg);
					$optional = false;
					$rest = true;
				}break;
				case 2:
				{
					$parts->push($seg);
				}break;
				case 7:
				{
					$parts->push($seg);
					$rest = true;
				}break;
				case 3:
				$seg_eUPOptLParam_1 = $__hx__t->params[1]; $name = $__hx__t->params[0];
				{
					$parts->push(ufront_web_routing_UriPart::UPOptParam($name));
				}break;
				case 4:
				$seg_eUPOptRParam_1 = $__hx__t->params[1]; $name = $__hx__t->params[0];
				{
					$parts->push(ufront_web_routing_UriPart::UPOptParam($name));
				}break;
				case 5:
				$seg_eUPOptBParam_2 = $__hx__t->params[2]; $seg_eUPOptBParam_1 = $__hx__t->params[1]; $name = $__hx__t->params[0];
				{
					$parts->push(ufront_web_routing_UriPart::UPOptParam($name));
				}break;
				case 8:
				$seg_eUPOptLRest_1 = $__hx__t->params[1]; $name = $__hx__t->params[0];
				{
					$parts->push(ufront_web_routing_UriPart::UPOptRest($name));
					$rest = true;
				}break;
				case 9:
				$seg_eUPOptRRest_1 = $__hx__t->params[1]; $name = $__hx__t->params[0];
				{
					$parts->push(ufront_web_routing_UriPart::UPOptRest($name));
					$rest = true;
				}break;
				case 10:
				$seg_eUPOptBRest_2 = $__hx__t->params[2]; $seg_eUPOptBRest_1 = $__hx__t->params[1]; $name = $__hx__t->params[0];
				{
					$parts->push(ufront_web_routing_UriPart::UPOptRest($name));
					$rest = true;
				}break;
				}
			} else {
				if($i === $last) {
					$__hx__t = ($seg);
					switch($__hx__t->index) {
					case 0:
					case 1:
					{
						$parts->push($seg);
						$optional = false;
					}break;
					case 6:
					{
						$parts->push($seg);
						$optional = false;
						$rest = true;
					}break;
					case 2:
					{
						$parts->push($seg);
					}break;
					case 7:
					{
						$parts->push($seg);
						$rest = true;
					}break;
					case 3:
					$left = $__hx__t->params[1]; $name = $__hx__t->params[0];
					{
						if(null === $left) {
							$parts->push(ufront_web_routing_UriPart::UPOptParam($name));
						} else {
							$parts->push($seg);
						}
					}break;
					case 8:
					$left = $__hx__t->params[1]; $name = $__hx__t->params[0];
					{
						if(null === $left) {
							$parts->push(ufront_web_routing_UriPart::UPOptRest($name));
						} else {
							$parts->push($seg);
						}
						$rest = true;
					}break;
					case 4:
					$seg_eUPOptRParam_1 = $__hx__t->params[1]; $name = $__hx__t->params[0];
					{
						$parts->push(ufront_web_routing_UriPart::UPOptParam($name));
					}break;
					case 5:
					$seg_eUPOptBParam_2 = $__hx__t->params[2]; $left = $__hx__t->params[1]; $name = $__hx__t->params[0];
					{
						$parts->push(ufront_web_routing_UriPart::UPOptLParam($name, $left));
					}break;
					case 9:
					$seg_eUPOptRRest_1 = $__hx__t->params[1]; $name = $__hx__t->params[0];
					{
						$parts->push(ufront_web_routing_UriPart::UPOptRest($name));
						$rest = true;
					}break;
					case 10:
					$seg_eUPOptBRest_2 = $__hx__t->params[2]; $left = $__hx__t->params[1]; $name = $__hx__t->params[0];
					{
						$parts->push(ufront_web_routing_UriPart::UPOptLRest($name, $left));
						$rest = true;
					}break;
					}
				} else {
					$__hx__t = ($seg);
					switch($__hx__t->index) {
					case 0:
					$value = $__hx__t->params[0];
					{
						$_g = $stack[$i + 1];
						$__hx__t2 = ($_g);
						switch($__hx__t2->index) {
						case 3:
						$_g_eUPOptLParam_1 = $__hx__t2->params[1]; $name = $__hx__t2->params[0];
						{
							$parts->push(ufront_web_routing_UriPart::UPOptLParam($name, $value));
							$i++;
						}break;
						case 8:
						$_g_eUPOptLRest_1 = $__hx__t2->params[1]; $name = $__hx__t2->params[0];
						{
							$parts->push(ufront_web_routing_UriPart::UPOptLRest($name, $value));
							$i++;
							$rest = true;
						}break;
						case 5:
						$_g_eUPOptBParam_2 = $__hx__t2->params[2]; $_g_eUPOptBParam_1 = $__hx__t2->params[1]; $name = $__hx__t2->params[0];
						{
							$stack[$i + 1] = ufront_web_routing_UriPart::UPOptBParam($name, $value, null);
						}break;
						case 10:
						$_g_eUPOptBRest_2 = $__hx__t2->params[2]; $_g_eUPOptBRest_1 = $__hx__t2->params[1]; $name = $__hx__t2->params[0];
						{
							$stack[$i + 1] = ufront_web_routing_UriPart::UPOptBRest($name, $value, null);
							$rest = true;
						}break;
						case 0:
						case 1:
						case 2:
						case 4:
						{
							$parts->push($seg);
							$optional = false;
						}break;
						case 6:
						case 7:
						case 9:
						{
							$parts->push($seg);
							$optional = false;
							$rest = true;
						}break;
						}
					}break;
					case 1:
					{
						$parts->push($seg);
						$optional = false;
					}break;
					case 6:
					{
						$parts->push($seg);
						$optional = false;
						$rest = true;
					}break;
					case 2:
					{
						$parts->push($seg);
					}break;
					case 7:
					{
						$parts->push($seg);
						$rest = true;
					}break;
					case 3:
					$left = $__hx__t->params[1]; $name = $__hx__t->params[0];
					{
						if(null === $left) {
							$parts->push(ufront_web_routing_UriPart::UPOptParam($name));
						} else {
							$parts->push($seg);
						}
					}break;
					case 4:
					$seg_eUPOptRParam_1 = $__hx__t->params[1]; $name = $__hx__t->params[0];
					{
						$_g = $stack[$i + 1];
						$__hx__t2 = ($_g);
						switch($__hx__t2->index) {
						case 0:
						$value = $__hx__t2->params[0];
						{
							$parts->push(ufront_web_routing_UriPart::UPOptRParam($name, $value));
							$i++;
						}break;
						default:{
							ufront_web_routing_UriPart::UPOptParam($name);
						}break;
						}
					}break;
					case 5:
					$seg_eUPOptBParam_2 = $__hx__t->params[2]; $left = $__hx__t->params[1]; $name = $__hx__t->params[0];
					{
						$_g = $stack[$i + 1];
						$__hx__t2 = ($_g);
						switch($__hx__t2->index) {
						case 0:
						$value = $__hx__t2->params[0];
						{
							$parts->push(ufront_web_routing_UriPart::UPOptBParam($name, $left, $value));
							$i++;
						}break;
						default:{
							ufront_web_routing_UriPart::UPOptLParam($name, $left);
						}break;
						}
					}break;
					case 8:
					$left = $__hx__t->params[1]; $name = $__hx__t->params[0];
					{
						if(null === $left) {
							$parts->push(ufront_web_routing_UriPart::UPOptRest($name));
						} else {
							$parts->push($seg);
						}
						$rest = true;
					}break;
					case 9:
					$seg_eUPOptRRest_1 = $__hx__t->params[1]; $name = $__hx__t->params[0];
					{
						{
							$_g = $stack[$i + 1];
							$__hx__t2 = ($_g);
							switch($__hx__t2->index) {
							case 0:
							$value = $__hx__t2->params[0];
							{
								$parts->push(ufront_web_routing_UriPart::UPOptRRest($name, $value));
								$i++;
							}break;
							default:{
								ufront_web_routing_UriPart::UPOptRest($name);
							}break;
							}
						}
						$rest = true;
					}break;
					case 10:
					$seg_eUPOptBRest_2 = $__hx__t->params[2]; $left = $__hx__t->params[1]; $name = $__hx__t->params[0];
					{
						{
							$_g = $stack[$i + 1];
							$__hx__t2 = ($_g);
							switch($__hx__t2->index) {
							case 0:
							$value = $__hx__t2->params[0];
							{
								$parts->push(ufront_web_routing_UriPart::UPOptBRest($name, $left, $value));
								$i++;
							}break;
							default:{
								ufront_web_routing_UriPart::UPOptLRest($name, $left);
							}break;
							}
						}
						$rest = true;
					}break;
					}
				}
			}
			$i++;
			unset($seg);
		}
		if($parts->length === 0) {
			$optional = false;
		}
		return _hx_anonymous(array("optional" => $optional, "rest" => $rest, "parts" => $parts));
	}
	public function parse($uri, $implicitOptionals) {
		if(null === $uri) {
			throw new HException(new thx_error_NullArgument("uri", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "RouteUriParser.hx", "lineNumber" => 17, "className" => "ufront.web.routing.RouteUriParser", "methodName" => "parse"))));
		}
		$segments = _hx_explode("/", $uri);
		if($segments->length <= 1) {
			throw new HException(new thx_error_Error("a uri must start with a slash", null, null, _hx_anonymous(array("fileName" => "RouteUriParser.hx", "lineNumber" => 20, "className" => "ufront.web.routing.RouteUriParser", "methodName" => "parse"))));
		}
		$strip = $segments->shift();
		if(strlen($strip) > 0) {
			throw new HException(new thx_error_Error("there can't be anything before the first slash", null, null, _hx_anonymous(array("fileName" => "RouteUriParser.hx", "lineNumber" => 24, "className" => "ufront.web.routing.RouteUriParser", "methodName" => "parse"))));
		}
		$this->restUsed = false;
		$capturedParams = new thx_collection_Set();
		$result = new _hx_array(array());
		$segment = null;
		while(null !== ($segment = $segments->shift())) {
			$result->push($this->_parseSegment($segment, $segments, $implicitOptionals, $capturedParams));
		}
		return $result;
	}
	public $restUsed;
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
	static $constPattern;
	static $paramPattern;
	static function reduceRestSegments($segments) {
		if($segments->length === 0) {
			return "";
		}
		$segment = "/" . _hx_string_or_null($segments->join("/"));
		while($segments->length > 0) {
			$segments->pop();
		}
		return $segment;
	}
	function __toString() { return 'ufront.web.routing.RouteUriParser'; }
}
ufront_web_routing_RouteUriParser::$constPattern = new EReg("^([^{]+)", "");
ufront_web_routing_RouteUriParser::$paramPattern = new EReg("^\\{([?\$])?([*])?([a-zA-Z0-9_]+)(\\?)?\\}", "");
