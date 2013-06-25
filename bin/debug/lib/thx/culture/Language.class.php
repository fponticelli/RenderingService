<?php

class thx_culture_Language extends thx_culture_Info {
	static $languages;
	static function get_languages() {
		if(null === thx_culture_Language::$languages) {
			thx_culture_Language::$languages = new haxe_ds_StringMap();
		}
		return thx_culture_Language::$languages;
	}
	static function get($name) {
		return thx_culture_Language::get_languages()->get(strtolower($name));
	}
	static function names() {
		return thx_culture_Language::get_languages()->keys();
	}
	static function add($language) {
		if(!thx_culture_Language::get_languages()->exists($language->iso2)) {
			thx_culture_Language::get_languages()->set($language->iso2, $language);
		}
	}
	static $__properties__ = array("get_languages" => "get_languages");
	function __toString() { return 'thx.culture.Language'; }
}
