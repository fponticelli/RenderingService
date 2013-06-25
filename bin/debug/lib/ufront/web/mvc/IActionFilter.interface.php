<?php

interface ufront_web_mvc_IActionFilter {
	function onActionExecuted($filterContext);
	function onActionExecuting($filterContext);
}
