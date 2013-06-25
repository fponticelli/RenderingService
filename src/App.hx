import model.CacheGateway;
import model.RenderableGateway;
import model.ConfigGateway;
import thx.util.Imports;
import thx.util.MacroVersion;
import ufront.web.AppConfiguration;
import ufront.web.mvc.MvcApplication;
import ufront.web.routing.RouteCollection;
import ufront.web.routing.HttpMethodConstraint;
import ufront.web.routing.IRouteConstraint;
import ufront.web.routing.ValuesConstraint;
import mongo.Mongo;
import mongo.MongoDB;
import mongo.MongoCollection;

class App
{
	public static var AUTH = "C74ufsshsPHs"; // random access key
	public static var MONGO_DB_NAME = "renderingservice";
	public static var RENDERABLES_COLLECTION = "renderables";
	public static var CACHE_COLLECTION = "cache";
	public static var CONFIG_COLLECTION = "config";
	public static var LOG_COLLECTION = "log";
	public static var SERVER_HOST = "http://" + untyped __var__("_SERVER", "HTTP_HOST");
	public static var ENV = #if release "release" #else "debug" #end;
	public static var BASE_HOST = SERVER_HOST;
	public static var BASE_PATH = "/renderingservice/" + ENV + "/";
	public static var RESET_CSS = "./css/reset.css";

#if release
	public static var WKPDF = "DISPLAY=:0  /bin/wkhtmltopdf";
	public static var WKIMAGE = "DISPLAY=:0  /bin/wkhtmltoimage";
#else
	public static var WKPDF = "/usr/lib/wkhtmltopdf.app/Contents/MacOS/wkhtmltopdf";
	public static var WKIMAGE = "/usr/lib/wkhtmltoimage.app/Contents/MacOS/wkhtmltoimage";
	public static var LOG_FILE = "./logs.txt";
#end
	public static var version(default, null) : String;

	public static function baseUrl()
		return BASE_HOST;

	static function main()
	{
		App.version = MacroVersion.next();

		var locator = new thx.util.TypeLocator();
		locator.memoize(model.WKHtmlToImage, function() {
			return new model.WKHtmlToImage(WKIMAGE);
		});
		locator.memoize(model.WKHtmlToPdf, function() {
			return new model.WKHtmlToPdf(WKPDF);
		});
		locator.memoize(Mongo, function() {
			return new Mongo();
		});
		locator.memoize(MongoDB, function() {
			return locator.get(Mongo).selectDB(MONGO_DB_NAME);
		});
		locator.memoize(RenderableGateway, function() {
			return new RenderableGateway(locator.get(MongoDB).selectCollection(RENDERABLES_COLLECTION));
		});
		locator.memoize(CacheGateway, function() {
			return new CacheGateway(locator.get(MongoDB).selectCollection(CACHE_COLLECTION));
		});
		locator.memoize(ConfigGateway, function() {
			return new ConfigGateway(locator.get(MongoDB).selectCollection(CONFIG_COLLECTION));
		});

		ufront.web.mvc.DependencyResolver.current = new ufront.external.mvc.ThxDependencyResolver(locator);

		Imports.pack("controller", true);

		var config = new AppConfiguration(
				"controller",
				true, // mod rewrite
				BASE_PATH,
#if release
				true // disable browser trace
#else
				false
#end
			),
			routes = new RouteCollection(),
			app    = new MvcApplication(config, routes);

		app.modules.add(new util.TraceToMongo(MONGO_DB_NAME, LOG_COLLECTION, serverName()));

		routes.addRoute("/contact/{?message}", {controller:"site", action:"contact"});

		routes.addRoute('/', {
			controller : "home", action : "index"
		});

		routes.addRoute('/up/form/html', {
			controller : "uploadForm", action : "display"
		});

		routes.addRoute('/up/form/gist', {
			controller : "uploadForm", action : "gist"
		});

		routes.addRoute('/up.{outputformat}', {
				controller : "renderableAPI", action : "upload"
			},
			[
				cast(new ValuesConstraint("outputformat", ["json", "html"]), IRouteConstraint),
				new HttpMethodConstraint("POST")
			]
		);

		routes.addRoute('/upandsee.{ext}', {
				controller : "renderableAPI", action : "uploadAndDisplay"
			},
			[
				cast(new HttpMethodConstraint("POST"), IRouteConstraint)
			]
		);

		routes.addRoute('/up/gist/{gistid}.{outputformat}', {
				controller : "gistUpload", action : "importGist"
			},
			[
				cast(new ValuesConstraint("outputformat", ["json", "html"]), IRouteConstraint)
			]
		);
		routes.addRoute('/up/url.{outputformat}', {
				controller : "renderableAPI", action : "uploadFromUrl"
			},
			[
				cast(new ValuesConstraint("outputformat", ["json", "html"]), IRouteConstraint)
			]
		);
		routes.addRoute('/up/info/{uid}.{outputformat}', {
				controller : "renderableAPI", action : "display"
			},
			[
				cast(new ValuesConstraint("outputformat", ["json", "html"]), IRouteConstraint)
			]
		);

		routes.addRoute('/down/{uid}.{ext}', {
			controller : "downloadAPI", action : "download"
		});

		// this should run only on localhost
		routes.addRoute('/status/info', {
			controller : "setup", action : "info"
		});
		routes.addRoute('/status/db', {
			controller : "setup", action : "mongodb"
		});
		routes.addRoute('/status/renderables', {
			controller : "setup", action : "topRenderables"
		});
		routes.addRoute('/maintenance/renderables/purge/unused', {
			controller : "setup", action : "purgeRenderables"
		});
		routes.addRoute('/maintenance/renderables/purge/expired', {
			controller : "setup", action : "purgeExpiredRenderables"
		});
		routes.addRoute('/maintenance/cache/purge', {
			controller : "setup", action : "purgeCache"
		});
		routes.addRoute('/maintenance/cache/clear', {
			controller : "setup", action : "clearCache"
		});

		routes.addRoute('/maintenance/logs/clear', {
			controller : "setup", action : "clearLogs"
		});
		routes.addRoute('/maintenance/logs.{format}', {
				controller : "setup", action : "displayLogs"
			},
			[
				cast(new ValuesConstraint("outputformat", ["json", "html"]), IRouteConstraint)
			]
		);

		routes.addRoute('/setup/collections/create', {
			controller : "setup", action : "createCollections"
		});
		routes.addRoute('/setup/collections/drop', {
			controller : "setup", action : "dropCollections"
		});
		routes.addRoute('/setup/renderables/drop', {
			controller : "setup", action : "dropRenderables"
		});
		routes.addRoute('/setup/cache/drop', {
			controller : "setup", action : "dropCache"
		});

		app.execute();
	}

	static function serverName() : String
	{
		return untyped __php__("trim(`hostname -f`)");
	}
}