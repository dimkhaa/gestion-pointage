<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title>Argon Dashboard - Free Dashboard for Bootstrap 4</title>
  <!-- Favicon -->
  <link href="/img/brand/favicon.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="/js/vendor/nucleo/css/nucleo.css" rel="stylesheet">
  <link href="/js/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
  <!-- Argon CSS -->
  <link type="text/css" href="/css/argon.css?v=1.0.0" rel="stylesheet">

</head>

<body>
@include('partials.sidebar')
  <!-- Main content -->
  <div class="main-content">
    @include('partials.topbar')
    @include('partials.header-dashboard')

    <!-- Page content -->
      @yield('content')
      @include('partials.footer')
   </div>
  </div>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="/js/vendor/jquery/dist/jquery.min.js"></script>
  <script src="/js/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Optional JS -->
  <script src="/js/vendor/chart.js/dist/Chart.min.js"></script>
  <script src="/js/vendor/chart.js/dist/Chart.extension.js"></script>
  <!-- Datepicker -->
  <script src="/js/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

  <!-- Argon JS -->
  <script src="/js/argon.js?v=1.0.0"></script>


</body>

</html>
