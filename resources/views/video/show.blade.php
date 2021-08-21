<html>
    <head>
        <title>{{ $name }}</title>
        <link rel="stylesheet" href="https://cdn.plyr.io/3.6.4/plyr.css">

        <style>
            * {
   margin: 0;
   padding: 0;
   box-sizing: border-box;
}

body {
  background-color: green;
  height: 60vh;
}
        </style>
    </head>
    <body>
        @vimeo($storage)
            <div class="plyr__video-embed" id="player">
                <iframe src="{{ Asset::video($name, $storage) }}"></iframe>
            </div>
        @endvimeo

        @html5($storage)
            <video id="player" playsinline controls>
                <source src="{{ Asset::video($name, $storage) }}">
            </video> 
        @endhtml5

        @youtube($storage)
            <div class="plyr__video-embed" id="player">
                <iframe src="{{ Asset::video($name, $storage) }}"></iframe>
            </div>
        @endyoutube

        <script src="https://cdn.plyr.io/3.6.4/plyr.js"></script>
        <script src="{{ Asset::js("player.js") }}"></script>
    </body>
</html>
