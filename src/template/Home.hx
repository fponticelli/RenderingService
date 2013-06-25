package template;

import erazor.macro.Template;
import ufront.web.mvc.view.UrlHelper;

@:includeTemplate("home.html")
//@:template("<h1>hello world: @title</h1>")
class Home extends Template
{
	public var baseurl : String;
	public var url : UrlHelperInst;
	public var sampleuid : String;
	public var version : String;
	public var authorized : Bool;
	public var auth : String;
}