<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#EC037B">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Mr Panel</title>
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/app.css', 'mrpanel-assets')) }}">

</head>
<body>

  @yield('content')

  <script type="text/javascript" src="{{ asset(mix('js/app.js', 'mrpanel-assets')) }}"></script>

</body>
</html>
