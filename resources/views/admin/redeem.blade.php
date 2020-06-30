@extends('layouts.admin_base')

@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js" defer></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" defer></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" defer></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" defer></script>
<style>
    .finished_redeem_status{
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
    .accepted_redeem_status{
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
    .rejected_redeem_status{
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
                <h1 class="m-0 text-dark">
                </h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->


<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                    
                        <h1 class="m-0 text-dark">
                            Redeem List
                            <div class="float-right">
                                <a href="{{url('admin/redeem/finished-multiple')}}">
                                    <button class="btn btn-success">
                                        <i class="fas fa-check"></i>
                                        Finished all Accepted
                                    </button>
                                </a>
                                <a href="{{url('admin/redeem/print-pdf')}}">
                                    <button class="btn btn-info">
                                        <i class="fas fa-download"></i>
                                        download
                                    </button>
                                </a>
                            </div>
                        </h1>
                    </div>
                    <div class="card-body table-responsive p-2">
                        <table class="table table-bordered data-table" id="redeem_table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Redeem At</th>
                                    <th>Owner Name</th>
                                    <th>Phone Number</th>
                                    <th>Franchise</th>
                                    <th>Bank</th>
                                    <th>Bank Account Number</th>
                                    <th>Amount</th>
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
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(function () {
        var table = $('#redeem_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{Request::url()}}",
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'created', name: 'created'},
            {data: 'owner_name', name: 'owner_name'},
            {data: 'owner_phone_number', name: 'owner_phone_number'},
            {data: 'franchise_name', name:'franchise_name'},
            {data: 'bank', name: 'bank'},
            {data: 'bank_account_number', name: 'bank_account_number'},
            {data: 'amount', name: 'amount'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        
    });
</script>
@endsection