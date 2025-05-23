# jQuery miniColors: A small color selector

_Copyright 2012 Cory LaViska for A Beautiful Site, LLC. (http://www.abeautifulsite.net/)_

_Dual licensed under the MIT / GPLv2 licenses_


## Demo

http://labs.abeautifulsite.net/jquery-miniColors/


## Usage

1. Link to jQuery: `<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>`
2. Link to miniColors: `<script type="text/javascript" src="jquery.miniColors.js"></script>`
3. Include miniColors stylesheet: `<link type="text/css" rel="stylesheet" href="jquery.miniColors.css" />`
4. Apply $([selector]).miniColors() to one or more INPUT elements


## Options

* __disabled__ _[true,false]_ - When true, disables the control completely
* __letterCase__ _[uppercase|lowercase]_ - forces the hex value into upper or lowercase
* __opacity__ _[true,false]_ - Enables opacity selector (not required if data-opacity attribute is set on input)
* __readonly__ _[true,false]_ - When true, prevents the user from typing in the input box


## Specify options on creation:

	$([selector]).miniColors({
		optionName: value,
		optionName: value,
		...
	});

__Preset color:__

	<input type="text" name="color" value="#FFCC00" />

__Preset color and opacity:__

	<input type="text" name="color" value="#FFCC00" data-opacity=".5" />


## Methods

Methods are called using this syntax:

	$([selector]).miniColors('methodName', [value]);

### Available Methods

* __disabled__ _[true|false]_ - sets the disabled status
* __hide__ _(none)_ - manually hides the color picker control
* __opacity__ _(none)_ - gets the opacity level (0-1)
* __opacity__ _(0-1)_ - sets the opacity level
* __readonly__ _[true|false]_ - sets the readonly status
* __show__ _(none)_ - manually shows the color picker control
* __value__ _(none)_ - gets the current value; guaranteed to return a valid hex color
* __value__ _[hex value]_ - sets the control's value
* __destroy__ _(none)_


## Events

* __change__*(hex, rgb)* - called when the color value changes
* __open__*(hex, rgb)* - called when the color picker is opened
* __close__*(hex, rgb)* - called when the color picker is hidden

* In all callbacks, `this` refers to the original input element.
* `hex` is the hex color code of the selected color
* `rgb` is an object containing red, green, and blue values; if opacity is enabled, it will also contain an alpha value (rgb.a)


### Examples
	
	// Get hex color code on change
	$([selector]).miniColors({
		change: function(hex, rgba) {
			console.log(hex);
		}
	});
	
	// Get RGBA values on change
	$([selector]).miniColors({
		change: function(hex, rgba) {
			console.log('rgba(' + rgba.r + ', ' + rgba.g + ', ' + rgba.b + ', ' + rgba.a + ')');
		}
	});


## Known Issues

* IE7/8 do not show opacity in the trigger since it uses RGBA

## Attribution

* The color picker icon is based on an icon from the amazing Fugue icon set: http://p.yusukekamiyamane.com/
* The gradient image, the hue image, and the math functions are courtesy of the eyecon.co jQuery color picker: http://www.eyecon.ro/colorpicker/