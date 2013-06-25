package template;

import erazor.macro.Template;
import ufront.web.mvc.view.UrlHelper;

@:includeTemplate("renderablesinfo.html")
class RenderablesInfo extends Template
{
	public var baseurl : String;
	public var url : UrlHelperInst;
	public var top : Int;
	public var renderables : Array<{
		uid : String,
		createdOn : Float,
		lastUsage : Float,
		usages : Int
	}>;
}