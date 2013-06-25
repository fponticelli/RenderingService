<?php

class mongo_MongoDB {
	public function __construct($db) {
		if(!php_Boot::$skip_constructor) {
		$this->db = $db;
	}}
	public function createCollection($name) {
		return new mongo_MongoCollection($this->db->createCollection($name));
	}
	public function selectCollection($name) {
		return new mongo_MongoCollection($this->db->selectCollection($name));
	}
	public function listCollections() {
		return new _hx_array($this->db->listCollections());
	}
	public $db;
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
	function __toString() { return 'mongo.MongoDB'; }
}
