@extends('layouts.base')

@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js" defer></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" defer></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" defer></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" defer></script>
<style>
    .finished_order_status{
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
    .waiting_order_status{
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
    .accepted_order_status{
        font-weight: 700;
        width: 100%;
        display: inline-block;
        text-align: center;
        vertical-align: middle;
        user-select: none;
        color: #fff;
        background-color: #0509ff;
        padding: 10px;
        border-radius: 5px;
    }
    .no_response_order_status,.denied_order_status,.canceled_order_status{
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
                        <h1 class="m-0 text-dark">Order History</h1>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body table-responsive p-2">
                                        <table class="table table-bordered data-table" id="order_table">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Order Code</th>
                                                    <th>Customer</th>
                                                    <th>Customer Phone</th>
                                                    <th>Cashier</th>
                                                    <th>Cashier Username</th>
                                                    <th>Branch</th>
                                                    <th>Rate</th>
                                                    <th>Comment</th>
                                                    <th>Reserve Time</th>
                                                    <th>Orders</th>
                                                    <th>Order Note</th>
                                                    <th>Dine In / Take Out</th>
                                                    <th>Total</th>
                                                    <th>Status</th>
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
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(function () {
        var table = $('#order_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{Request::url()}}",
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'order_code', name: 'order_code'},
            {data: 'customer', name: 'customer'},
            {data: 'customer_phone', name: 'customer_phone'},
            {data: 'cashier', name: 'cashier'},
            {data: 'cashier_username', name: 'cashier_username'},
            {data: 'branch', name: 'branch'},
            {data: 'rate', name: 'rate'},
            {data: 'comment', name: 'comment'},
            {data: 'reserve_time', name: 'reserve_time'},
            {data: 'orders', name:'orders'},
            {data: 'note', name:'note'},
            {data: 'dine_in_or_take_out', name: 'dine_in_or_take_out', orderable: false},
            {data: 'total', name: 'total'},
            {data: 'status', name: 'status', orderable: false},
            ]
        });
        
    });
</script>
@endsection