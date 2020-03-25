@extends('layouts.base')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1 class="m-0 text-dark">Edit @if($branch->franchise->name != $branch->name){{$branch->franchise->name}} - @endif{{$branch->name}}</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->


<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    
    <form action="{{ route('stores.update',$branch->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="row">
        @if ($message = Session::get('error'))
        <div class="col-lg-12">
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Error!</h5>
            {{$message}}
          </div>
        </div>
        @elseif($errors->any())
        <div class="col-lg-12">
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Error!</h5>
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        </div>
        @endif
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body table-responsive p-2">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="store_name">Branch Name</label>
                    <div class="input-group">
                      <input type="text" class="form-control" im-insert="true" id="store_name" name="store_name" required value="{{$branch->name}}" placeholder="Cab. Diponegoro, Cab. Cemara">
                    </div>
                    <!-- /.input group -->
                  </div>
                  <div class="form-group">
                    <label for="store_address">Address</label>
                    <textarea id="store_address" class="form-control" rows="4" name="store_address">{{$branch->address}}</textarea>
                  </div>
                  <div class="form-group">
                    <label for="store_phone_number">Phone Number</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                      </div>
                      <input type="tel" class="form-control" im-insert="true" id="store_phone_number" name="store_phone_number" required autocomplete="phone_number" value="{{$branch->phone_number}}">
                    </div>
                    <!-- /.input group -->
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="store_open_time">Open Time</label>
                    <div class="input-group date" id="store_open_time" data-target-input="nearest" name="store_open_time">
                      <input type="text" class="form-control datetimepicker-input" data-target="#store_open_time" name="store_open_time" value="{{$branch->open_time}}">
                      <div class="input-group-append" data-target="#store_open_time" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="store_close_time">Close Time</label>
                    <div class="input-group date" id="store_close_time" data-target-input="nearest" name="store_close_time">
                      <input type="text" class="form-control datetimepicker-input" data-target="#store_close_time" name="store_close_time" value="{{$branch->close_time}}">
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
          <div class="float-right">
            <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Discard</button>
            <button type="submit" class="btn btn-success"><i class="far fa-save"></i> Save</button>
          </div>
        </div>
      </div>
      <!-- /.row -->
    </form>
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection