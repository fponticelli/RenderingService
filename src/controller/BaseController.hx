package controller;

import erazor.macro.Template;
import ufront.web.mvc.Controller;
import ufront.web.mvc.ActionResult;
import ufront.web.mvc.ContentResult;
import ufront.web.mvc.JsonPResult;
import ufront.web.mvc.view.UrlHelper;
using util.Erazors;

class BaseController extends Controller
{
	public var urlHelper(get, null) : UrlHelperInst;
	function get_urlHelper()
	{
		if(null == urlHelper)
		{
			urlHelper = new UrlHelperInst(controllerContext.requestContext);
		}
		return urlHelper;
	}

	function error(message : String, format : String)
	{
		return output({ error : message }, format, template.Error);
	}

	function output<T>(data : T, format : String, templateClass : Class<Dynamic>) : ActionResult
	{
		format = normalizeFormat(format);
		switch (format) {
			case "html":
				var template : Template = Type.createInstance(templateClass, []);
				var content = {
					baseurl : App.baseUrl(),
					url : urlHelper,
					data : data,
					milliToString : thx.date.Milli.toString,
					reflectField : Reflect.field
				};
				return new ContentResult(template.apply(content).execute());
			case "json":
				return JsonPResult.auto(data, controllerContext.request.query.get("callback"));
			default:
				return throw new thx.error.Error("invalid format '{0}'", [format]);
		}
	}

	function normalizeFormat(f : String)
	{
		f = f.toLowerCase();
		return switch(f) {
			case 'html', 'json': f;
			default : 'html';
		}
	}
}