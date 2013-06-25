<?php

interface ufront_web_mvc_IViewEngine {
	function releaseView($controllerContext, $view);
	function findView($controllerContext, $viewName);
}
