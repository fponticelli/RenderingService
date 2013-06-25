package template;

import erazor.macro.Template;
import ufront.web.mvc.view.UrlHelper;

@:includeTemplate("renderabledisplay.html")
class RenderableDisplay extends Template
{
	public var baseurl : String;
	public var url : UrlHelperInst;
	public var data : RenderableInfo;
	public var milliToString : Float -> Bool -> String;
	public var reflectField : Dynamic -> Dynamic -> Dynamic;
}

typedef RenderableInfo = {
	uid   : String,
	createdOn : Date,
	expiresOn : Null<Date>,
	cacheExpirationTime : Float,
	formats : Array<String>,
	preserveTimeAfterLastUsage : Float,
	service : {
		?pdf  : String,
		?ps   : String,
		?png  : String,
		?jpg  : String,
		?html : String,
		?svg  : String,
		?bmp  : String,
		?tif  : String
	}
}