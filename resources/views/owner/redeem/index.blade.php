@extends('layouts.base')
@section('head')
  <style>
  .balance-amount{
    color: #FF7266 !important;
    font-weight: 700;
    font-size: 5vh !important;  
  }
  .middle > * {
    vertical-align: middle;
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

    </style>
@endsection
@section('content')
    
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark">Redeem</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card redeem-header-container">
              <div class="card-header">
                <h5 class="m-0">Balance Amount</h5>
              </div>
              <div class="card-body">

                <div class="middle" >
                  <span>Your current balance : </span>
                </div>
                <div class="text-center">
                  <span class="balance-amount" id="redeem_total_balance">Rp. {{$franchise->amount}}</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card redeem-header-container">
              <div class="card-header">
                <h5 class="m-0">Redeem Amount</h5>
              </div>
              <div class="card-body">
                <div class="text-center">
                  <input type="number" id="redeem_input" name="redeem_amount" class="form-control" onkeyup="checkZero()" value="0">
                </div>
                <div class="text-center">
                  <span class="balance-amount" id="redeem_amount">Rp. 0</span>
                </div>
                <div class="text-center bottom-center">
                  <button id="redeem_button" class="btn btn-primary-membee btn-success btn-lg disabled" style="width: 100%">Redeem</button>
                </div>
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@section('script')
    <script>
      const redeem_input = document.getElementById('redeem_input');
      const redeem_amount = document.getElementById('redeem_amount');
      const redeem_total_balance = document.getElementById('redeem_total_balance');
      const redeem_button = document.getElementById('redeem_button');

      const inputHandler = function(e) {
        if(e.target.value<={{$franchise->amount}}&&e.target.value>=0){
          redeem_amount.innerHTML = "Rp. "+e.target.value;
          redeem_total_balance.innerHTML = "Rp. "+({{$franchise->amount}}-e.target.value);
          redeem_button.classList.remove("disabled");
        }else if(e.target.value<0){
          redeem_button.classList.add("disabled");
          redeem_amount.innerHTML = "Rp. 0";
          redeem_total_balance.innerHTML = "Rp. {{$franchise->amount}}";
          redeem_input.value = 0;
        }else if(e.target.value>{{$franchise->amount}}){
          redeem_amount.innerHTML = "Rp. {{$franchise->amount}}";
          redeem_total_balance.innerHTML = "Rp. 0";
          redeem_input.value = {{$franchise->amount}};
          redeem_button.classList.remove("disabled");
        }
      }

      function checkZero(){
        if(redeem_input.value.length == 0){
          redeem_amount.innerHTML = "Rp. 0";
          redeem_total_balance.innerHTML = "Rp. {{$franchise->amount}}";
          redeem_input.value = 0;
        }else{
          redeem_input.value = parseInt(redeem_input.value);
          redeem_amount.innerHTML = "Rp. "+redeem_input.value;
        }
      }

      redeem_input.addEventListener('input', inputHandler);
      redeem_input.addEventListener('propertychange', inputHandler);
    </script>
@endsection