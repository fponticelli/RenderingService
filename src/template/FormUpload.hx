package template;

import erazor.macro.Template;
import ufront.web.mvc.view.UrlHelper;

@:includeTemplate("formupload.html")
class FormUpload extends Template
{
	public var baseurl : String;
	public var url : UrlHelperInst;
	public var html : String;
	public var config : String;
	public var errors : Map<String, String>;
	public var displayFormat : String;
}