# Introduction
phpReel introduces the concept of themes as a way of creating your custom designs while at the same time not requiring extensive programming knowledge.

The theme is nothing more than a collection of folders and files that together will change the way your application will render to the end-user. To ease your development process, phpReel created components. These are similar to a function that you can call to bring content from phpReel to your HTML5 template. You will learn more about components later in this documentation.

# File structure


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
Return the vimeo embedded video.
Takes one argument:
- `videoName` ID of the video file that will become the source for the iframe component

```php
<div class="plyr__video-embed" id="player">
    @vimeoEmbed($item->video_name)
</div>
```

## @youtubeEmbed(videoName)
Return the vimeo embedded video.
Takes one argument:
- `videoName` ID of the video file that will become the source for the iframe component

```php
<div class="plyr__video-embed" id="player">
    @youtubeEmbed($item->video_name);
</div>
```
