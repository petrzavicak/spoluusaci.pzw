<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Svatba ušáci' }}</title>

        <!-- Google Fonts pro lepší čitelnost a styl -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Playfair+Display:wght@700;900&family=Montserrat:wght@700;900&family=Cormorant+Garamond:italic,wght@700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <style>
            body { font-family: 'Inter', sans-serif; }
            h1, h2, h3 { font-family: 'Playfair Display', serif; }
            .font-montserrat { font-family: 'Montserrat', sans-serif; }
            .font-cormorant { font-family: 'Cormorant Garamond', serif; }
        </style>
    </head>
    <body class="bg-amber-50 text-stone-800 antialiased">
        {{ $slot }}

        @livewireScripts
    </body>
</html>
