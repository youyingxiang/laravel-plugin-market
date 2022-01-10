<!DOCTYPE html>
<html lang="en" class="h-full bg-white">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Plugin PluginMarket</title>

       {{-- Laravel Mix - CSS File --}}
       <link rel="stylesheet" href="{{ mix('css/app.css', "plugins/pluginmarket/build") }}">

    </head>
    <body class="h-full">
        <div id="pluginmarket">
            <router-view></router-view>
        </div>
        {{-- Laravel Mix - JS File --}}
        <script src="{{ mix('js/app.js', "plugins/pluginmarket/build") }}"></script>
    </body>
</html>
