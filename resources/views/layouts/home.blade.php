<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')

</head>

<body>

    @include('partials.header')
    <div class="content">
        @yield('content')
    </div>

    @include('partials.footer')
    <!-- Add your scripts here -->

</body>

</html>