package template;

import erazor.macro.Template;
import ufront.web.mvc.view.UrlHelper;

@:includeTemplate("gistupload.html")
class GistUpload extends Template
{
	public var baseurl : String;
	public var url : UrlHelperInst;
	public var error : Null<String>;
	public var gistid : String;
}