package model;

class ConfigImage
{
	public var x					: Null<Int>;
	public var y					: Null<Int>;
	public var width				: Null<Int>;
	public var height				: Null<Int>;
	public var screenWidth			: Null<Int>;
	public var screenHeight			: Null<Int>;
	public var quality				: Null<Int>;
	public var disableSmartWidth	: Bool;
	public var transparent			: Bool;

	public function new()
	{
		disableSmartWidth = false;
		transparent = false;
	}

	public function toString()
	{
		return "ConfigImage: " + ConfigObjects.fieldsToString(this);
	}
}