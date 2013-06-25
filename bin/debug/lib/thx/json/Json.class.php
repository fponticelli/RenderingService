<?php

class thx_json_Json {
	public function __construct(){}
	static function nativeEncoder() { $args = func_get_args(); return call_user_func_array(self::$nativeEncoder, $args); }
	static $nativeEncoder;
	static function nativeDecoder() { $args = func_get_args(); return call_user_func_array(self::$nativeDecoder, $args); }
	static $nativeDecoder;
	static function encode($value) {
		if(null !== thx_json_Json::$nativeEncoder) {
			return thx_json_Json::nativeEncoder($value);
		}
		$handler = new thx_json_JsonEncoder();
		_hx_deref(new thx_data_ValueEncoder($handler))->encode($value);
		return $handler->encodedString;
	}
	static function decode($value) {
		if(null !== thx_json_Json::$nativeDecoder) {
			return thx_json_Json::nativeDecoder($value);
		}
		$handler = new thx_data_ValueHandler();
		_hx_deref(new thx_json_JsonDecoder($handler, null))->decode($value);
		return $handler->value;
	}
	function __toString() { return 'thx.json.Json'; }
}
