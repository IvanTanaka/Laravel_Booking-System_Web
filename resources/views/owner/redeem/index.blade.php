@extends('layouts.base')
@section('head')
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js" defer></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" defer></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" defer></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" defer></script>
  <style>
  .balance-amount{
    color: #FF7266 !important;
    font-weight: 700;
    font-size: 2rem !important;  
  }
  .middle > * {
    vertical-align: middle !important;
    font-size: 28px;
  }
  .redeem-header-container{
    height: 250px;
  }
  .bottom-center{
    position: absolute;
    bottom: 0;
    right: 0;
    left: 0;
    margin: 20px;
  }
    .accepted_redeem_status{
        font-weight: 700;
        width: 100%;
        display: inline-block;
        text-align: center;
        vertical-align: middle;
        user-select: none;
        color: #fff;
        background-color: #1fb800;
        padding: 10px;
        border-radius: 5px;
    }
    .waiting_redeem_status{
        font-weight: 700;
        width: 100%;
        display: inline-block;
        text-align: center;
        vertical-align: middle;
        user-select: none;
        color: #000;
        background-color: #ffe205;
        padding: 10px;
        border-radius: 5px;
    }
    .rejected_redeem_status, .canceled_redeem_status{
        font-weight: 700;
        width: 100%;
        display: inline-block;
        text-align: center;
        vertical-align: middle;
        user-select: none;
        color: #fff;
        background-color: #ff0505;
        padding: 10px;
        border-radius: 5px;
    }

    </style>
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
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                  <h1 class="m-0 text-dark">Redeem</h1>
              </div>
              <div class="card-body">
                <form action="{{url('redeem')}}" method="POST">
                  @csrf
                  <div class="row">
                    <div class="col-md-4">
                      <div class="card redeem-header-container">
                        <div class="card-header card-form">
                          <h5 class="m-0">Balance Amount</h5>
                        </div>
                        <div class="card-body">

                          <div class="middle" >
                            <span>Your current balance : </span>
                          </div>
                          <div class="text-center">
                            <span class="balance-amount" id="redeem_total_balance">Rp {{number_format($franchise->amount,2,',','.')}}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="card redeem-header-container">
                        <div class="card-header card-form">
                          <h5 class="m-0">Redeem Amount</h5>
                        </div>
                        <div class="card-body">
                          <div>
                            <input type="number" id="redeem_input" name="redeem_amount" class="form-control" onkeyup="checkZero()" value="0">
                            
                            <small id="minimum amount" class="form-text text-muted">* Minimum Rp 10.000</small>
                          </div>
                          <div class="text-center">
                            <span class="balance-amount" id="redeem_amount">Rp 0</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    @if($bank_account != null)
                    <div class="col-md-4">
                      <div class="card redeem-header-container">
                        <div class="card-header card-form">
                          <h5 class="m-0">Bank Account  <a class="btn btn-info btn-sm" style="position: absolute; top:8px;right:10px;" href="{{url('bank-account')}}"><i class="fas fa-edit"></i></a></h5>
                        </div>
                        <div class="card-body">
                          <div class = "row">
                            <div class="col-12">
                            <input type="hidden" name="bank_account_id" value="{{$bank_account->id}}">
                              Name : {{$bank_account->name}}<br>
                              Bank : {{$bank_account->bank}}<br>
                              Bank Account Number : {{$bank_account->account_number}}<br> 
                            </div>
                          </div>
                          <div class="text-center bottom-center">
                          <button type="submit" id="redeem_button" class="btn btn-primary-membee btn-success btn-lg disabled" style="width: 100%; color:white;">Redeem</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /.col-md-6 -->
                    @else
                    <div class="col-4">
                      <div class="card redeem-header-container">
                        <div class="card-header card-form">
                          &nbsp;
                        </div>
                        <div class="card-body">
                          <h3>
                          Please Add your Bank Account
                            <div class="bottom-center">
                              <a class="btn btn-info btn-lg" style="width: 100%; "href="{{url('bank-account')}}"><i class="fas fa-plus"></i> Add Bank Account</a>
                            </div>
                          </h3>
                        </div>
                      </div>
                    </div>
                    @endif

                  </div>
                  <div class="row">

                    <div class="col-lg-12">
                      <div class="card">
                          <div class="card-body table-responsive p-2">
                              <table class="table table-bordered data-table" id="redeem_table">
                                  <thead>
                                      <tr>
                                          <th>No</th>
                                          <th>Redeem At</th>
                                          <th>Amount</th>
                                          <th>Bank Name</th>
                                          <th>Bank</th>
                                          <th>Account Number</th>
                                          <th>Status</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                              </table>
                          </div>
                          <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
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

      $(function () {
        var table = $('#redeem_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{Request::url()}}",
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'created', name: 'created'},
            {data: 'amount', name: 'amount'},
            {data: 'bank_name', name: 'bank_name'},
            {data: 'bank', name: 'bank'},
            {data: 'account_number', name: 'account_number'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        
      });

      const redeem_input = document.getElementById('redeem_input');
      const redeem_amount = document.getElementById('redeem_amount');
      const redeem_total_balance = document.getElementById('redeem_total_balance');
      const redeem_button = document.getElementById('redeem_button');

      const inputHandler = function(e) {
        if(e.target.value<={{$franchise->amount}}&&e.target.value>=0){
          redeem_amount.innerHTML = "Rp "+number_format(e.target.value,2,',','.');
          redeem_total_balance.innerHTML = "Rp "+number_format({{$franchise->amount}}-e.target.value,2,',','.');
          if(e.target.value>=10000){
          redeem_button.classList.remove("disabled");
          }else{
            redeem_button.classList.add("disabled");
          }
        }else if(e.target.value<0){
          redeem_button.classList.add("disabled");
          redeem_amount.innerHTML = "Rp 0";
          redeem_total_balance.innerHTML = "Rp {{number_format($franchise->amount,2,',','.')}}";
          redeem_input.value = 0;
        }else if(e.target.value>{{$franchise->amount}}){
          redeem_amount.innerHTML = "Rp {{number_format($franchise->amount,2,',','.')}}";
          redeem_total_balance.innerHTML = "Rp 0";
          redeem_input.value = {{$franchise->amount}};
          if(e.target.value>=10000){
          redeem_button.classList.remove("disabled");
          }else{
            redeem_button.classList.add("disabled");
          }
        }
      }

      function checkZero(){
        if(redeem_input.value.length == 0){
          redeem_amount.innerHTML = "Rp 0";
          redeem_total_balance.innerHTML = "Rp {{number_format($franchise->amount,2,',','.')}}";
          redeem_input.value = 0;
        }else{
          redeem_input.value = parseInt(redeem_input.value);
          redeem_amount.innerHTML = "Rp "+number_format(redeem_input.value,2,',','.');
        }
      }

      function number_format (number, decimals, decPoint, thousandsSep) {

        number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
        var n = !isFinite(+number) ? 0 : +number
        var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
        var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
        var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
        var s = ''

        var toFixedFix = function (n, prec) {
          if (('' + n).indexOf('e') === -1) {
            return +(Math.round(n + 'e+' + prec) + 'e-' + prec)
          } else {
            var arr = ('' + n).split('e')
            var sig = ''
            if (+arr[1] + prec > 0) {
              sig = '+'
            }
            return (+(Math.round(+arr[0] + 'e' + sig + (+arr[1] + prec)) + 'e-' + prec)).toFixed(prec)
          }
        }

        // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec).toString() : '' + Math.round(n)).split('.')
        if (s[0].length > 3) {
          s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
        }
        if ((s[1] || '').length < prec) {
          s[1] = s[1] || ''
          s[1] += new Array(prec - s[1].length + 1).join('0')
        }

        return s.join(dec)
      }

      redeem_input.addEventListener('input', inputHandler);
      redeem_input.addEventListener('propertychange', inputHandler);
    </script>
@endsection