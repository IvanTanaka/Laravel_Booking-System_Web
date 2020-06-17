@extends('layouts.admin_base')

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
                <h1 class="m-0 text-dark">Franchise's Categories
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
                    <div class="card-body table-responsive p-2">
                        <table class="table table-bordered data-table" id="category_table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Franchise</th>
                                    <th>Owner Name</th>
                                    <th>Phone Number</th>
                                    <th>Category</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
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
        var table = $('#category_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{Request::url()}}",
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name:'name'},
            {data: 'owner_name', name: 'owner_name'},
            {data: 'owner_phone_number', name: 'owner_phone_number'},
            {data: 'category_select', name: 'category_select', orderable: false, searchable: false},
            ]
        });
        
    });

    function setCategory($this,$franchise_id){
        $.post("/admin/category/update",
        {
            _token : "{{ csrf_token() }}",
            category_id: $this.value,
            franchise_id: $franchise_id
        });
    }
</script>
@endsection