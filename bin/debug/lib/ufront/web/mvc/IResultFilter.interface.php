<?php

interface ufront_web_mvc_IResultFilter {
	function onResultExecuted($filterContext);
	function onResultExecuting($filterContext);
}
