package model;

class Sample
{
	public static var config = 'cache=2 days
[params]
name[0]=Haxe
name[1]=RenderingService
[defaults]
name=RenderingService';
	public static var html   = '<?DOCTYPE html>
<html>
<head>
<title>$$name</title>
<script type="text/javascript">
function render()
{
	document.getElementById("output").innerHTML = "name is: $$name";
}
</script>
</head>
<body onload="render()">
<div id="output"></div>
</body>
</html>';
}