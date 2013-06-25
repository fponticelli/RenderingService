package model;

import mongo.MongoCollection;

class ConfigGateway
{
	static var SAMPLE_UID = "sample_uid";
	var coll : MongoCollection;
	public function new(coll : MongoCollection)
	{
		this.coll = coll;
	}

	public function setSampleUID(id : String)
	{
		coll.insert({
			name  : SAMPLE_UID,
			value : id
		});
	}

	public function getSampleUID() : Null<String>
	{
		var o = coll.findOne({ name : SAMPLE_UID });
		if(null == o)
			return null;
		else
			return o.value;
	}
}