/**
 * ...
 * @author Franco Ponticelli
 */
package thx.core;

class DynamicsT
{
	public static function toMap<T>(ob : Dynamic<T>) : Map<String, T>
	{
		var map = new Map();
		return copyToMap(ob, map);
	}

	public static function copyToMap<T>(ob : Dynamic<T>, map : Map<String, T>) : Map<String, T>
	{
		for (field in Reflect.fields(ob))
			map.set(field, Reflect.field(ob, field));
		return map;
	}
}