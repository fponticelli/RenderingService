package model;

import mongo.MongoBinData;
import mongo.MongoCollection;
import thx.collection.HashList;

class CacheGateway
{
	var coll : MongoCollection;
	public function new(coll : MongoCollection)
	{
		this.coll = coll;
	}

	function key(id : String, format : String, params : HashList<String>)
	{
		var ps = [];
		for(field in params.keys())
		{
			ps.push(
				StringTools.urlEncode(field)
				+ "="
				+ StringTools.urlEncode(params.get(field)));
		}
		return '$id.$format${ps.length == 0 ? "" : "?" + ps.join("&") }';
	}

	public function exists(id : String, format : String, params : HashList<String>)
	{
		var uid = key(id, format, params);
		return null != coll.findOne({ uid : uid }, {});
	}

	public function insert(id : String, format : String, params : HashList<String>, content : String, expiresOn : Float)
	{
		var uid = key(id, format, params);
		var ob = {
			uid       : uid,
			content   : MongoBinData.createByteArray(content),
			expiresOn : expiresOn
		};
		// store in mongo
		var r = coll.insert(ob);
		return ob;
	}

	public function load(id : String, format : String, params : HashList<String>)
	{
		var uid = key(id, format, params);
		// load from mongo
		var o : {
			uid       : String,
			content   : mongo._Mongo._MongoBinData,
			expiresOn : Float
		} = coll.findOne({ uid : uid });
		if(null == o)
			return null;
		return o;
	}

	public function remove(id : String, format : String, params : HashList<String>)
	{
		var uid = key(id, format, params);
		return coll.remove({ uid : uid });
	}

	public function removeAll()
	{
		return coll.remove({ });
	}

	public function expired()
	{
		var now = Date.now().getTime();
		return coll.find({ expiresOn : { "$lt" : now }}, { uid : true });
	}

	public function removeExpired()
	{
		var now = Date.now().getTime();
		return coll.remove({ expiresOn : { "$lt" : now }});
	}

	public function loadContent(id : String, format : String, params : HashList<String>)
	{
		var uid = key(id, format, params);
		// load from mongo
		var o : {
			content : String
		} = coll.findOne({ uid : uid }, { content : true });
		if(null == o)
			return null;
		return o.content;
	}
}