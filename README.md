Rendering Service
=================

by Franco Ponticelli (franco.ponticelli@gmail.com)

Introduction
------------

The Rendering Service allows you to render HTML contents on the service side and
deliver rendered outputs (PNG, PDF ...). It is tailored to our visualization
engine to minimize the need for coding and maximize the number of options in
that context. In this documentation you will find all the information required
to access and use the service.



Most of the responses of the REST API calls can be displayed in either HTML or
JSON format allowing auto-discovery of the available features.

Template
--------

Templates for visualizations are simple HTML documents that contain the
intelligence (JavaScript code) and the aesthetic properties (CSS definitions) to
generate one or more visualizations.

A simple template might look like this:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
<?DOCTYPE html>
<html>
<head>
<title>$name</title>
<script type="text/javascript">
function render()
{
	document.getElementById("output").innerHTML = "name is: $name";
}
</script>
</head>
<body onload="render()">
<div id="output"></div>
</body>
</html>
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

This HTML is no different from a standard HTML page that you can use in your
website. The only noticeable difference is the usage of the \$viz keyword.
Dollar prefixed keywords are interpreted as template parameters; parameters are
dynamically injected (parameters are replaced when the visualization is
generated) using the query string arguments provided or the default values
specified in the configuration file.

### UID

Once an uploaded template is properly validated, a response object containing
the Unique Identifier (UID) is returned. The UID is generated based on the
content of the template and its configuration object guaranteeing that if the
same visualization is posted more than once, no clones are created. On the other
hand, if changes are made to the template (or configuration) a new UID will be
issued after re-uploading.

### Lifetime Cycle

There are two aspects to consider when dealing with the lifetime expectancy of a
visualization in the rendering service. The first is that the generated images
are always cached; if the same image is accessed more than once the server
doesn’t have to regenerate the entire visualization but only to deliver a copy
created the first time it was accessed. This heavily reduces the load on the
server, improves the response time and the user experience. The cache span can
be changed by tweaking a configuration parameter. Having shorter cache time
spans make sense when the image needs to refresh its content several times.

The other aspect to consider is how long a certain visualization must exist in
the system. By default a visualization will be available for 366 days (the
config parameter for this is “duration”) since the last time it has been
displayed (generated or loaded from cache). This mechanism ensures that
visualizations still in use are never erased.

Configuration
-------------

The Rendering Service has been conceived with minimal configuration in mind, in
fact it can be used with no configuration at all. Configuration parameters
become important (or essential) when the need for flexibility increases. A
simple, not dynamic, visualization can be created without the need of a
configuration file, but if you want to add dynamic parameters, restrict the
available download formats or more advanced tweakings you will need to add
configuration parameters.

### Configuration Formats

Configuration parameters can be expressed in either the INI1 or JSON2 format.
The available options are the same for both formats, they are just expressed in
different ways.

### INI

The INI file format represents a key/value set of parameters.

Flat in nature, the parameters can be grouped using square bracketed group
names:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
cache=2 days
[params]
name[0]=Haxe
name[1]=RenderingService
[defaults]
name=RenderingService
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

In the case above, the parameter `cache` belongs to the general root options
group while `name` is an argument of the defaults group.

Array values can instead be specified defining multiple keys each one with a
different index position:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
name[0]=Haxe
name[1]=RenderingService
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Which is basically equivalent to `name = ["Haxe", "RenderingService"]`.

For details about the available options take a look below.

### JSON

JSON is a useful format for configuration files because of its readable syntax
and because it supports natively things like arrays and nested objects. The
example used in the INI section can be expressed in JSON format like this:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
{ "cache" : "2 days", "defaults" : { "name" : "RenderingService" } }
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

or for better readability:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
{
  "cache" : "2 days",
  "defaults" : {
    "name" : "RenderingService"
  }
}
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Configuration Sections
----------------------

The configuration files have 3 main sections: “options”, “params” and
“defaults”. Each is described below, the important thing to note here is that
“options” values are going to be set in the root of the configuration file while
“params” and “defaults” values must reside in their own groups.

This is an example with fictional parameter names and values in INI format.

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
option1=value1
option2=value2
[params]
param1=true
param2[0]=value1
param2[1]=value2
[defaults]
default1=value1
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Params
------

Whenever you want to use dynamic values in your template you must create one
variable for each of those. This variable is used in the template itself
prefixed with the dollar symbol (ex: `$varname`) and as the key of a key/value
pair in the params section. The value of for the variable can be either the
boolean value true or a list of acceptable values (the value passed in the query
string must match a value in the list or the visualization will fail to render).

