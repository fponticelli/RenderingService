package ufront.web.mvc.view;

/**
 * ...
 * @author Franco Ponticelli
 */

class HashHelper implements IViewHelper
{
	public var hash(default, null) : Map<String, Dynamic>;
	public function new(?dataHash : Map<String, Dynamic>, ?dataObject : Dynamic)
	{
		hash = new Map();
		if (null != dataHash)
		{
			for (key in dataHash.keys())
				hash.set(key, dataHash.get(key));
		}

		if (null != dataObject)
		{
			for (key in Reflect.fields(dataObject))
				hash.set(key, Reflect.field(dataObject, key));
		}
	}

	public function register(data : Map<String, Dynamic>)
	{
		for (key in hash.keys())
			data.set(key, hash.get(key));
	}
}