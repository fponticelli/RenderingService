package controller;
import ufront.web.mvc.ContentResult;
import ufront.web.mvc.Controller;
import ufront.web.mvc.ActionResult;
using util.Erazors;

class UploadForm extends Controller
{
	public function display(?html : String, ?config : String, displayFormat : String = null) : Dynamic
	{
		var ob = {
        	baseurl : App.baseUrl(),
			url : new ufront.web.mvc.view.UrlHelper.UrlHelperInst(controllerContext.requestContext),
			html : html,
			config : config,
			errors : new Map (),
			displayFormat : displayFormat
		};
		if(this.controllerContext.request.httpMethod == "POST")
		{
			var haserrors = false;
			if(null == html || '' == (html = StringTools.trim(html)))
			{
				haserrors = true;
				ob.errors.set("html", "html cannot be left empty");
			}
			if(null != config && config != '')
			{
				config = StringTools.trim(config);
				try {
					thx.ini.Ini.decode(config);
				} catch(e : Dynamic)
				{
					haserrors = true;
					ob.errors.set("config", "the config file is not well formed: " + e);
				}
			}
			if(!haserrors)
			{
				var controller = ufront.web.mvc.DependencyResolver.current.getService(controller.RenderableAPIController);
				controller.controllerContext = this.controllerContext;
				if(null != displayFormat)
				{
					return controller.uploadAndDisplay(html, config, displayFormat);
				} else {
					return controller.upload(html, config, 'html');
				}
			}
		} else {
			if(null == html && null == config)
			{
				ob.html   = model.Sample.html;
				ob.config = model.Sample.config;
			}
		}
		return new ContentResult(new template.FormUpload().apply(ob).execute());
	}

	var lastError : String;
	public function gist(?gistid : String)
	{
		var id = validateGist(gistid);
		if(null != id)
		{
			var controller = ufront.web.mvc.DependencyResolver.current.getService(controller.GistUploadController);
			controller.controllerContext = this.controllerContext;
			return controller.importGist(id, "html");
		} else {
			var ob = {
	        	baseurl : App.baseUrl(),
	        	error : lastError,
				url : new ufront.web.mvc.view.UrlHelper.UrlHelperInst(controllerContext.requestContext),
				gistid : gistid
			};
			return new ContentResult(new template.GistUpload().apply(ob).execute());
		}
	}

	function validateGist(id : String)
	{
		if(null == id || id == '')
			return null;
		if(id.substr(0, 8) == 'https://' || id.substr(0, 7) == 'http://')
			id = id.split("/").pop();
		var des = controller.GistUploadController.getGistDescription(id);
		if(null != des.error)
		{
			lastError = des.error;
			return null;
		}
		else
			return id;
	}
}