<?php

interface IMap {
	function keys();
	function remove($k);
	function exists($k);
	function set($k, $v);
	function get($k);
}
