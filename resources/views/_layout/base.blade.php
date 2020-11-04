<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#EC037B">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Mr Panel</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('mrpanel-assets/css/app.css') }}">
    <script type="text/javascript">
      var MRPANEL_URL = "{{ mrpanel_url() }}";
    </script>
</head>
<body>

  <div class="panel" id="panel">
    <div class="panel__head d-flex">
      <div class="panel__head__logo"></div>
      <div class="panel__head__main d-flex justify-content-between">
        <button type="button" class="js-toggle btn btn-primary d-lg-none" data-target="#panel" data-class="panel-side--show"><i class="icon-burger"><span></span></i></button>
        <div class="ml-auto">
          <a class="btn btn-link" href="{{ route('mrpanel.logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
      </div>
    </div>
    <div class="panel__side">
      <div class="panel__side-container js-custom-scrollbar">
        @include('mrpanel::_base/sidebar')
      </div>
    </div>
    <div class="panel__main">
      <div class="panel__body">@yield('content')</div>
      <div class="panel__foot">@include('mrpanel::_base/footer')</div>
    </div>
  </div>

  @stack('modal')

  <script type="text/javascript" src="{{ asset('mrpanel-assets/js/app.js') }}"></script>

  @stack('scripts-bottom')

</body>
</html>
