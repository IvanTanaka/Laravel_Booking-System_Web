@extends('layouts.cashier_base')

@section('head')
    <style>
        .card-membee .card-header, .bg-membee{
            background-color: #FF7266 !important;
            color: #fff;
        }
    </style>
@endsection
@section('content')
    
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-12">
          <h1 class="m-0 text-dark">Welcome {{Auth::user()->name}}</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">

          <div class="col-12 col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-membee elevation-1"><i class="fas fa-star"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Rating</span>
                <span class="info-box-number">
                  {{ number_format($rateTotal, 1)}}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


          <div class="col-12 col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-membee elevation-1"><i class="fas fa-user-friends"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Today's Sales</span>
                <span class="info-box-number">
                  {{$todaySale}}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection