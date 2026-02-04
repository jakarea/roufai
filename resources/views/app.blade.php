<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Vite will inject the CSS and JS automatically -->
        @vite(['resources/css/app.css', 'resources/js/app.jsx'])

        <!-- Tailwind CSS is imported via Vite -->
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