Assuming for example that you want to add a dynamic title to your visualization
you can add the following to the template:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
<h1>$title</h1>
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

In the configuration file you must specify that \$title is a template parameter
and you do so by adding the following:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
[params]
title=true
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Using a list of values instead of the value true, means that the parameter is
restricted to those values:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
[params]
title[0]=Main
title[1]=Details
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

In this case `$title` can only be replaced with either “Main” or “Details”.

Dynamic parameter values are provided as additional query string arguments
appended to the URL of the desired visualization. See Download Output for more
information about that.

Defaults
--------

Sometimes it is practical to have default values for your dynamic parameters;
meaning that if the parameter value is not expressed in the query string of the
requested visualization, it will be automatically replaced with some default
value that works for most cases.

Defaults are simple to add and just require to add them in the “defaults” group:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
[defaults]
title=Main
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Note that if you used a set of possible values for “title” as in the example
above, the value used as the default must match one of those.

Options
-------

All the following options belong to the root configuration object (no group
container) and are split here into 3 sections just for the sake of their use
context.

### General

These options are generic and apply no matter what output format has been
selected.

**cacheExpires** (default: 2 days)

Determine how often the cached images are regenerated. This can be important if
the embedded image should be refreshed from time to time. The value of this
parameter can be either a number (milliseconds) or a string expression in the
form `<quantifier> <period>` like: “2 hours”.

**duration** (default: 366 days)

If the visualization is not used in the last duration period it will be
automatically eliminated from the system. The value of this parameter can be
either a number (milliseconds) or a string expression in the form `<quantifier>
<period>` like: “30 days”.

**allowedFormats** (default: ['pdf', 'png', 'jpg', 'svg'])

Set the allowed formats for the visualizations in an array format. The available
formats are: pdf, png, jpg or svg.

**params** (default: empty set of values)

See the params section in this reference.

**defaults** (default: empty set of values)

See the defaults section in this reference.

**zoom** (default: 1.0)

Zoom factor to scale the rendering output.

### Image

These options only apply if the output format is of the image type (png, jpg or
svg).

**x** (default: 0)

Set x coordinate for cropping in pixels.

**y** (default: 0)

Set t coordinate for cropping in pixels.

**width** (default: null)

Set the cropping width in pixels. null means that screenWidth is used instead.

**height** (default: null)

Set the cropping height in pixels. null means that screenHeight is used instead.

**screenWidth** (default: 1024)

Set the width of the page in pixels.

**screenHeight** (default: null)

Set the height of the page in pixels. null means that the height is calculated
from the content.

**quality** (default: 94)

Quality of the image output (relevant only for some output formats like JPG).
The value must be in the 0 to 100 range; the higher the value the better the
quality of the output image. The quality only affects the compression ratio
(size in bytes) of the generated image.

**disableSmartWidth** (default: false)

Use the specified width even if it is not large enough for the content.

**transparent** (default: false)

Make the background transparent for output formats that support transparency
(like PNG).

### PDF

These options only apply if the output format is of the PDF type.

**dpi** (default: null)

Change explicitly the DPI (dots per inch) of the generated PDF.

**grayscale** (default: false)

Generated PDF will be in grayscale instead of full color.

**imageDpi** (default: 600)

Defines the DPI resolution for the images embedded in the PDF.

**imageQuality** (default: 94)

The compression level to adopt for the embedded images. See the quality
parameter in the image section for more details.

**lowQuality** (default: false)

Generates lower quality outputs to shrink the result document size.

**marginTop** (default: 10mm)

Top margin.

**marginBottom** (default: 10mm)

Bottom margin.

**marginLeft** (default: 10mm)

Left margin.

**marginRight** (default: 10mm)

Right margin.

**portrait** (default: true)

Set the page orientation to portrait (true) or landscape (false).

**pageSize** (default: A4)

Set paper size: A4, Letter ...

**pageHeight** (default: height for A4 page format)

Set the page height. Requires unit of measure (ex: mm).

**pageWidth** (default: width for A4 page format)

Set the page width. Requires unit of measure (ex: mm).

**title** (default: null)

Sets the title of the generated pdf file.

**usePrintMediaType** (default: false)

Use print media-type instead of screen.

**disableSmartShrinking** (default: false)

Disable the intelligent shrinking strategy that makes the pixel/dpi ratio none
constant.

**footerCenter** (default: null)

Centered footer text.

**footerLeft** (default: null)

Left aligned footer text.

**footerRight** (default: null)

Right aligned footer text.

**footerFontName** (default: Arial)

Footer font name.

**footerFontSize** (default: 12)

