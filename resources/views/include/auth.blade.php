<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact " dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('/') }}" data-template="vertical-menu-template" data-style="light">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com/">
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;ampdisplay=swap" rel="stylesheet">

        @include('include/headcss')
        @yield('customcss')

        <!-- Helpers -->
        <script src="{{ asset('vendor/js/helpers.js') }}"></script>
        <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
        <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
        <script src="{{ asset('vendor/js/template-customizer.js') }}"></script>
        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src="{{ asset('js/config.js') }}"></script>
    </head>
    <body>

        
        <div class="position-relative">
         <!-- Logo -->
          <!-- <a href="index.php" class="auth-cover-brand d-flex align-items-center gap-2">
             <span class="app-brand-logo demo">
                <img src="{{ asset('assets/images/logo.png') }}" height="40">
             </span>
                 <span class="app-brand-text demo text-heading fw-semibold">Idoge</span>
          </a>   -->
         <!-- /Logo -->
         <div class="authentication-wrapper authentication-basic container-p-y p-4 p-sm-0">
            <div class="authentication-inner row m-0">
                 @yield('content')
            </div>
        </div>
     </div>


        @include('include/footjs')
        @yield('customjs')
    </body>
</html>
