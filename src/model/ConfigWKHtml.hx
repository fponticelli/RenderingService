package model;

class ConfigWKHtml
{
	public var zoom : Null<Float>;
	public function new() { }

	public function toString()
	{
		return "ConfigWKHtml: " + ConfigObjects.fieldsToString(this);
	}
}