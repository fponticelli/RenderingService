<?php

interface ufront_web_IHttpModule {
	function dispose();
	function init($application);
}
