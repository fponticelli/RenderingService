package util;

import ufront.web.HttpApplication;
import haxe.PosInfos;
import mongo.Mongo;
import mongo.MongoDB;
import mongo.MongoCollection;
import ufront.web.module.ITraceModule;
using thx.core.Dynamics;

class TraceToMongo implements ITraceModule
{
	var coll(get, null) : MongoCollection;
	var dbname : String;
	var collname : String;
	var servername : String;
	public function new(dbname : String, collname : String, servername : String)
	{
		this.dbname = dbname;
		this.collname = collname;
		this.servername = servername;
	}
	public function init(application : HttpApplication)
	{

	}
	public function trace(msg : Dynamic, ?pos : PosInfos) : Void
	{
		var p ={
			fileName   : pos.fileName,
			className  : pos.className,
			methodName : pos.methodName,
			lineNumber : pos.lineNumber,
		}
		coll.insert({
			msg : Dynamics.string(msg),
			pos : p,
			time : Date.now().getTime(),
			server : servername
		});
	}
	public function dispose()
	{

	}
	function get_coll()
	{
		if(null == coll)
		{
			var m = new Mongo(),
				db = m.selectDB(dbname);
			coll = db.selectCollection(collname);
		}
		return coll;
	}
}