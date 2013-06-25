package template;

import erazor.macro.Template;
import ufront.web.mvc.view.UrlHelper;

@:includeTemplate("error.html")
class Error extends Template
{
	public var baseurl : String;
	public var url : UrlHelperInst;
	public var data : { error : String };
}