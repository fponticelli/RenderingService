<?php

interface ufront_web_IHttpUploadHandler {
	function uploadEnd();
	function uploadProgress($bytes, $pos, $len);
	function uploadStart($name, $filename);
}
