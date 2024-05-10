<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>@yield('title') | {{config('app.name')}}</title> 
    <!-- Include header file -->
    @include('layouts.header')
</head>
<body class="bg-light">
    <div id="app">
        <!-- Include top navigation file -->
        @auth
            @include('layouts.topnavbar')
        @endauth
        <!-- main content -->
        <main class="py-4">
            @yield('main-content')
        </main>
    </div>
   
</body>
<!-- Include footer file -->
@include('layouts.footer')
</html>