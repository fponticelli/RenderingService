<?php

class util_TraceToMongo implements ufront_web_module_ITraceModule{
	public function __construct($dbname, $collname, $servername) {
		if(!php_Boot::$skip_constructor) {
		$this->dbname = $dbname;
		$this->collname = $collname;
		$this->servername = $servername;
	}}
	public function get_coll() {
		if(null === $this->coll) {
			$m = new mongo_Mongo(); $db = new mongo_MongoDB($m->m->selectDB($this->dbname));
			$this->coll = new mongo_MongoCollection($db->db->selectCollection($this->collname));
		}
		return $this->coll;
	}
	public function dispose() {
	}
	public function trace($msg, $pos = null) {
		$p = _hx_anonymous(array("fileName" => $pos->fileName, "className" => $pos->className, "methodName" => $pos->methodName, "lineNumber" => $pos->lineNumber));
		$this->get_coll()->insert(_hx_anonymous(array("msg" => thx_core_Dynamics::string($msg), "pos" => $p, "time" => Date::now()->getTime(), "server" => $this->servername)), null);
	}
	public function init($application) {
	}
	public $servername;
	public $collname;
	public $dbname;
	public $coll;
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
	static $__properties__ = array("get_coll" => "get_coll");
	function __toString() { return 'util.TraceToMongo'; }
}
