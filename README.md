# Flash Show And Hide Box #

**Contributors:** litefeel  
**Tags:** flash, swf, show, hide, plugin  
**Donate Link:** https://www.paypal.me/litefeel  
**Requires at least:** 3.0.0  
**Tested up to:** 4.7.3  
**Stable tag:** 1.6  
**License:** GPLv2  
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html  

Flash Show And Hide Box lets we very convenient embed flash, and control it show and hide.

## Description ##

Flash Show And Hide Box lets we very convenient embed flash, and control it show and hide.
Some times we need embed flash at my page, but load flash will be slowly show this page and increase stream. Flash Show And Hide Box plugin will enbed flash at visitor click box.
The first click box show flash, clicks again hides the flash.


Related Links:

* <a href="https://www.litefeel.com/flash-show-and-hide-box/" title="Flash Show And Hide Box Plugin for WordPress">Plugin Homepage</a>
* <a href="https://www.litefeel.com/" title="Author For Flash Show And Hide Box Plugin">Author Homepage</a>
* <a href="https://wordpress.org/extend/plugins/flash-show-and-hide-box/other_notes/" title="More usage examples">More usage examples</a>
* <a href="https://github.com/litefeel/flash-show-and-hide-box" title="on GitHub">on GitHub</a>

## Installation ##

You can find, download and install Flash Show And Hide Box directly from the **Plugins** section in WordPress.

If you want to install manually, download and unzip the `flash-show-and-hide-box.zip` file and upload to the `/wp-content/plugins/flash-show-and-hide-box/` directory. Then activate the plugin through the **Plugins** section in WordPress.

## Screenshots ##

1. setting
2. hide flash state
3. show flash state

## Usage ##

**API, initialize an flash box**

    showFlashLib.initBox(swfUrlStr, replaceElemIdStr, widthStr, heightStr, swfVersionStr, flashvarsObj, parObj, attObj);

**API, create an flash box**

    showFlashLib.createBox(swfUrlStr, widthStr, heightStr, swfVersionStr, flashvarsObj, parObj, attObj);

Arguments:

* swfUrlStr (String, required) specifies the URL of your SWF
* replaceElemIdStr (String, required) specifies the id of the HTML element (containing your alternative content) you would like to have replaced by your Flash content
* widthStr (String, required) specifies the width of your SWF
* heightStr (String, required) specifies the height of your SWF
* swfVersionStr (String, required) specifies the Flash player version your SWF is published for (format is: "major.minor.release" or "major")
* flashvarsObj (Object, optional) specifies your flashvars with name:value pairs
* parObj (Object, optional) specifies your nested object element params with name:value pairs
* attObj (Object, optional) specifies your object's attributes with name:value pairs

**Example 1: The recommended usage, the text will by display when javascript is not enabled.**

    <div id="myflash">this is my flash</div>
    <script type="text/javascript">
    showFlashLib.initBox("myflash.swf", "myflash",600,170);
    </script>

**Example 2: The succinct usage.**

    <script type="text/javascript">
    showFlashLib.createBox("myflash.swf",600,170);
    </script>

**Example 3: The ubb code usage.**

    The syntax:
    [flash={width},{height}]{swf file url}[/flash]
    The example:
    [flash=600,170]myflash.swf[/flash]

