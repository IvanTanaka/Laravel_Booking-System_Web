<!DOCTYPE html>
<!--
  This is a starter template page. Use this page to start your new project from
  scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  
  <title>Membee | Admin</title>
  @yield('head')
  @include('layouts.head')
  <style>
    #profile-image {
      width: 2.1rem;
      height: 2.1rem;
      border-radius: 50%;
      background: #512DA8;
      color: #fff;
      text-align: center;
      line-height: 2.1rem;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
    </nav>
    
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-primary elevation-4 sidebar-light-orange">
      <!-- Brand Logo -->
      <a href="{{url('/admin')}}" class="brand-link">
        <span class="brand-text logo" style="text-align:center; display:block;">membee</span>
      </a>
      
      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div id="profile-image" class="img-circle">
            {{-- <img src="/dist/img/user2-160x160.jpg" class=" img-circle elevation-2" alt="User Image"> --}}
          </div>
          <div class="info">
            <a href="#" class="d-block">{{ Auth::user()->name }}</a>
          </div>
        </div>
        
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
              
              <li class="nav-item">
                <a href="{{url('admin/')}}" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                  <i class="fas fa-home nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('admin/category')}}" class="{{ request()->is('admin/category*') ? 'active' : '' }} nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Franchise's Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('admin/redeem')}}" class="{{ request()->is('admin/redeem*') ? 'active' : '' }} nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Owner's Redeem</p>
                </a>
              </li>

              <li class="nav-item">
                
                <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>
                  Log Out
                </p>
              </a>
              
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
    
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      @yield('content')
    </div>
    <!-- /.content-wrapper -->
    
    <!-- Main Footer -->
    <footer class="main-footer">
      {{-- <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
          Anything you want
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved. --}}
      </footer>
    </div>
    <!-- ./wrapper -->
    
    <!-- REQUIRED SCRIPTS -->
    @include('layouts.script')
    @yield('script')
    <script>
      $(document).ready(function(){
        var name = "{{Auth::user()->name}}";
        var firstName = name.substring(0,name.indexOf(" "));
        var lastName = name.substring(name.indexOf(" ")+1);
        var intials = firstName.charAt(0) + lastName.charAt(0);
        var profileImage = $('#profile-image').text(intials);
      });
    </script>
  </body>
  </html>