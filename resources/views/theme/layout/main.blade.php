<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{asset('/img/images_app/favico.png')}}">
    <title>@yield('page_title')</title>
   @include('theme.layout.main_css')
  </head>
  <body class="slim-sticky-header">
    @include('theme.layout.header')
    @include('theme.layout.navbar')
    <div class="slim-mainpanel">
      <div class="container">
        @yield('page_header')
        @yield('page_content')
      </div><!-- container -->
    </div><!-- slim-mainpanel -->
    @include('theme.layout.main_js')
    @include('theme.admin.page.changePassword')  
  </body>
</html>
