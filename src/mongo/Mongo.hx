package mongo;

class Mongo 
{
	var m : _Mongo;
	public function new()
	{
		m = new _Mongo();
	}

	public inline function selectDB(name : String) : MongoDB return new MongoDB(m.selectDB(name));
}