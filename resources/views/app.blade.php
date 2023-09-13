<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

        <link rel="shortcut icon" sizes="16x16 32x32" href="{{ asset('imgs/favicons/favicon.ico') }}">
        <link rel="apple-touch-icon" href="{{ asset('imgs/favicons/apple-touch-icon.png') }}">
        <link rel="icon" sizes="16x16" href="{{ asset('imgs/favicons/favicon-16x16.png') }}">
        <link rel="icon" sizes="32x32" href="{{ asset('imgs/favicons/favicon-32x32.png') }}">
        <link rel="icon" sizes="512x512" href="{{ asset('imgs/favicons/android-chrome-512x512.png') }}">
        <link rel="icon" sizes="512x512" href="{{ asset('imgs/favicons/android-chrome-192x192.png') }}">
        <!-- APP JS AND CSS -->
      
       @if(App::environment(['local', 'staging']))
        <link rel="stylesheet" href="{{ asset('css/app.css?v='.rand(1,99)) }}">
       @else
       <link rel="stylesheet" href="{{ asset('css/app.css') }}">
   
       @endif

      <script src="{{ asset('js/manifest.js') }}" defer></script>
      <script src="{{ asset('js/vendor.js') }}" defer></script>
      
     @if(App::environment(['local', 'staging']))
      <script src="{{ asset('js/app.js?v='.rand(1,99)) }}" defer></script>
    @else
     <script src="{{ asset('js/app.js') }}" defer></script>
    @endif
    
     @inertiaHead
  </head>
  <body>
    @inertia
    @if (app()->isLocal())
        <script src="http://localhost:3000/browser-sync/browser-sync-client.js"></script>
    @endif
  </body>
    <script>
       let appDataObj = {
       
        'appName': '{{env('APP_NAME')}}',
        'appEnv': '{{env('APP_ENV')}}',
       }
   
    </script>
</html>