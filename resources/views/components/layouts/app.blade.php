<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head class="h-full">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>
    @vite(['resources/js/app.js'])
</head>

<body class="font-poppins h-full">
    {{ $slot }}
</body>

</html>