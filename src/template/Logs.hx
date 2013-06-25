package template;

import erazor.macro.Template;
import ufront.web.mvc.view.UrlHelper;

@:includeTemplate("logs.html")
//@:template("<h1>hello world: @title</h1>")
class Logs extends Template
{
	public var baseurl : String;
	public var url : UrlHelperInst;
	public var data : Array<{
		msg : String,
		pos : haxe.PosInfos,
		time : Float,
		server : String
	}>;
}