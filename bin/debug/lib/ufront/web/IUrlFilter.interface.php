<?php

interface ufront_web_IUrlFilter {
	function filterOut($url, $request);
	function filterIn($url, $request);
}
