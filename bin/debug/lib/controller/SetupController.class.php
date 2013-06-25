<?php

class controller_SetupController extends controller_BaseController {
	public function __construct($mongo) {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
		$this->mongo = $mongo;
	}}
	public function collectPhpInfo() {
		ob_start();
		phpinfo();
		return ob_get_clean();
	}
	public function info() {
		return $this->collectPhpInfo();
	}
	public function purgeExpiredRenderables($auth) {
		$this->authorize($auth);
		$gate = new model_RenderableGateway($this->renderableCollection()); $purged = $gate->removeExpired();
		return $this->redirectToHome($auth);
	}
	public function purgeRenderables($auth) {
		$this->authorize($auth);
		$gate = new model_RenderableGateway($this->renderableCollection()); $purged = $gate->removeOldAndUnused(null);
		return $this->redirectToHome($auth);
	}
	public function clearCache($auth) {
		$this->authorize($auth);
		$gate = new model_CacheGateway($this->cacheCollection()); $purged = $gate->removeAll();
		return $this->redirectToHome($auth);
	}
	public function purgeCache($auth) {
		$this->authorize($auth);
		$gate = new model_CacheGateway($this->cacheCollection()); $purged = $gate->removeExpired();
		return $this->redirectToHome($auth);
	}
	public function purge($auth) {
		$this->authorize($auth);
		$gate = new model_CacheGateway($this->cacheCollection());
		$gate->removeExpired();
		$gate1 = new model_RenderableGateway($this->renderableCollection());
		$gate1->removeOldAndUnused(null);
		return $this->redirectToHome($auth);
	}
	public function topRenderables($auth, $top = null) {
		if($top === null) {
			$top = 10;
		}
		$this->authorize($auth);
		$gate = new model_RenderableGateway($this->renderableCollection()); $list = $gate->topByUsage($top); $content = _hx_anonymous(array("baseurl" => App::baseUrl(), "url" => new ufront_web_mvc_view_UrlHelperInst($this->controllerContext->requestContext), "top" => $top, "renderables" => $list));
		return new ufront_web_mvc_ContentResult(util_Erazors::apply(new template_RenderablesInfo(), $content)->execute(), null);
	}
	public function mongodb($auth) {
		$this->authorize($auth);
		$dbname = App::$MONGO_DB_NAME; $db = new mongo_MongoDB($this->mongo->m->selectDB($dbname)); $cacheCollections = new _hx_array($db->db->listCollections()); $renderablesExists = true; $cacheExists = true; $configExists = true; $logExists = true;
		$renderableCollection = new mongo_MongoCollection($db->db->selectCollection(App::$RENDERABLES_COLLECTION));
		if(php_Lib::objectOfAssociativeArray($renderableCollection->c->validate())->ok < 1) {
			$renderablesExists = false;
		}
		$cacheCollection = new mongo_MongoCollection($db->db->selectCollection(App::$CACHE_COLLECTION));
		if(php_Lib::objectOfAssociativeArray($cacheCollection->c->validate())->ok < 1) {
			$cacheExists = false;
		}
		$configCollection = new mongo_MongoCollection($db->db->selectCollection(App::$CONFIG_COLLECTION));
		if(php_Lib::objectOfAssociativeArray($configCollection->c->validate())->ok < 1) {
			$configExists = false;
		}
		$logCollection = new mongo_MongoCollection($db->db->selectCollection(App::$LOG_COLLECTION));
		if(php_Lib::objectOfAssociativeArray($logCollection->c->validate())->ok < 1) {
			$logExists = false;
		}
		$content = _hx_anonymous(array("baseurl" => App::baseUrl(), "url" => new ufront_web_mvc_view_UrlHelperInst($this->controllerContext->requestContext), "db" => _hx_anonymous(array("name" => $dbname, "collections" => $cacheCollections)), "renderables" => _hx_anonymous(array("name" => App::$RENDERABLES_COLLECTION, "exists" => $renderablesExists, "count" => (($renderablesExists) ? $renderableCollection->c->count() : -1))), "cache" => _hx_anonymous(array("name" => App::$CACHE_COLLECTION, "exists" => $cacheExists, "count" => (($cacheExists) ? $cacheCollection->c->count() : -1))), "config" => _hx_anonymous(array("name" => App::$CONFIG_COLLECTION, "exists" => $configExists, "count" => (($configExists) ? $configCollection->c->count() : -1))), "logs" => _hx_anonymous(array("name" => App::$LOG_COLLECTION, "exists" => $logExists, "count" => (($logExists) ? $logCollection->c->count() : -1)))));
		return new ufront_web_mvc_ContentResult(util_Erazors::apply(new template_MongoDBStatus(), $content)->execute(), null);
	}
	public function createCollections($auth) {
		$this->authorize($auth);
		$dbname = App::$MONGO_DB_NAME; $db = new mongo_MongoDB($this->mongo->m->selectDB($dbname)); $cacheCollections = new _hx_array($db->db->listCollections());
		$renderableCollection = new mongo_MongoCollection($db->db->selectCollection(App::$RENDERABLES_COLLECTION));
		if(php_Lib::objectOfAssociativeArray($renderableCollection->c->validate())->ok < 1) {
			$renderableCollection = new mongo_MongoCollection($db->db->createCollection(App::$RENDERABLES_COLLECTION));
			$renderableCollection->ensureIndexOn("uid", _hx_anonymous(array("unique" => true)));
			$renderableCollection->ensureIndexOn("lastUsage", null);
		}
		$cacheCollection = new mongo_MongoCollection($db->db->selectCollection(App::$CACHE_COLLECTION));
		if(php_Lib::objectOfAssociativeArray($cacheCollection->c->validate())->ok < 1) {
			$cacheCollection = new mongo_MongoCollection($db->db->createCollection(App::$CACHE_COLLECTION));
			$cacheCollection->ensureIndexOn("uid", _hx_anonymous(array("unique" => true)));
			$cacheCollection->ensureIndexOn("expiresOn", null);
		}
		$configCollection = new mongo_MongoCollection($db->db->selectCollection(App::$CONFIG_COLLECTION));
		if(php_Lib::objectOfAssociativeArray($configCollection->c->validate())->ok < 1) {
			$configCollection = new mongo_MongoCollection($db->db->createCollection(App::$CONFIG_COLLECTION));
			$configCollection->ensureIndexOn("name", _hx_anonymous(array("unique" => true)));
		}
		$logsCollection = new mongo_MongoCollection($db->db->selectCollection(App::$LOG_COLLECTION));
		if(php_Lib::objectOfAssociativeArray($logsCollection->c->validate())->ok < 1) {
			$logsCollection = new mongo_MongoCollection($db->db->createCollection(App::$LOG_COLLECTION));
		}
		$controller1 = new controller_RenderableAPIController(new model_RenderableGateway($renderableCollection));
		$renderable = $controller1->makeRenderable(model_Sample::$html, model_Sample::$config);
		$config = new model_ConfigGateway($configCollection);
		$config->setSampleUID($renderable->get_uid());
		return $this->redirectToHome($auth);
	}
	public function renderableCollection() {
		$dbname = App::$MONGO_DB_NAME; $db = new mongo_MongoDB($this->mongo->m->selectDB($dbname));
		return new mongo_MongoCollection($db->db->selectCollection(App::$RENDERABLES_COLLECTION));
	}
	public function cacheCollection() {
		$dbname = App::$MONGO_DB_NAME; $db = new mongo_MongoDB($this->mongo->m->selectDB($dbname));
		return new mongo_MongoCollection($db->db->selectCollection(App::$CACHE_COLLECTION));
	}
	public function dropCollection($collection) {
		$db = new mongo_MongoDB($this->mongo->m->selectDB(App::$MONGO_DB_NAME)); $collection1 = new mongo_MongoCollection($db->db->selectCollection($collection));
		$collection1->c->drop();
	}
	public function redirectToHome($auth) {
		$url = _hx_deref(new ufront_web_mvc_view_UrlHelperInst($this->controllerContext->requestContext))->route(_hx_anonymous(array("controller" => "home", "action" => "index", "auth" => $auth)));
		if(_hx_index_of($url, "?", null) > 0) {
			$parts = _hx_explode("?", $url);
			$parts->a[0] .= "/";
			$url = $parts->join("?");
		} else {
			$url .= "/";
		}
		return new ufront_web_mvc_RedirectResult(_hx_string_or_null(App::baseUrl()) . _hx_string_or_null($url), false);
	}
	public function clearLogs($auth) {
		$this->authorize($auth);
		$db = new mongo_MongoDB($this->mongo->m->selectDB(App::$MONGO_DB_NAME)); $gate = new model_LogGateway(new mongo_MongoCollection($db->db->selectCollection(App::$LOG_COLLECTION)));
		$gate->clear();
		return $this->redirectToHome($auth);
	}
	public function displayLogs($auth, $format) {
		$this->authorize($auth);
		$db = new mongo_MongoDB($this->mongo->m->selectDB(App::$MONGO_DB_NAME)); $gate = new model_LogGateway(new mongo_MongoCollection($db->db->selectCollection(App::$LOG_COLLECTION)));
		return $this->output($gate->hlist(), $format, _hx_qtype("template.Logs"));
	}
	public function dropCollections($auth) {
		$this->authorize($auth);
		$this->dropCollection(App::$RENDERABLES_COLLECTION);
		$this->dropCollection(App::$CACHE_COLLECTION);
		$this->dropCollection(App::$CONFIG_COLLECTION);
		$this->dropCollection(App::$LOG_COLLECTION);
		return $this->redirectToHome($auth);
	}
	public function dropCache($auth) {
		$this->authorize($auth);
		$this->dropCollection(App::$CACHE_COLLECTION);
		return $this->redirectToHome($auth);
	}
	public function authorize($auth) {
		if($auth !== App::$AUTH) {
			throw new HException(new ufront_web_error_UnauthorizedError(_hx_anonymous(array("fileName" => "SetupController.hx", "lineNumber" => 34, "className" => "controller.SetupController", "methodName" => "authorize"))));
		}
	}
	public function dropRenderables($auth) {
		$this->authorize($auth);
		$this->dropCollection(App::$RENDERABLES_COLLECTION);
		return $this->redirectToHome($auth);
	}
	public $mongo;
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->__dynamics[$m]) && is_callable($this->__dynamics[$m]))
			return call_user_func_array($this->__dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call <'.$m.'>');
	}
	static $__rtti = "<class path=\"controller.SetupController\" params=\"\">\x0A\x09<extends path=\"controller.BaseController\"/>\x0A\x09<mongo><c path=\"mongo.Mongo\"/></mongo>\x0A\x09<dropRenderables public=\"1\" set=\"method\" line=\"24\"><f a=\"auth\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"ufront.web.mvc.RedirectResult\"/>\x0A</f></dropRenderables>\x0A\x09<authorize set=\"method\" line=\"31\"><f a=\"auth\">\x0A\x09<c path=\"String\"/>\x0A\x09<x path=\"Void\"/>\x0A</f></authorize>\x0A\x09<dropCache public=\"1\" set=\"method\" line=\"37\"><f a=\"auth\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"ufront.web.mvc.RedirectResult\"/>\x0A</f></dropCache>\x0A\x09<dropCollections public=\"1\" set=\"method\" line=\"44\"><f a=\"auth\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"ufront.web.mvc.RedirectResult\"/>\x0A</f></dropCollections>\x0A\x09<displayLogs public=\"1\" set=\"method\" line=\"54\"><f a=\"auth:format\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"ufront.web.mvc.ActionResult\"/>\x0A</f></displayLogs>\x0A\x09<clearLogs public=\"1\" set=\"method\" line=\"62\"><f a=\"auth\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"ufront.web.mvc.RedirectResult\"/>\x0A</f></clearLogs>\x0A\x09<redirectToHome set=\"method\" line=\"71\"><f a=\"auth\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"ufront.web.mvc.RedirectResult\"/>\x0A</f></redirectToHome>\x0A\x09<dropCollection set=\"method\" line=\"85\"><f a=\"collection\">\x0A\x09<c path=\"String\"/>\x0A\x09<x path=\"Void\"/>\x0A</f></dropCollection>\x0A\x09<cacheCollection set=\"method\" line=\"92\"><f a=\"\"><c path=\"mongo.MongoCollection\"/></f></cacheCollection>\x0A\x09<renderableCollection set=\"method\" line=\"99\"><f a=\"\"><c path=\"mongo.MongoCollection\"/></f></renderableCollection>\x0A\x09<createCollections public=\"1\" set=\"method\" line=\"106\"><f a=\"auth\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"ufront.web.mvc.RedirectResult\"/>\x0A</f></createCollections>\x0A\x09<mongodb public=\"1\" set=\"method\" line=\"157\"><f a=\"auth\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"ufront.web.mvc.ContentResult\"/>\x0A</f></mongodb>\x0A\x09<topRenderables public=\"1\" set=\"method\" line=\"230\"><f a=\"auth:?top\">\x0A\x09<c path=\"String\"/>\x0A\x09<x path=\"Int\"/>\x0A\x09<c path=\"ufront.web.mvc.ContentResult\"/>\x0A</f></topRenderables>\x0A\x09<purge public=\"1\" set=\"method\" line=\"244\"><f a=\"auth\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"ufront.web.mvc.RedirectResult\"/>\x0A</f></purge>\x0A\x09<purgeCache public=\"1\" set=\"method\" line=\"254\"><f a=\"auth\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"ufront.web.mvc.RedirectResult\"/>\x0A</f></purgeCache>\x0A\x09<clearCache public=\"1\" set=\"method\" line=\"262\"><f a=\"auth\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"ufront.web.mvc.RedirectResult\"/>\x0A</f></clearCache>\x0A\x09<purgeRenderables public=\"1\" set=\"method\" line=\"270\"><f a=\"auth\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"ufront.web.mvc.RedirectResult\"/>\x0A</f></purgeRenderables>\x0A\x09<purgeExpiredRenderables public=\"1\" set=\"method\" line=\"278\"><f a=\"auth\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"ufront.web.mvc.RedirectResult\"/>\x0A</f></purgeExpiredRenderables>\x0A\x09<info public=\"1\" set=\"method\" line=\"286\"><f a=\"\"><c path=\"String\"/></f></info>\x0A\x09<collectPhpInfo set=\"method\" line=\"291\"><f a=\"\"><c path=\"String\"/></f></collectPhpInfo>\x0A\x09<new public=\"1\" set=\"method\" line=\"18\"><f a=\"mongo\">\x0A\x09<c path=\"mongo.Mongo\"/>\x0A\x09<x path=\"Void\"/>\x0A</f></new>\x0A</class>";
	static $__properties__ = array("get_urlHelper" => "get_urlHelper","set_invoker" => "set_invoker","get_invoker" => "get_invoker","set_valueProvider" => "set_valueProvider","get_valueProvider" => "get_valueProvider");
	function __toString() { return 'controller.SetupController'; }
}
