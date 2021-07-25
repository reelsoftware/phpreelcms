# Introduction
phpReel introduces the concept of themes as a way of creating your custom designs while at the same time not requiring extensive programming knowledge.

The theme is nothing more than a collection of folders and files that together will change the way your application will render to the end-user. To ease your development process, phpReel created components. These are similar to a function that you can call to bring content from phpReel to your HTML5 template. You will learn more about components later in this documentation. 

Keep in mind that phpReel is a Laravel application at it's core. This means that in order to change the way your application looks and feels you don't have to actually follow every step presented here. This guide gives you information about the tools that can be used but it's up to you, the developer, to decide where and if to use them.

# File structure
In order to create a phpReel theme you must comply to the theme standard defined by us. Don't worry, it's pretty simple. You just have to create a couple of directories and files as described below. 
```
themes
│
└───themeFolder
    │   config.json
    │   cover.jpg
    │   config.json   
    └───auth
    └───categories
    └───css
    └───episodes
    └───img
    └───js
    └───lang
    └───layouts
    └───movie
    └───pagination
    └───search
    └───series
    └───subscribe
    └───trailer
    └───user
```
## config.json file
This is a mandatory file that contains basic information about the theme. It's a simple JSON file that has to be structured exactly as bellow.
```json
{
    "Theme name": "Default",
    "Description": "This is the default theme for phpReel",
    "Author": "phpReel team",
    "Theme URL": "https://phpreel.org/",
    "Version": "1.0.0",
    "License": "MIT",
    "License URL": "https://github.com/phpreel/phpreel/blob/main/LICENSE"
}
```
## cover.jpg
Mandatory image file used as a thumbnail image for the theme inside the dashboard. The file must have exactly the same name and extension.

## Directories inside theme folder
As shown in the File structure section, there are a number of directories and files (we call them views) in those directories. To make sure every page work you must create all of them. In addition you can add as many views or directories you want, the above structure is the bare minimum.

## What is Blade?
Blade is a template engine that ships with Laravel and it's also what phpReel uses to render it's pages. If Blade is not familiar to you we recommend to check out it's documentation available on the Laravel website, you can find it [here](https://laravel.com/docs/master/blade).

## .blade.php file extension
Every file that contains the design of a specific page is called a view and it must have the .blade.php extension. This let's Blade know that the view should be compiled and cached into plain PHP code so it can be later rendered to the user. 

## Accessing a view
Although all the views must have the .blade.php extension note that when you will refer to them inside the components you don't include the extension. Furthermore if a view is situated inside a directory you can get access to it using a dot (ie if the view "content.blade.php" is situated in a directory named "basicDirectory", you can refer to it like this: "basicDirectory .content "). You can nest as many directories as you want and access them the same way.


# Starter layout
At the core of any theme there is a layout. This file includes general information which is required on every page of the theme. You can have as many layouts as you may wish. To create a new one just create a new ".blade.php" file inside the layouts folder. Down below you are going to find a template that can be used as a starter for your next theme.

```HTML
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	@yield('meta')

	<link rel="stylesheet" href="{{ Asset::css('style.css') }}">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap">

	@yield('style')

	<title>@yield('title')</title>
</head>
<body>
	@yield('content')

	<script src="{{ Asset::js("jquery-3.6.0.min.js") }}"></script>
	<script src="{{ Asset::js("bootstrap.bundle.min.js") }}"></script>

	@yield('script')
</body>
</html>
```
A layout is a normal ".blade.php" file, thus you have access to any Blade, Laravel or phpReel components that you would normally use. Detailed description on these components is provided later in this documentation.

The first thing to note from the layout about is the @yield('') directive. This acts as a placeholder for different content. For example, if you access the home page of your application, Blade will automatically replace @yield('content') with the content of that particular page. Thus you can separate different pages of your application while at the same time keeping the same layout across the whole app.

# Components
As we previously stated, components are basic functions that help you link phpReel to your HTML5 template (stuff like embedding a video, linking CSS or js files, and so on). In this section we will discuss in detail everything about these components, what is their purpose, and how you can use them to create your themes.

