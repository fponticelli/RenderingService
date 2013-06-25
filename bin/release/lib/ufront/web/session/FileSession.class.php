<?php

class ufront_web_session_FileSession {
	public function __construct(){}
	static function create($savePath) {
		return new php_ufront_web_FileSession($savePath, null);
	}
	function __toString() { return 'ufront.web.session.FileSession'; }
}
