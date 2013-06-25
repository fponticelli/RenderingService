package mongo;

import mongo._Mongo;
import php.Lib; using php.Lib;

class MongoCursor
{
	var c : _MongoCursor;
	public function new(c : _MongoCursor)
	{
		this.c = c;
	}
	public function getNext() return c.getNext().objectOfAssociativeArray();
	public function hasNext() : Bool return c.hasNext();

	public function sort(fields : Dynamic<Int>)
	{
		c.sort(Lib.associativeArrayOfObject(fields));
		return this;
	}

	public function limit(num : Int)
	{
		c.limit(num);
		return this;
	}

	public function toArray()
	{
		var r = [];
		while(hasNext())
			r.push(getNext());
		return r;
	}
}