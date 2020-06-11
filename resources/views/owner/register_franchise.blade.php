@extends('layouts.base')
@section('content')


<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1 class="m-0 text-dark">Register Franchise</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <form action="{{ url('/register/franchise') }}" method="post">
      {{ csrf_field() }}
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Franchise</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="franchise_name">Name</label>
                    <input type="text" id="franchise_name" name="franchise_name" class="form-control">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="franchise_type">Type</label>
                    <select class="form-control custom-select" name="franchise_type">
                      <option selected disabled>Select one</option>
                      @foreach ($service_type as $service)
                      <option value="{{$service["type"]}}">{{$service["text"]}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Store</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="store_address">Address</label>
                    <textarea id="store_address" class="form-control" rows="4" name="store_address"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="store_phone_number">Phone Number</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                      </div>
                      <input type="tel" class="form-control" im-insert="true" id="store_phone_number" name="store_phone_number" required autocomplete="phone_number">
                    </div>
                    <!-- /.input group -->
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="store_open_time">Open Time</label>
                    <div class="input-group date" id="store_open_time" data-target-input="nearest" name="store_open_time">
                      <input type="text" class="form-control datetimepicker-input" data-target="#store_open_time" name="store_open_time">
                      <div class="input-group-append" data-target="#store_open_time" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="store_close_time">Close Time</label>
                    <div class="input-group date" id="store_close_time" data-target-input="nearest" name="store_close_time">
                      <input type="text" class="form-control datetimepicker-input" data-target="#store_close_time" name="store_close_time">
                      <div class="input-group-append" data-target="#store_close_time" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          
          <!-- /.card -->
        </div>
        
      </div>
      
      <div class="row">
        <div class="col-12">
          <input type="submit" value="Save" class="btn btn-success float-right">
        </div>
      </div>
    </form>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection