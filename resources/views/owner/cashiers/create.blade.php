@extends('layouts.base')

@section('head')
@endsection

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1 class="m-0 text-dark">Create Cashier</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->


<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    
    <form action="{{ route('cashiers.store') }}" method="POST" enctype='multipart/form-data' autocomplete="off">
      @csrf
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
                    <label for="cashier_name">Name</label>
                    <div class="input-group">
                      <input type="text" class="form-control" im-insert="true" id="cashier_name" name="cashier_name" required>
                    </div>
                    <!-- /.input group -->
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="cashier_branch">Branch Store</label>
                    <select class="form-control custom-select" name="cashier_branch" required>
                      <option selected disabled>Select the cashier location</option>
                      @foreach ($branches as $branch)
                      <option value="{{$branch->id}}">{{$branch->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="cashier_username">Username</label>
                    <div class="input-group">
                      <input type="text" class="form-control" im-insert="true" autocomplete="new-password" id="cashier_username" name="cashier_username" onkeyup="return forceLower(this);" required>
                      <div class="input-group-append">
                        <span class="input-group-text">_{{strtolower(Auth::user()->franchise->name)}}</span>
                      </div>
                    </div>
                    <!-- /.input group -->
                  </div>
                  <div class="form-group">
                    <label for="cashier_password">Password</label>
                    <div class="input-group">
                      <input type="password" class="form-control" im-insert="true" autocomplete ="new-password" id="cashier_password" name="cashier_password" required>
                    </div>
                    <!-- /.input group -->
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

@section('script')
<script type="text/javascript">
  
  function forceLower(strInput){
    strInput.value=strInput.value.toLowerCase();
  }  

</script>
@endsection