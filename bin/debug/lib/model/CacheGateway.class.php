<?php

class model_CacheGateway {
	public function __construct($coll) {
		if(!php_Boot::$skip_constructor) {
		$this->coll = $coll;
	}}
	public function loadContent($id, $format, $params) {
		$uid = $this->key($id, $format, $params);
		$o = $this->coll->findOne(_hx_anonymous(array("uid" => $uid)), _hx_anonymous(array("content" => true)));
		if(null === $o) {
			return null;
		}
		return $o->content;
	}
	public function removeExpired() {
		$now = Date::now()->getTime();
		return $this->coll->remove(_hx_anonymous(array("expiresOn" => _hx_anonymous(array("\$lt" => $now)))), null);
	}
	public function expired() {
		$now = Date::now()->getTime();
		return $this->coll->find(_hx_anonymous(array("expiresOn" => _hx_anonymous(array("\$lt" => $now)))), _hx_anonymous(array("uid" => true)));
	}
	public function removeAll() {
		return $this->coll->remove(_hx_anonymous(array()), null);
	}
	public function remove($id, $format, $params) {
		$uid = $this->key($id, $format, $params);
		return $this->coll->remove(_hx_anonymous(array("uid" => $uid)), null);
	}
	public function load($id, $format, $params) {
		$uid = $this->key($id, $format, $params);
		$o = $this->coll->findOne(_hx_anonymous(array("uid" => $uid)), null);
		if(null === $o) {
			return null;
		}
		return $o;
	}
	public function insert($id, $format, $params, $content, $expiresOn) {
		$uid = $this->key($id, $format, $params);
		$ob = _hx_anonymous(array("uid" => $uid, "content" => new MongoBinData($content, 2), "expiresOn" => $expiresOn));
		$r = $this->coll->insert($ob, null);
		return $ob;
	}
	public function exists($id, $format, $params) {
		$uid = $this->key($id, $format, $params);
		return null !== $this->coll->findOne(_hx_anonymous(array("uid" => $uid)), _hx_anonymous(array()));
	}
	public function key($id, $format, $params) {
		$ps = new _hx_array(array());
		if(null == $params) throw new HException('null iterable');
		$__hx__it = $params->keys();
		while($__hx__it->hasNext()) {
			$field = $__hx__it->next();
			$ps->push(_hx_string_or_null(rawurlencode($field)) . "=" . _hx_string_or_null(rawurlencode($params->get($field))));
		}
		return "" . _hx_string_or_null($id) . "." . _hx_string_or_null($format) . _hx_string_or_null((model_CacheGateway_0($this, $format, $id, $params, $ps)));
	}
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
	function __toString() { return 'model.CacheGateway'; }
}
function model_CacheGateway_0(&$__hx__this, &$format, &$id, &$params, &$ps) {
	if($ps->length === 0) {
		return "";
	} else {
		return "?" . _hx_string_or_null($ps->join("&"));
	}
}
