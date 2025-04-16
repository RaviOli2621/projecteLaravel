<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>@yield("title")</title>
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Only include critical variables -->
    <style>
        :root {
            --green-color: #3a7563;
            --dark-color: #1b4332;
            --title-font: 'Arial, sans-serif';
        }
    </style>
    <!-- Scripts stack para reCAPTCHA y otros scripts -->
    @stack('scripts')
</head>
<body>
    <nav>
        <x-navigation-bar name="Xavi"></x-navigation-bar>
    </nav>

    <main>
        @yield("seccioProva")
    </main>
</body>
</html>