Footer font size.

**footerHtml** (default: null)

Adds an HTML footer.

**footerSpacing** (default: 0)

Spacing in mm between the footer and the page content.

**footerLine** (default: false)

Display a line between the page content and the footer.

**headerCenter** (default: null)

Centered header text.

**headerLeft** (default: null)

Left aligned header text.

**headerRight** (default: null)

Right aligned header text.

**headerFontName** (default: Arial)

Header font name.

**headerFontSize** (default: 12)

Header font size.

**headerHtml** (default: null)

Adds an HTML header.

**headerSpacing** (default: 0)

Spacing in mm between the header and the page content.

**headerLine** (default: false)

Display a line between the page content and the header.

Upload
------

To use the service it is first needed to upload a template HTML document and
optionally a configuration file. This can be performed in several ways as
explained below.

Once the template has been uploaded it is immediately ready to be used (see the
Download section below).

The template supports the use of parameters that allow the reuse of the same for
several purposes. For example adding a userid parameter it is possible to reuse
the same layout for different users (or customers or projects ...).

The rendered images are automatically cached to optimize their generation speed
and server load. Images are cached taking into consideration the parameters; ex:
the same template rendered with 3 distinct values for a certain parameter will
be cached 3 times.

### Upload Form

The most basic way to upload a template is to point your browser at
`http://<host>/renderingservice/viz/charts/up/form/html` and copy/paste your
contents in the two available text areas (one for the HTML and one for the
CONFIG). Note that the text areas are prefilled with some sample codes for
guidance; be sure to replace/remove them entirely.

Once you press submit the form is processed by the service, a new UID is created
for the visualization and the browser is redirected to display the Download
Info.

Adding a displayFormat argument to the query string it is possible to upload and
immediately display the image output instead of displaying the download
information. The displayFormat argument value must be one of the available
format for the visualization, ex: displayFormat=png

### Post Content

The uploading can be performed using a POST REST API call at the URL:
`http://<host>/renderingservice/viz/charts/up.html` (HTML output) or
`http://<host>/renderingservice/viz/charts/up.json` (JSON output).

The POST request must contain the html parameter. html must be the HTML content
of the template. Optionally it is possible to add a config parameter in either
JSON or INI format.

### Post/Get URL

Sometime it comes handy to reuse something already available online. For that
purpose just use the following REST API call (either GET or POST method will
work):
`http://<host>/renderingservice/viz/charts/up/url.html?urlhtml={absolute/url/goes/here}`
(HTML output) or
`http://<host>/renderingservice/viz/charts/up/url.json?urlhtml={absolute/url/goes/here}`
(JSON output).

In both it is possible to pass a second query string parameter urlconfig to
address a resource containing a configuration file either in JSON or INI format.

### Gist

Gist are very convenient atomic repositories provided by Github. Each Gist can
support multiple files, file history and branching; all features that make Gist
perfect to prepare and deploy visualization templates. Just create a Gist at
https://gist.github.com/ with the usual mandatory file named index.html and an
optional configuration file (either config.ini or config.json) and use the form
submitter here or use a GET/POST REST API call to
`http://<host>/renderingservice/viz/charts/up/gist/{gistid}.html` (HTML output)
or `http://<host>/renderingservice/viz/charts/up/gist/{gistid}.json` (JSON
output). In the first option just copy/paste the Gist unique ID into the
available text input, in the latter cases just be sure to replace {gistid} with
the desired value.

Note that uploads made with Gist are not automatically updated when changes are
made to the gist. After the changes are completed just resubmit the Gist using
one of the methods illustrated above. Each resubmission can create a new UID.

### Download

Once a template has been uploaded it is immediately available to be used. The
image renderer can be used by embedding the url
`http://<host>/renderingservice/viz/charts/down/{UID}.{format}` into the desired
application (email, newsletter, report, user application …). The URL has two
place-holders that must be replaced with sensible values: `{UID}` and
`{format}`. The first is obtained by uploading the template and inspecting the
response from the server. The second must be one of the available formats for
the visualization as defined in the configuration file.

This is an example of a rendering:
`http://<host>/renderingservice/viz/charts/down/4mp9zoie2d2c.png`

In the above example, `4mp9zoie2d2c` is the UID and .png is the format.

### Download Info

Additional information on a visualization can be obtained at the URL
`http://<host>/renderingservice/viz/charts/up/info/{UID}.html` (for HTML output)
or `http://<host>/renderingservice/viz/charts/up/info/{UID}.json` (for JSON
output). Again {UID} must be replaced with the Unique ID of the visualization
you want to inspect.
