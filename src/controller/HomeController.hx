package controller;
import model.ConfigGateway;
import ufront.web.mvc.Controller;
import ufront.web.mvc.ContentResult;
using util.Erazors;

class HomeController extends Controller
{
    var config : ConfigGateway;
	public function new(config : ConfigGateway)
	{
		super();
        this.config = config;
	}
    public function index(?auth : String)
    {
        return new ContentResult(new template.Home().apply({
        	baseurl : App.baseUrl(),
        	url : new ufront.web.mvc.view.UrlHelper.UrlHelperInst(controllerContext.requestContext),
            sampleuid : config.getSampleUID(),
            version : App.version,
            authorized : App.AUTH == auth,
            auth : auth
        }).execute());
    }
}