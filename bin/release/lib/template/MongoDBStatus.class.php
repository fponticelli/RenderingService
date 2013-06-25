<?php

class template_MongoDBStatus extends erazor_macro_Template {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function execute() {
		$__b__ = new StringBuf();
		{
			$__b__->add("<!DOCTYPE html>\x0A<html>\x0A<head>\x0A  <title>MongoDB Status and Setup</title>\x0A  <link rel=\"stylesheet\" type=\"text/css\" href=\"");
			$__b__->add($this->baseurl);
			$__b__->add($this->url->base("css/style.css"));
			$__b__->add("\">\x0A</head>\x0A<body>\x0A<h1>MongoDB Status and Setup</h1>\x0A<div>\x0A  <h2>DB</h2>\x0A  <dl>\x0A    <dt>name:</dt>\x0A    <dd>");
			$__b__->add($this->db->name);
			$__b__->add("</dd>\x0A    <dt>collections:</dt>\x0A    <dd>");
			$__b__->add($this->db->collections->join(", "));
			$__b__->add("</dd>\x0A  </dl>\x0A  <h2>Renderables</h2>\x0A  <dl>\x0A    <dt>collection name:</dt>\x0A    <dd>");
			$__b__->add($this->renderables->name);
			$__b__->add("</dd>\x0A    <dt>exists:</dt>\x0A    <dd>");
			$__b__->add($this->renderables->exists);
			$__b__->add("</dd>\x0A    <dt>renderables:</dt>\x0A    <dd>");
			$__b__->add($this->renderables->count);
			$__b__->add("</dd>\x0A  </dl>\x0A  <h2>Cache</h2>\x0A  <dl>\x0A    <dt>collection name:</dt>\x0A    <dd>");
			$__b__->add($this->cache->name);
			$__b__->add("</dd>\x0A    <dt>exists:</dt>\x0A    <dd>");
			$__b__->add($this->cache->exists);
			$__b__->add("</dd>\x0A    <dt>cached values:</dt>\x0A    <dd>");
			$__b__->add($this->cache->count);
			$__b__->add("</dd>\x0A  </dl>\x0A  <h2>Config</h2>\x0A  <dl>\x0A    <dt>collection name:</dt>\x0A    <dd>");
			$__b__->add($this->config->name);
			$__b__->add("</dd>\x0A    <dt>exists:</dt>\x0A    <dd>");
			$__b__->add($this->config->exists);
			$__b__->add("</dd>\x0A    <dt>config parameters count:</dt>\x0A    <dd>");
			$__b__->add($this->config->count);
			$__b__->add("</dd>\x0A  </dl>  <h2>Logs</h2>\x0A  <dl>\x0A    <dt>collection name:</dt>\x0A    <dd>");
			$__b__->add($this->logs->name);
			$__b__->add("</dd>\x0A    <dt>exists:</dt>\x0A    <dd>");
			$__b__->add($this->logs->exists);
			$__b__->add("</dd>\x0A    <dt>logs count:</dt>\x0A    <dd>");
			$__b__->add($this->logs->count);
			$__b__->add("</dd>\x0A  </dl>\x0A</div>\x0A</body>\x0A</html>");
		}
		return $__b__->b;
	}
	public $logs;
	public $config;
	public $cache;
	public $renderables;
	public $db;
	public $url;
	public $baseurl;
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
	function __toString() { return 'template.MongoDBStatus'; }
}
