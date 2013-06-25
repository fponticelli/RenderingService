<?php

class ufront_web_EmptyUploadHandler implements ufront_web_IHttpUploadHandler{
	public function __construct() { 
	}
	public function uploadEnd() {
	}
	public function uploadProgress($bytes, $pos, $len) {
	}
	public function uploadStart($name, $filename) {
	}
	function __toString() { return 'ufront.web.EmptyUploadHandler'; }
}
