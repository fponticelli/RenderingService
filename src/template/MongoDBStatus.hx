package template;

import erazor.macro.Template;
import ufront.web.mvc.view.UrlHelper;

@:includeTemplate("mongodb.html")
class MongoDBStatus extends Template
{
	public var baseurl : String;
	public var url : UrlHelperInst;
	public var db : {
		name    : String,
		collections : Array<String>
	};
	public var renderables : {
		name    : String,
		exists : Bool,
		count   : Int
	};
	public var cache : {
		name    : String,
		exists : Bool,
		count   : Int
	};
	public var config : {
		name    : String,
		exists : Bool,
		count   : Int
	};
	public var logs : {
		name    : String,
		exists : Bool,
		count   : Int
	};
}