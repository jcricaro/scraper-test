<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Web Scraper</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="content">
            <div id="app">
                <div class="title m-b-md">
                    Web Scraper
                </div>
                <scraper></scraper>
            </div>
        </div>


        <script type="text/javascript">
            var api = "{{ url('/api') }}";
        </script>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>