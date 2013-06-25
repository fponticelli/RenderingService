<?php

interface thx_data_IDataHandler {
	function comment($s);
	function valueBool($b);
	function valueNull();
	function valueFloat($f);
	function valueInt($i);
	function valueString($s);
	function valueDate($d);
	function arrayEnd();
	function arrayItemEnd();
	function arrayItemStart();
	function arrayStart();
	function objectEnd();
	function objectFieldEnd();
	function objectFieldStart($name);
	function objectStart();
	function end();
	function start();
}
