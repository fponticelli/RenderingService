<?php

interface ufront_web_mvc_IControllerFactory {
	function releaseController($controller);
	function createController($requestContext, $controllerName);
}
