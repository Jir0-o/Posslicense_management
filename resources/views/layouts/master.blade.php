<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-menu-fixed layout-compact"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard - Analytics Workflow</title>

    <meta name="description" content="" />

    <!-- FullCalendar CSS -->
    <link href='https://unpkg.com/@fullcalendar/core@4.4.0/main.css' rel='stylesheet' />
    <link href='https://unpkg.com/@fullcalendar/daygrid@4.4.0/main.css' rel='stylesheet' />
    <link href='https://unpkg.com/@fullcalendar/timegrid@4.4.0/main.css' rel='stylesheet' />
    <link href='https://unpkg.com/@fullcalendar/timeline@4.4.0/main.css' rel='stylesheet' />
    <link href='https://unpkg.com/@fullcalendar/resource-timeline@4.4.0/main.css' rel='stylesheet' />
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js'></script>
    <script src='https://unpkg.com/@fullcalendar/core@4.4.0/main.js'></script>
    <script src='https://unpkg.com/@fullcalendar/daygrid@4.4.0/main.js'></script>
    <script src='https://unpkg.com/@fullcalendar/timegrid@4.4.0/main.js'></script>
    <script src='https://unpkg.com/@fullcalendar/timeline@4.4.0/main.js'></script>
    <script src='https://unpkg.com/@fullcalendar/resource-common@4.4.0/main.js'></script>
    <script src='https://unpkg.com/@fullcalendar/resource-timeline@4.4.0/main.js'></script>
    <script src='https://unpkg.com/@fullcalendar/interaction@4.4.0/main.js'></script>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="{{asset('template/assets/vendor/fonts/boxicons.css')}}" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />


    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('template/assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('template/assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('')}}template/assets/css/demo.css" />



    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{asset('template/assets/vendor/libs/apex-charts/apex-charts.css')}}" />
    {{-- Datatable CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />

    {{-- select2 --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- Include Toastr CSS in the <head> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>

    <!-- Toastify CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{asset('template/assets/vendor/js/helpers.js')}}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('template/assets/js/config.js')}}"></script>
      {{-- sweet alart --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.min.css
    " rel="stylesheet">
    
  <!-- Include Select2 JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">

        @include('backend.includes.side-nav')
        <!-- Layout container -->
        <div class="layout-page">

          @include('backend.includes.nav')
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              @yield('content')
            </div>
            <!-- / Content -->
            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->
    <!-- Toastify JS -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="{{asset('template/assets/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{asset('template/assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{asset('template/assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{asset('template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('template/assets/vendor/js/menu.js')}}"></script>
    <script src="{{asset('template/assets/vendor/js/select2.min.js')}}"></script>



    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{asset('template/assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>

    <!-- Main JS -->
    <script src="{{asset('template/assets/js/main.js')}}"></script>

    <!-- Page JS -->
    <script src="{{asset('template/assets/js/dashboards-analytics.js')}}"></script>
      <!-- Include jQuery first -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    {{-- Datatable Scripts --}}
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <!-- Bootstrap JavaScript Bundle -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>

    {{-- sweet Alart --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Full Calendar JS --}}
     <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.34/moment-timezone-with-data.min.js"></script>

    {{-- select 2 --}}

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script>
        new DataTable('#datatable');
        new DataTable('#datatable1');
        new DataTable('#datatable2');
        new DataTable('#datatable3');
        new DataTable('#datatable4');
        new DataTable('#datatable5');
        new DataTable('#datatable6');
        new DataTable('#datatable7');
        new DataTable('#datatable8');
        new DataTable('#datatable9');
    </script>
  <!-- Bootstrap JS, if you are using Bootstrap -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <!-- Include Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <!-- Include CKEditor JS -->
  <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

  <!-- Include Toastr JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- sweet Alart --}}

  <script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.all.min.js
"></script>
  </body>
</html>
