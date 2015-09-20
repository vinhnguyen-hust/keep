<!DOCTYPE html>
<!--[if IE 8]>
<html class="no-js lt-ie9" lang="en">
<![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title')</title>
<meta name="description" content="@yield('meta-description', 'Manage your everyday tasks.')">
<link href="{{ elixir('css/all.css') }}" rel="stylesheet">
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
    @yield('header')
    @include('layouts.partials._main_navbar')
    @yield('banner')
    <div class="container">
        @include('flash::message')
        @yield('content')
    </div>
    @include('layouts.partials._footer')
    <script src="{{ elixir('js/all.js') }}"></script>
    @yield('footer')
</body>
</html>