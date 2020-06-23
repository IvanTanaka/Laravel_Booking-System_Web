@extends('layouts.base')
@section('head')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@endsection
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1 class="m-0 text-dark"></h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
  <div class="container-fluid">
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
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h1 class="m-0 text-dark">Edit Bank Account</h1>
          </div>
          <div class="card-body">
            <form action="{{ route('bank-account.update',["bank_account"=>$bank_account->id]) }}" method="POST" enctype='multipart/form-data'>
              @csrf
              @method('PUT')
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header card-form">
                      Bank Account
                    </div>
                    <div class="card-body table-responsive p-2">
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="bank_account_name">Name</label>
                            <div class="input-group">
                              <input placeholder="eg. John Doe" value="{{$bank_account->name}}" type="text" class="form-control" im-insert="true" id="bank_account_name" name="bank_account_name" required>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="bank_account_bank">Bank</label>
                            <select class="js-example-basic-single js-states form-control" id="bank_account_bank" name="bank_account_bank" required>
                                @include('owner.bank_account.bank')
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="bank_account_number">Bank Account Number</label>
                            <div class="input-group">
                            <input placeholder="eg. 9876543xxxxx" value="{{$bank_account->account_number}}" type="text" class="form-control" im-insert="true" id="bank_account_number" name="bank_account_number" required>
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
          </div>
        </div>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
  @endsection
  
  @section('script')
  <script>
    $(document).ready(function() {
        $('#bank_account_bank').val('{{$bank_account->bank}}');
        $('.js-example-basic-single').select2();
    });
  </script>
  @endsection