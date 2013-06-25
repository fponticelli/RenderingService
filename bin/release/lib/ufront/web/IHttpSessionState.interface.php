<?php

interface ufront_web_IHttpSessionState {
	function setLifeTime($lifetime);
	function id();
	function remove($name);
	function exists($name);
	function set($name, $value);
	function get($name);
	function clear();
	function dispose();
}