There are two types of components you can call from within your views: Blade directives and phpReel components.

!> **Keep in mind!** Components take arguments in order to work. These arguments are PHP variables accessible in the themes files. Every file inside the theme has access to the exact variables it needs to serve its purpose.

## Blade directives
This components are provided directly by the Blade template engine or they are registered directly through it.

```php
@componentName(param1)
```

!> **Note** The Blade directives always start with @

## phpReel components
Are created by phpReel to provide functionality beyond what Blade has to offer. They are basic PHP static methods that are meant to provide access to the core of phpReel.
```php
{{ Class::componentName(param1, param2, ...) }}
```
In order to use them, you have to first specify the class that contains them (more information about the available classes is provided in this documentation). After we specify the class, we then use the [scope resolution operator](https://www.php.net/manual/en/language.oop5.paamayim-nekudotayim.php) (double colon ::) to call a particular static methods which is a fancy way of saying select a certain function from that particular class. At the end we can specify the required or optional parameter.

!> **Note** In order to make them work, we must enclose them between two curly braces {{ lass::componentGoesHere(param1, param2, ...) }}. This tells Blade that the component is just a simple PHP code and it should render the view accordingly.

# Utilities

## Utilities::excerpt($text, $length, $trimMarker)
Returns an excerpt from a given input text.

- `$text` Required, text to be excerpted 
- `$length` Required, length of the returned string
- `$trimMarker` Required, string to be added after the chunk of text (e.g. if the trimMarker is ... then the returned string will end with ...)

```php
{{ Utilities::excerpt($longStringOfText, 200, "...") }}
```

## Utilities::pagination($content, $paginationFileName)
Renders the specified pagination file.

- `$content` Required, content to be paginated
- `$paginationFileName` Required, name of the view file, situated in the pagination folder of the theme that holds the design and functionality information for the paginator

```php
{{ Utilities::pagination($content, "basicPagination") }}
```

# Asset

## Asset::js("script.js")
Returns the path to a Javascript resource stored inside the js folder of your theme. It takes only one string argument which is a path to the js file. If that file is inside a directory you can include that file too.

```php
//File is situated in js/script.js
Asset::js("script.js")

//File is situated in js/demo/script.js
Asset::js("demo/script.js")
```

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


# Available view variables
Every view inside your theme has access to certain values by default. These values are passed to the view via the controller to provide basic functionality to your views. Down bellow you are going to find all the available variables. More information about phpReel components are available in this documentation.

## How to use variables?
After you check what variables are available for a particular view you can get their content like this:
```php
{{ $variableName }}
```

## Extend beyond view variables
Although phpReel provides access out of the box to basic variables you can extend access to other variables by using phpReel components. Different components will give you access to different pieces of data to give you as much flexibility as possible while developing themes.

## user.index
- `$name` (string) Name of the current logged in user
- `$email` (string) Email of the current logged in user
- `$subscription` (bool) Returns true if the user has an active subscription
- `$language` (string) Language set as default for the logged in user
- `$translations` (array) List of all the available translations

## trailer.show
- `$item` Collection of all the details of a particular trailer
- `$item->title` (string) Title of the trailer
- `$item->description` (string) Description of the trailer
- `$item->video_name` (string) Name of the video file
- `$item->video_storage` (string) Name of the storage medium where the video is stored

```php
{{ get_video_url($item->video_name, $item->video_storage) }}
```

- `$item->id` (int) Id of the trailer
- `$item->series_title` (string) Title of the series to which the trailer is linked
- `$item->series_id` (int) Id of the series to which the trailer is linked
- `$item->season_title` (string) Title of the season which is linked to the series
- `$item->season_id` (int) Id of the season which is linked to the series

```php
@if($item->series_title != null && $item->season_title != null)
    <a class="ne-movie-details" href="{{route('seriesShow', ['id' => $item->series_id])}}">{{$item->series_title}} - {{$item->season_title}}</a> 
@elseif($item->title != null)
    <a class="ne-movie-details" href="{{route('movieShow', ['id' => $item->id])}}">{{$item->title}}</a> 
@endif
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
