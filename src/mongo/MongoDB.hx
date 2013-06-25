package mongo;

import mongo._Mongo;
using php.Lib;

class MongoDB
{
	var db : _MongoDB;
	public function new(db : _MongoDB)
	{
		this.db = db;
	}

	public inline function listCollections() : Array<String>
	{
		return cast db.listCollections().toHaxeArray();
	}

	public inline function selectCollection(name : String)
	{
		return new MongoCollection(db.selectCollection(name));
	}

	public inline function createCollection(name : String)
	{
		return new MongoCollection(db.createCollection(name));
	}
}