<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="/logo_kalymz.ico" type="image/x-icon">


    <title>Kalymz - Apprendre l'arabe</title>
    @vite(['resources/js/app.js'])
</head>

<body>
    <div id="app">
        <app></app>
    </div>

</body>

</html>
