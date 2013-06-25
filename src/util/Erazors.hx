package util;

class Erazors
{
	public static function apply(template : erazor.macro.Template, ob : Dynamic)
	{
		Reflect.fields(ob).map(function(field) {
			Reflect.setField(template, field, Reflect.field(ob, field));
		});
		return template;
	}
}