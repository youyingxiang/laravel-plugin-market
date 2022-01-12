<!DOCTYPE html>
<html lang="{{\Illuminate\Support\Facades\App::getLocale()}}" class="h-full bg-gray-100">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>插件市场</title>

       {{-- Laravel Mix - CSS File --}}
       <link rel="stylesheet" href="{{ mix('css/app.css', "vendor/pluginmarket") }}">

    </head>
    <body class="h-full">
        <div id="pluginmarket" class="mx-auto">
            <router-view></router-view>
        </div>
        {{-- Laravel Mix - JS File --}}
        <script src="{{ mix('js/app.js', "vendor/pluginmarket") }}"></script>
    </body>
</html>
