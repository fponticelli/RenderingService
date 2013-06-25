<?php

class thx_core_Dates {
	public function __construct(){}
	static function format($d, $param = null, $params = null, $culture = null) {
		return call_user_func_array(thx_core_Dates::formatf($param, $params, $culture), array($d));
	}
	static function formatf($param = null, $params = null, $culture = null) {
		$params = thx_culture_FormatParams::params($param, $params, "D");
		$format = $params->shift();
		switch($format) {
		case "D":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Dates_0"), 'execute');
		}break;
		case "DS":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Dates_1"), 'execute');
		}break;
		case "DST":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Dates_2"), 'execute');
		}break;
		case "DSTS":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Dates_3"), 'execute');
		}break;
		case "DTS":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Dates_4"), 'execute');
		}break;
		case "Y":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Dates_5"), 'execute');
		}break;
		case "YM":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Dates_6"), 'execute');
		}break;
		case "M":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Dates_7"), 'execute');
		}break;
		case "MN":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Dates_8"), 'execute');
		}break;
		case "MS":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Dates_9"), 'execute');
		}break;
		case "MD":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Dates_10"), 'execute');
		}break;
		case "WD":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Dates_11"), 'execute');
		}break;
		case "WDN":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Dates_12"), 'execute');
		}break;
		case "WDS":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Dates_13"), 'execute');
		}break;
		case "R":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Dates_14"), 'execute');
		}break;
		case "DT":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Dates_15"), 'execute');
		}break;
		case "U":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Dates_16"), 'execute');
		}break;
		case "S":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Dates_17"), 'execute');
		}break;
		case "T":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Dates_18"), 'execute');
		}break;
		case "TS":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Dates_19"), 'execute');
		}break;
		case "C":{
			$f = $params[0];
			if(null === $f) {
				return array(new _hx_lambda(array(&$culture, &$f, &$format, &$param, &$params), "thx_core_Dates_20"), 'execute');
			} else {
				return array(new _hx_lambda(array(&$culture, &$f, &$format, &$param, &$params), "thx_core_Dates_21"), 'execute');
			}
		}break;
		default:{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "thx_core_Dates_22"), 'execute');
		}break;
		}
	}
	static function interpolate($f, $a, $b, $equation = null) {
		return call_user_func_array(thx_core_Dates::interpolatef($a, $b, $equation), array($f));
	}
	static function interpolatef($a, $b, $equation = null) {
		$f = thx_core_Floats::interpolatef($a->getTime(), $b->getTime(), $equation);
		return array(new _hx_lambda(array(&$a, &$b, &$equation, &$f), "thx_core_Dates_23"), 'execute');
	}
	static function snap($time, $period, $mode = null) {
		if($mode === null) {
			$mode = 0;
		}
		if($mode < 0) {
			switch($period) {
			case "second":{
				return Math::floor($time / 1000.0) * 1000.0;
			}break;
			case "minute":{
				return Math::floor($time / 60000.0) * 60000.0;
			}break;
			case "hour":{
				return Math::floor($time / 3600000.0) * 3600000.0;
			}break;
			case "day":{
				$d = Date::fromTime($time);
				return _hx_deref(new Date($d->getFullYear(), $d->getMonth(), $d->getDate(), 0, 0, 0))->getTime();
			}break;
			case "week":{
				return Math::floor($time / 604800000.) * 604800000.;
			}break;
			case "month":{
				$d = Date::fromTime($time);
				return _hx_deref(new Date($d->getFullYear(), $d->getMonth(), 1, 0, 0, 0))->getTime();
			}break;
			case "year":{
				$d = Date::fromTime($time);
				return _hx_deref(new Date($d->getFullYear(), 0, 1, 0, 0, 0))->getTime();
			}break;
			default:{
				return 0;
			}break;
			}
		} else {
			if($mode > 0) {
				switch($period) {
				case "second":{
					return Math::ceil($time / 1000.0) * 1000.0;
				}break;
				case "minute":{
					return Math::ceil($time / 60000.0) * 60000.0;
				}break;
				case "hour":{
					return Math::ceil($time / 3600000.0) * 3600000.0;
				}break;
				case "day":{
					$d = Date::fromTime($time);
					return _hx_deref(new Date($d->getFullYear(), $d->getMonth(), $d->getDate() + 1, 0, 0, 0))->getTime();
				}break;
				case "week":{
					return Math::ceil($time / 604800000.) * 604800000.;
				}break;
				case "month":{
					$d = Date::fromTime($time);
					return _hx_deref(new Date($d->getFullYear(), $d->getMonth() + 1, 1, 0, 0, 0))->getTime();
				}break;
				case "year":{
					$d = Date::fromTime($time);
					return _hx_deref(new Date($d->getFullYear() + 1, 0, 1, 0, 0, 0))->getTime();
				}break;
				default:{
					return 0;
				}break;
				}
			} else {
				switch($period) {
				case "second":{
					return Math::round($time / 1000.0) * 1000.0;
				}break;
				case "minute":{
					return Math::round($time / 60000.0) * 60000.0;
				}break;
				case "hour":{
					return Math::round($time / 3600000.0) * 3600000.0;
				}break;
				case "day":{
					$d = Date::fromTime($time); $mod = (($d->getHours() >= 12) ? 1 : 0);
					return _hx_deref(new Date($d->getFullYear(), $d->getMonth(), $d->getDate() + $mod, 0, 0, 0))->getTime();
				}break;
				case "week":{
					return Math::round($time / 604800000.) * 604800000.;
				}break;
				case "month":{
					$d = Date::fromTime($time); $mod = (($d->getDate() > Math::round(DateTools::getMonthDays($d) / 2)) ? 1 : 0);
					return _hx_deref(new Date($d->getFullYear(), $d->getMonth() + $mod, 1, 0, 0, 0))->getTime();
				}break;
				case "year":{
					$d = Date::fromTime($time); $mod = (($time > _hx_deref(new Date($d->getFullYear(), 6, 2, 0, 0, 0))->getTime()) ? 1 : 0);
					return _hx_deref(new Date($d->getFullYear() + $mod, 0, 1, 0, 0, 0))->getTime();
				}break;
				default:{
					return 0;
				}break;
				}
			}
		}
	}
	static function snapToWeekDay($time, $day, $mode = null, $firstDayOfWk = null) {
		if($firstDayOfWk === null) {
			$firstDayOfWk = 0;
		}
		if($mode === null) {
			$mode = 0;
		}
		$d = Date::fromTime($time)->getDay();
		$s = thx_core_Dates_24($d, $day, $firstDayOfWk, $mode, $time);
		if($mode < 0) {
			if($s > $d) {
				$s = $s - 7;
			}
			return $time - ($d - $s) * 24 * 60 * 60 * 1000;
		} else {
			if($mode > 0) {
				if($s < $d) {
					$s = $s + 7;
				}
				return $time + ($s - $d) * 24 * 60 * 60 * 1000;
			} else {
				if($s < $firstDayOfWk) {
					$s = $s + 7;
				}
				if($d < $firstDayOfWk) {
					$d = $d + 7;
				}
				return $time + ($s - $d) * 24 * 60 * 60 * 1000;
			}
		}
	}
	static function isLeapYear($year) {
		if(_hx_mod($year, 4) !== 0) {
			return false;
		}
		if(_hx_mod($year, 100) === 0) {
			return _hx_mod($year, 400) === 0;
		}
		return true;
	}
	static function isInLeapYear($d) {
		return thx_core_Dates::isLeapYear($d->getFullYear());
	}
	static function numDaysInMonth($month, $year) {
		return thx_core_Dates_25($month, $year);
	}
	static function numDaysInThisMonth($d) {
		return thx_core_Dates::numDaysInMonth($d->getMonth(), $d->getFullYear());
	}
	static function deltaSec($d, $numSec) {
		return Date::fromTime($d->getTime() + $numSec * 1000);
	}
	static function deltaMin($d, $numMin) {
		return Date::fromTime($d->getTime() + $numMin * 60 * 1000);
	}
	static function deltaHour($d, $numHrs) {
		return Date::fromTime($d->getTime() + $numHrs * 60 * 60 * 1000);
	}
	static function deltaDay($d, $numDays) {
		return Date::fromTime($d->getTime() + $numDays * 24 * 60 * 60 * 1000);
	}
	static function deltaWeek($d, $numWks) {
		return Date::fromTime($d->getTime() + $numWks * 7 * 24 * 60 * 60 * 1000);
	}
	static function deltaMonth($d, $numMonths) {
		$newM = $d->getMonth() + $numMonths;
		$newY = $d->getFullYear();
		while($newM > 11) {
			$newM = $newM - 12;
			$newY++;
		}
		while($newM < 0) {
			$newM = $newM + 12;
			$newY--;
		}
		return new Date($newY, $newM, $d->getDate(), $d->getHours(), $d->getMinutes(), $d->getSeconds());
	}
	static function deltaYear($d, $numYrs) {
		$newY = $d->getFullYear() + $numYrs;
		return new Date($newY, $d->getMonth(), $d->getDate(), $d->getHours(), $d->getMinutes(), $d->getSeconds());
	}
	static function prevYear($d) {
		return thx_core_Dates::deltaYear($d, -1);
	}
	static function nextYear($d) {
		return thx_core_Dates::deltaYear($d, 1);
	}
	static function prevMonth($d) {
		return thx_core_Dates::deltaMonth($d, -1);
	}
	static function nextMonth($d) {
		return thx_core_Dates::deltaMonth($d, 1);
	}
	static function prevWeek($d) {
		return Date::fromTime($d->getTime() + -604800000);
	}
	static function nextWeek($d) {
		return Date::fromTime($d->getTime() + 604800000);
	}
	static function prevDay($d) {
		return Date::fromTime($d->getTime() + -86400000);
	}
	static function nextDay($d) {
		return Date::fromTime($d->getTime() + 86400000);
	}
	static $_reparse;
	static function canParse($s) {
		return thx_core_Dates::$_reparse->match($s);
	}
	static function parse($s) {
		$parts = _hx_explode(".", $s);
		$date = Date::fromString(thx_core_Dates_26($parts, $s));
		if($parts->length > 1) {
			$date = Date::fromTime($date->getTime() + Std::parseInt($parts[1]));
		}
		return $date;
	}
	static function compare($a, $b) {
		return thx_core_Dates_27($a, $b);
	}
	function __toString() { return 'thx.core.Dates'; }
}
thx_core_Dates::$_reparse = new EReg("^\\d{4}-\\d\\d-\\d\\d(( |T)\\d\\d:\\d\\d(:\\d\\d(\\.\\d{1,3})?)?)?Z?\$", "");
function thx_core_Dates_0(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::date($d, $culture);
	}
}
function thx_core_Dates_1(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::dateShort($d, $culture);
	}
}
function thx_core_Dates_2(&$culture, &$format, &$param, &$params, $d) {
	{
		return _hx_string_or_null(thx_culture_FormatDate::dateShort($d, $culture)) . " " . _hx_string_or_null(thx_culture_FormatDate::time($d, $culture));
	}
}
function thx_core_Dates_3(&$culture, &$format, &$param, &$params, $d) {
	{
		return _hx_string_or_null(thx_culture_FormatDate::dateShort($d, $culture)) . " " . _hx_string_or_null(thx_culture_FormatDate::timeShort($d, $culture));
	}
}
function thx_core_Dates_4(&$culture, &$format, &$param, &$params, $d) {
	{
		return _hx_string_or_null(thx_culture_FormatDate::date($d, $culture)) . " " . _hx_string_or_null(thx_culture_FormatDate::timeShort($d, $culture));
	}
}
function thx_core_Dates_5(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::year($d, $culture);
	}
}
function thx_core_Dates_6(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::yearMonth($d, $culture);
	}
}
function thx_core_Dates_7(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::month($d, $culture);
	}
}
function thx_core_Dates_8(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::monthName($d, $culture);
	}
}
function thx_core_Dates_9(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::monthNameShort($d, $culture);
	}
}
function thx_core_Dates_10(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::monthDay($d, $culture);
	}
}
function thx_core_Dates_11(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::weekDay($d, $culture);
	}
}
function thx_core_Dates_12(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::weekDayName($d, $culture);
	}
}
function thx_core_Dates_13(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::weekDayNameShort($d, $culture);
	}
}
function thx_core_Dates_14(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::dateRfc($d, $culture);
	}
}
function thx_core_Dates_15(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::dateTime($d, $culture);
	}
}
function thx_core_Dates_16(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::universal($d, $culture);
	}
}
function thx_core_Dates_17(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::sortable($d, $culture);
	}
}
function thx_core_Dates_18(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::time($d, $culture);
	}
}
function thx_core_Dates_19(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::timeShort($d, $culture);
	}
}
function thx_core_Dates_20(&$culture, &$f, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::date($d, $culture);
	}
}
function thx_core_Dates_21(&$culture, &$f, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::format($d, $f, $culture, thx_core_Dates_28($culture, $d, $f, $format, $param, $params));
	}
}
function thx_core_Dates_22(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::format($d, $format, $culture, thx_core_Dates_29($culture, $d, $format, $param, $params));
	}
}
function thx_core_Dates_23(&$a, &$b, &$equation, &$f, $v) {
	{
		return Date::fromTime(call_user_func_array($f, array($v)));
	}
}
function thx_core_Dates_24(&$d, &$day, &$firstDayOfWk, &$mode, &$time) {
	{
		$_g = strtolower($day);
		switch($_g) {
		case "sunday":{
			return 0;
		}break;
		case "monday":{
			return 1;
		}break;
		case "tuesday":{
			return 2;
		}break;
		case "wednesday":{
			return 3;
		}break;
		case "thursday":{
			return 4;
		}break;
		case "friday":{
			return 5;
		}break;
		case "saturday":{
			return 6;
		}break;
		default:{
			throw new HException(new thx_error_Error("unknown week day '{0}'", null, $day, _hx_anonymous(array("fileName" => "Dates.hx", "lineNumber" => 245, "className" => "thx.core.Dates", "methodName" => "snapToWeekDay"))));
			return -1;
		}break;
		}
		unset($_g);
	}
}
function thx_core_Dates_25(&$month, &$year) {
	switch($month) {
	case 0:case 2:case 4:case 6:case 7:case 9:case 11:{
		return 31;
	}break;
	case 3:case 5:case 8:case 10:{
		return 30;
	}break;
	case 1:{
		if(thx_core_Dates::isLeapYear($year)) {
			return 29;
		} else {
			return 28;
		}
	}break;
	default:{
		throw new HException(new thx_error_Error("Invalid month '{0}'.  Month should be a number, Jan=0, Dec=11", null, $month, _hx_anonymous(array("fileName" => "Dates.hx", "lineNumber" => 312, "className" => "thx.core.Dates", "methodName" => "numDaysInMonth"))));
		return 0;
	}break;
	}
}
function thx_core_Dates_26(&$parts, &$s) {
	{
		$s1 = $parts[0];
		return str_replace("T", " ", $s1);
	}
}
function thx_core_Dates_27(&$a, &$b) {
	{
		$a1 = $a->getTime(); $b1 = $b->getTime();
		if($a1 < $b1) {
			return -1;
		} else {
			if($a1 > $b1) {
				return 1;
			} else {
				return 0;
			}
		}
		unset($b1,$a1);
	}
}
function thx_core_Dates_28(&$culture, &$d, &$f, &$format, &$param, &$params) {
	if($params[1] !== null) {
		return $params[1] === "true";
	} else {
		return true;
	}
}
function thx_core_Dates_29(&$culture, &$d, &$format, &$param, &$params) {
	if($params[0] !== null) {
		return $params[0] === "true";
	} else {
		return true;
	}
}
