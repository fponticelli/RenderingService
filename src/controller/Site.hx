package controller;

import erazor.macro.Template;
import ufront.web.mvc.Controller;
import ufront.web.mvc.ActionResult;
import ufront.web.mvc.ContentResult;
import ufront.web.mvc.JsonPResult;
import ufront.web.mvc.view.UrlHelper;

class Site extends Controller
{
	public function new()
	{
		super();
	}

	public function contact(?message : String)
	{
		return null == message ? "NO MESSAGE" : "MESSAGE IS: " + message;
	}
}