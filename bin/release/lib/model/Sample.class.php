<?php

class model_Sample {
	public function __construct(){}
	static $config = "cache=2 days\x0A[params]\x0Aname[0]=Haxe\x0Aname[1]=RenderingService\x0A[defaults]\x0Aname=RenderingService";
	static $html;
	function __toString() { return 'model.Sample'; }
}
model_Sample::$html = "<?DOCTYPE html>\x0A<html>\x0A<head>\x0A<title>\$" . "name</title>\x0A<script type=\"text/javascript\">\x0Afunction render()\x0A{\x0A\x09document.getElementById(\"output\").innerHTML = \"name is: \$" . "name\";\x0A}\x0A</script>\x0A</head>\x0A<body onload=\"render()\">\x0A<div id=\"output\"></div>\x0A</body>\x0A</html>";
