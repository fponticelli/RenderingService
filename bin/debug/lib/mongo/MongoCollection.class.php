<?php

class mongo_MongoCollection {
	public function __construct($c) {
		if(!php_Boot::$skip_constructor) {
		$this->c = $c;
	}}
	public function count() {
		return $this->c->count();
	}
	public function drop() {
		$this->c->drop();
	}
	public function find($criteria, $fields = null) {
		$r = null;
		if(null === $fields) {
			$r = $this->c->find(php_Lib::associativeArrayOfObject($criteria));
		} else {
			$r = $this->c->find(php_Lib::associativeArrayOfObject($criteria), php_Lib::associativeArrayOfObject($fields));
		}
		return new mongo_MongoCursor($r);
	}
	public function findOne($criteria, $fields = null) {
		$r = null;
		if(null === $fields) {
			$r = $this->c->findOne(php_Lib::associativeArrayOfObject($criteria));
		} else {
			$r = $this->c->findOne(php_Lib::associativeArrayOfObject($criteria), php_Lib::associativeArrayOfObject($fields));
		}
		if(null === $r) {
			return null;
		} else {
			return php_Lib::objectOfAssociativeArray($r);
		}
	}
	public function update($criteria, $newob, $options = null) {
		if(null !== $options) {
			return $this->c->update(php_Lib::associativeArrayOfObject($criteria), php_Lib::associativeArrayOfObject($newob), php_Lib::associativeArrayOfObject($options));
		} else {
			return $this->c->update(php_Lib::associativeArrayOfObject($criteria), php_Lib::associativeArrayOfObject($newob));
		}
	}
	public function remove($criteria, $options = null) {
		if(null !== $options) {
			return $this->c->remove(php_Lib::associativeArrayOfObject($criteria), php_Lib::associativeArrayOfObject($options));
		} else {
			return $this->c->remove(php_Lib::associativeArrayOfObject($criteria));
		}
	}
	public function insert($data, $options = null) {
		if(null !== $options) {
			return $this->c->insert(php_Lib::associativeArrayOfObject($data), php_Lib::associativeArrayOfObject($options));
		} else {
			return $this->c->insert(php_Lib::associativeArrayOfObject($data));
		}
	}
	public function ensureIndexOn($key, $options = null) {
		if(null !== $options) {
			return $this->c->ensureIndex($key, php_Lib::associativeArrayOfObject($options));
		} else {
			return $this->c->ensureIndex($key);
		}
	}
	public function ensureIndex($keys, $options = null) {
		if(null !== $options) {
			return $this->c->ensureIndex(php_Lib::associativeArrayOfObject($keys), php_Lib::associativeArrayOfObject($options));
		} else {
			return $this->c->ensureIndex(php_Lib::associativeArrayOfObject($keys));
		}
	}
	public function validate() {
		return php_Lib::objectOfAssociativeArray($this->c->validate());
	}
	public $c;
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
	function __toString() { return 'mongo.MongoCollection'; }
}
