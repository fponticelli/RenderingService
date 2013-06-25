package mongo;

import mongo._Mongo;

class MongoBinData
{
	public inline static function createByteArray(data : String)
	{
		return new _MongoBinData(data, 2);
	}
}