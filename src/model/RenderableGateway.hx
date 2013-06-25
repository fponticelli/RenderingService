package model;

import model.Renderable;
import mongo._Mongo;
import mongo.MongoBinData;
import mongo.MongoCollection;

class RenderableGateway
{
	public static var DELETE_IF_NOT_USED_FOR = thx.date.Milli.parse("366 days");
	var coll : MongoCollection;
	public function new(coll : MongoCollection)
	{
		this.coll = coll;
	}

	public function exists(uid : String)
	{
		return null != coll.findOne({ uid : uid }, {});
	}

	public function insert(r : Renderable)
	{
		var ob = {
			uid       : r.uid,
			config    : serialize(r.config),
			createdOn : r.createdOn.getTime(),
			html      : r.html,
			lastUsage : r.lastUsage.getTime(),
			usages    : r.usages,
			expiresOn : null == r.config.duration ? null : Date.now().getTime() + r.config.duration
		};
		// store in mongo
		coll.insert(ob);
	}

	public function load(uid : String)
	{
		// load from mongo
		var o : {
			uid       : String,
			html      : String,
			config    : _MongoBinData,
			createdOn : Float,
			lastUsage : Float,
			usages    : Int,
			expiresOn : Null<Float>
		} = coll.findOne({ uid : uid });
		if(null == o)
			return null;
		return new model.Renderable(
			o.html,
			unserialize(o.config),
			Date.fromTime(o.createdOn),
			Date.fromTime(o.lastUsage),
			o.usages
		);
	}

	public function topByUsage(limit : Int)
	{
		return coll
			.find({}, { uid : true, createdOn : true, lastUsage : true, usages : true })
			.sort({ usages : -1 })
			.limit(limit)
			.toArray();
	}

	public function use(uid : String)
	{
		coll.update({ uid : uid }, {
			'$set' : { lastUsage : Date.now().getTime() },
			'$inc' : { usages : 1 }
		});
	}

	public function removeExpired()
	{
		return coll.remove({ expiresOn : { "$lt" : Date.now().getTime() }});
	}

	public function removeOldAndUnused(?age : Float)
	{
		if(null == age)
			age = DELETE_IF_NOT_USED_FOR;
		var exp = Date.now().getTime() - age;
		return coll.remove({ lastUsage : { "$lt" : exp }});
	}

	static function serialize(o : Dynamic)
	{
		return MongoBinData.createByteArray(php.Lib.serialize(o));
	}

	static function unserialize(s : _MongoBinData) : Dynamic
	{
		return php.Lib.unserialize(s.bin);
	}
}