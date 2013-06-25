<?php

interface ufront_web_mvc_IValueProvider {
	function getValue($key);
	function containsPrefix($prefix);
}
