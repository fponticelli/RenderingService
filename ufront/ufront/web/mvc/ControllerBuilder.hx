package ufront.web.mvc;

import thx.error.NullArgument;

class ControllerBuilder
{
	public static var current = new ControllerBuilder();

	public var packages(default, null) : List<String>;
	public var attributes(default, null) : List<String>;

	public var controllerFactory(get, set) : IControllerFactory;
	var _controllerFactory : IControllerFactory;

	public function new()
	{
		packages = new List();
		attributes = new List();
	}

	function get_controllerFactory() : IControllerFactory
	{
		if (_controllerFactory == null)
			_controllerFactory = new DefaultControllerFactory(this, DependencyResolver.current);

		return _controllerFactory;
	}

	function set_controllerFactory(controllerFactory : IControllerFactory)
	{
		NullArgument.throwIfNull(controllerFactory);
		this._controllerFactory = controllerFactory;

		return controllerFactory;
	}
}