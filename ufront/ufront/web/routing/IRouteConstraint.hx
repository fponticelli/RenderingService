/**
 * ...
 * @author Franco Ponticelli
 */

package ufront.web.routing;
import ufront.web.HttpContext;
import ufront.web.UrlDirection;

interface IRouteConstraint
{
	public function match(context : HttpContext, route : Route, params : Map<String, String>, direction : UrlDirection) : Bool;
}