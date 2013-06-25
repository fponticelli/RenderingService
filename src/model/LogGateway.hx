package model;

import mongo.MongoCollection;
using thx.core.Arrays;

class LogGateway
{
	var coll : MongoCollection;
	public function new(coll : MongoCollection)
	{
		this.coll = coll;
	}

	public function list()
	{
		var list = coll.find({}).sort({time:-1}).toArray();
		list.each(function(el, _){
			Reflect.deleteField(el, "_id");
		});
		return list;
	}

	public function clear()
	{
		coll.remove({});
	}
}