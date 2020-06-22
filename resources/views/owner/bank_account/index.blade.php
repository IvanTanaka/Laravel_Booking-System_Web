@extends('layouts.base')
@section('head')
<style>
  .default-card{
    border: 5px solid #28a745 !important;
  }

  .hidden{
    visibility: hidden;
  }
  </style>
@endsection
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1 class="m-0 text-dark">Bank Account 
          <a class="btn btn-success" style="float:right;" href="{{route('bank-account.create')}}"><i class="fas fa-plus"></i> Add New Bank Account</a></h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
    @forelse ($bank_accounts as $bank_account)
      <div class="col-12 col-sm-6 col-md-6 col-lg-4">
        <div class="card redeem-header-container {{($bank_account->is_default)?'default-card':''}}">
          <div class="card-body">
            <div class = "row">
              <div class="col-12" style="margin-bottom: 20px;">
                Name : {{$bank_account->name}}<br>
                Bank : {{$bank_account->bank}}<br>
                Bank Account Number : {{$bank_account->account_number}}<br> 
              </div>
              <div class="col-6">
              <button class="btn btn-success default-button {{($bank_account->is_default)?'hidden':''}}" bank-account-id="{{$bank_account->id}}">Set As Default</button>
              </div>
              <div class="col-6 middle">

                <form id="deleteId" action="bank-account/{{$bank_account->id}}" method="post">
                  @method('DELETE')
                  @csrf
                  <button class="btn btn-danger" style="float: right; margin-left:5px; margin-right:5px;" type="submit"><i class="fas fa-trash"></i></button>
                </form>
                <a class="btn btn-info" style="float: right; margin-left:5px; margin-right:5px;" href="{{route('bank-account.edit',['bank_account'=>$bank_account->id])}}"><i class="fas fa-edit"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.col-md-6 -->
      @empty
      <div class="col-12 col-sm-6 col-md-6 col-lg-4">
        <div class="card">
          <div class="card-body">
            <h3>
            Please Add your Bank Account
            </h3>
          </div>
        </div>
      </div>

    @endforelse
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
  @endsection
  
  @section('script')
  <script>
    $('.default-button').on('click', function(e){
      $('.default-card').removeClass('default-card');
      $('.default-button').removeClass('hidden');
      $(this).closest('.card').addClass('default-card');
      $(this).addClass('hidden');
      var bank_account_id = $(this).attr('bank-account-id');
      $.post("{{url('/bank-account/default')}}",
        {
            _token : "{{ csrf_token() }}",
            bank_account_id: bank_account_id
        });
    });
  </script>
  @endsection