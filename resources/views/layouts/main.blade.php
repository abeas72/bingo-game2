<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" "scroll-behavior: smooth">
    <head>
      @include('layouts.partials.head')
    </head>
    <body id="page-top">
         <!-- NavBar-->
          @include('layouts.partials.nav')

          <div id="wrapper">
              <!--Side Bar-->
              @include('layouts.partials.sidebar')

              <div id="content-wrapper">
                  <div class="container-fluid">
                      <!-- Breadcrumbs-->
                      @include('layouts.partials.breadcrumbs')
                      
                      <!-- Main content here-->
                        @yield('content')

                      <!-- Icon Cards-->
                      <!-- Area Chart Example-->
                      <!-- DataTables Example -->
                  </div>
                  <!-- /.container-fluid -->
                  
                  @include('layouts.partials.footer')
              </div>
              <!-- /.content-wrapper -->
          </div>
          <!-- /#wrapper -->

          <!-- Scroll to Top Button-->
          @include('layouts.partials.scrolltop')
          @include('layouts.partials.footer-scripts')
    </body>
</html>
