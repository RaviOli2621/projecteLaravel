<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title")</title>
    <link href="{{ secure_asset('/css/header.css') }}" rel="stylesheet">
</head>
<body>
    <nav>
    <x-title-and-home tst="siu">Glossari de termes als jocs de lluita</x-title-and-home>
    <x-login-icon nameUs="" admin="true"></x-login-icon>
    
    <!--<h1>Hola <?php echo($nom ?? "RaviOli2621") ?> (con la e para evitar inyeccion de codigo, como bladetruco)</h1>-->
    <x-navigation-bar name="Xavi"></x-navigation-bar>
@yield("seccioProva")

</body>
</html>