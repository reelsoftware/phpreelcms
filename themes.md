# Introduction
phpReel introduces the concept of themes as a way of creating your custom designs while at the same time not requiring extensive programming knowledge.

The theme is nothing more than a collection of folders and files that together will change the way your application will render to the end-user. To ease your development process, phpReel created components. These are similar to a function that you can call to bring content from phpReel to your HTML5 template. You will learn more about components later in this documentation. 

# File structure

# Starter layout
At the core of any theme there is a layout. This file includes general information which is required on every page of the theme. You can have as many layouts as you may wish. To create a new one just create a new ".blade.php" file inside the layouts folder. Down below you are going to find a template that can be used as a starter for your next theme.

```HTML
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="description" content="@yield('meta_description')">

	<link rel="stylesheet" href="{{ get_css_url('style.css') }}">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap">

	@yield('style')

	<title>@yield('title')</title>
</head>
<body>
	@yield('content')

	<script src="{{ get_js_url("jquery-3.6.0.min.js") }}"></script>
	<script src="{{ get_js_url("bootstrap.bundle.min.js") }}"></script>

	@yield('script')
</body>
</html>
```

# Components
As we previously stated, components are basic functions that help you link phpReel to your HTML5 template (stuff like embedding a video, linking CSS or js files, and so on). In this section we will discuss in detail everything about these components, what is their purpose, and how you can use them to create your themes.

!> **Keep in mind!** Components take arguments in order to work. These arguments are PHP variables accessible in the themes files. Every file inside the theme has access to the exact variables it needs to serve its purpose.

## @html5Source(videoName, videoStorage)
Return a source html tag for the html5 video component.
Takes two arguments:
- `videoName` Name of the video file that will become the source for the HTML5 video component
- `videoStorage` Storage medium used to store the video on upload

```php
<video id="player" playsinline controls>
	@html5Source($item->video_name, $item->video_storage)
</video>
```

## @vimeoEmbed(videoName)
Return the Vimeo embedded video.
Takes one argument:
- `videoName` ID of the video file that will become the source for the iframe component

```php
<div class="plyr__video-embed" id="player">
    @vimeoEmbed($item->video_name)
</div>
```

## @youtubeEmbed(videoName)
Return the YouTube embedded video.
Takes one argument:
- `videoName` ID of the video file that will become the source for the iframe component

```php
<div class="plyr__video-embed" id="player">
    @youtubeEmbed($item->video_name);
</div>
```

## @vimeo(videoStorage)
Similar to an if statement, it checks if the `videoStorage` is equal to "vimeo".
Takes one argument:
- `videoStorage` Storage medium used to store the video on upload

```php
@vimeo($item->video_storage)
	<!--This shows up if the video_storage is vimeo-->
	<div class="plyr__video-embed" id="player">
	    @vimeoEmbed($item->video_name);
	</div>
@elsevimeo("youtube")
	<p>This will show up if the storage is not vimeo but it is youtube</p>
@else
	<p>This will show up if the storage is different from both youtube or vimeo</p>
@endvimeo()
```


## @youtube(videoStorage)
Similar to an if statement, it checks if the `videoStorage` is equal to "youtube".
Takes one argument:
- `videoStorage` Storage medium used to store the video on upload

```php
@youtube($item->video_storage)
	<!--This shows up if the video_storage is youtube-->
	<div class="plyr__video-embed" id="player">
	    @youtubeEmbed($item->video_name);
	</div>
@elseyoutube("s3")
	<p>This will show up if the storage is not youtube but it is s3</p>
@else
	<p>This will show up if the storage is different from both youtube or s3</p>
@endyoutube()
```

## @html5(videoStorage)
Similar to an if statement, it checks if the `videoStorage` is equal to storage mediums that render to an HTML5 video player.
Takes one argument:
- `videoStorage` Storage medium used to store the video on upload

```php
@html5($item->video_storage)
	<!--This shows up if the video_storage is either "s3" or "local" -->
	<div class="plyr__video-embed" id="player">
	    @youtubeEmbed($item->video_name);
	</div>
@html5("s3")
	<p>This will show up if the storage is not local but it is s3</p>
@else
	<p>This will show up if the storage is different from both s3 or local</p>
@endhtml5()
```

## @scriptJs(scriptName, scriptScope)
Return a javascript file indetified by a name and a scope.

Takes two arguments:
- `scriptName` Name of the javascript file (E.g. jsFile.js).
- `scriptScope` Scope is the location of the javascript file. It takes one of the two values: local (stored in the theme folder inside the js folder) or external (via url, cdn)

```php
<!--Local script example, player.js is stored in the js folder-->
@scriptJs('player.js', local)

<!--External script example, javascript file is stored using a CDN-->
@scriptJs("https://cdn.plyr.io/3.6.4/plyr.js", external)
```

# Translation
phpReel integrates a translation feature that lets you translate your application to any language you might want, using a simple UI right from your dashboard. This feature is great but considering you are developing a new theme that might contain different keywords that have to be translated you have to take one extra step and that is creating your default language file.

To do that, go to your "lang" directory situated inside your theme folder, then navigate to "default" and open "default.json". This is the JSON document that contains all the words available for translation. It is structured as a key-value pair as shown in the example below. The left side will contain the word to be translated and the right side will always be left empty. You should have a key-value pair for every word or group of words that you want to translate.
```json
{
	"Name": "",
	"Password": "",
	"Confirm password": "",
	"Already registered?": "",
	"Remember me": "",
	"Forgot your password?": "",
	"Log in": ""
}
```

!> **Keep in mind!** Remember that the last key-value pair MUST NOT have a comma.

When you are writing the words inside your theme you have to write them inside `{{__('your word or group of words go here')}}`. The words that you write there must match the words written in the JSON file.
```html
<!--This works because the words match the words from the JSON file-->
<label>{{__('Forgot your password?')}}</label>

<!--This will not work because the words don't match the words from the JSON file-->
<label>{{__('Login')}}</label>
```

It is not mandatory to work with translations, if you don't need them then just skip updating the default.json file or writing the words inside the special tag. Your theme will continue to work just fine but will not have the translation feature.
