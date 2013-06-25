<?php

interface ufront_web_mvc_IController {
	function getViewHelpers();
	function execute($requestContext, $async);
}
