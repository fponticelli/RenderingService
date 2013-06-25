/**
 * ...
 * @author Franco Ponticelli
 */

package ufront.web;
import thx.collection.CascadeHash;
import thx.error.AbstractMethod;
import haxe.io.Bytes;

/**
* @todo remove the singleton
*/
class HttpRequest
{
  public static var instance(get, null) : HttpRequest;
	static function get_instance() : HttpRequest
	{
		if(null == instance)
#if php
        	instance = new php.ufront.web.HttpRequest();
#elseif neko
            instance = new neko.ufront.web.HttpRequest();
#else
    	NOT IMPLEMENTED PLATFORM
#end
		return instance;
	}

	/**
	 * The parameters are collected in the following order:
	 * - query-string parameters
	 * - post values
	 * - cookies
	 */
 	public var params(get, null) : CascadeMap<String, String>;
 	function get_params()
 	{
 		if (null == params)
 			params = new CascadeMap([new Map(), query, post, cookies]);
 		return params;
 	}

 	public var queryString(get, null) : String;
 	function get_queryString() return throw new AbstractMethod();

 	public var postString(get, null) : String;
 	function get_postString() return throw new AbstractMethod();

 	public var query(get, null) : Map<String, String>;
 	function get_query() return throw new AbstractMethod();

 	public var post(get, null) : Map<String, String>;
 	function get_post() return throw new AbstractMethod();

 	public var cookies(get, null) : Map<String, String>;
 	function get_cookies() return throw new AbstractMethod();

 	public var hostName(get, null) : String;
 	function get_hostName() return throw new AbstractMethod();

 	public var clientIP(get, null) : String;
 	function get_clientIP() return throw new AbstractMethod();

 	public var uri(get, null) : String;
 	function get_uri() return throw new AbstractMethod();

 	public var clientHeaders(get, null) : Map<String, String>;
 	function get_clientHeaders() return throw new AbstractMethod();

	public var userAgent(get, null) : UserAgent;
 	function get_userAgent() return throw new AbstractMethod();

 	public var httpMethod(get, null) : String;
 	function get_httpMethod() return throw new AbstractMethod();

 	public var scriptDirectory(get, null) : String;
 	function get_scriptDirectory() return throw new AbstractMethod();

 	public var authorization(get, null) : { user : String, pass : String };
 	function get_authorization() return throw new AbstractMethod();

 	public function setUploadHandler(handler : IHttpUploadHandler) throw new AbstractMethod();

	// urlReferrrer
	//public var acceptTypes(getAcceptTypes, null) : Array<String>;
	//public var sessionId(getSessionId, null) : String;

	/**
	 * never has trailing slash. If the application is in the server root the path will be emppty ""
	 */
	//public var applicationPath(getApplicationPath, null) : String;
	//public var broswer(getBrowser, setBrowser) : HttpBrowserCapabilities;
	//public var encoding(getEncoding, setEncoding) : String;
	//public var contentLength(getContentLength, null) : Int;
	//public var contentType(getContentType, null) : String;
	//public var mimeType(getMimeType, setMimeType) : String;
	//public var files(getFiles, null) : List<HttpPostedFile>;
	//public var httpMethod(getHttpMethod, null) : String;
	//public var isAuthenticated(getIsAuthenticated, null) : String;
	/**
	 * evaluates to true if the IP address is 127.0.0.1 or the same as the client ip address
	 */
	//public var isLocal(getIsLocal, null) : String;
	//public var isSecure(getIsSecure, null) : String;

	//public var userAgent(getUserAgent, null) : String;
	//public var userHostAddress(getUserHostAddress, null) : String;
	//public var userHostName(getUserHostName, null) : String;
	//public var userLanguages(get, null) : Array<String>;
}