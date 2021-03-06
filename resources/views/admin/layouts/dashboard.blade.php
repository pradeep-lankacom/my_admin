<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="UTF-8">
    <title>{{ $page_title or "AdminLTE Dashboard" }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	
	  <!-- Bootstrap 3.3.2 -->
	 <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
	  <!-- Font Awesome -->
	  <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
	  <!-- Ionicons -->
	  <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
	  <!-- Theme style -->
	  <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
	  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
			page. However, you can choose any other skin. Make sure you
			apply the skin class to the body tag so the changes take effect. -->
	  <link rel="stylesheet" href="{{ asset('dist/css/skins/skin-blue.min.css') }}">
	  
	 <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
     @include('layouts.includes.header')
  
  <!-- Left side column. contains the logo and sidebar -->
     @include('layouts.includes.sidebar')
 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Page Header
        <small>Optional description</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
      @yield('content')
  
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
   @include('layouts.includes.footer')
  <div class="control-sidebar-bg"></div>
  
  
</div>
<!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="{{ asset ('bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset ('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset ('dist/js/adminlte.min.js') }}"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
  </body>
</html>