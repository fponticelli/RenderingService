package ufront.web.mvc.view;
import thx.culture.FormatDate;
import thx.culture.FormatNumber;

using thx.core.Dynamics;
using thx.core.Strings;
using thx.core.Dates;
using thx.core.Floats;
using thx.core.Ints;

/**
 * ...
 * @author Franco Ponticelli
 */

class FormatHelper implements IViewHelper
{
	public function new(){}
	
	public function register(data : Map<String, Dynamic>)
	{
		data.set("format", Dynamics.format);
		data.set("pattern", Strings.format);
		data.set("formatDate", Dates.format);
		data.set("formatInt", Ints.format);
		data.set("formatFloat", Floats.format);
/*
		FormatNumber.currency;
		FormatNumber.decimal;
		FormatNumber.digits;
		FormatNumber.int;
		FormatNumber.percent;
		FormatNumber.permille;
		
		FormatDate.dateRfc;
		FormatDate.dateShort;
		FormatDate.dateTime;
		FormatDate.month;
		FormatDate.monthDay;
		FormatDate.monthName;
		FormatDate.monthNameShort;
		FormatDate.sortable;
		FormatDate.time;
		FormatDate.timeShort;
		FormatDate.universal;
		FormatDate.weekDay;
		FormatDate.weekDayName;
		FormatDate.weekDayNameShort;
		FormatDate.year;
		FormatDate.yearMonth;
*/
	}
}