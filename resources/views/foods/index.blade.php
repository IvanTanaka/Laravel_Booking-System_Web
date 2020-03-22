@extends('layouts.base')

@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js" defer></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" defer></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" defer></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" defer></script>

@endsection

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Menu Management
                <span class="float-right">
                <a href="{{route('foods.create')}}" class="btn btn-success"><i class="fas fa-plus"></i> Add Food or Beverages</a>
                </span>
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
            @if ($message = Session::get('success'))
            <div class="col-lg-12">
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-check"></i> Success!</h5>
                    {{$message}}
                </div>
            </div>
            @endif
            @if ($message = Session::get('error'))
            <div class="col-lg-12">
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    {{$message}}
                </div>
            </div>
            @endif
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body table-responsive p-2">
                        <table class="table table-bordered data-table" id="food_table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Description</th>
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
<!-- /.content -->
<div class="modal fade" id="deleteConfirmation" aria-hidden="true">
    <form id="deleteId" action="" method="post">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Are you sure?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="_method" value="DELETE" />
                    {{csrf_field()}}
                    Delete <span id="deleteName"></span>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-danger btn-small" type="submit">
                        <i class="fas fa-trash" style="width:20px"></i> Delete
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </form>
</div>
<!-- /.modal -->
@endsection

@section('script')
<script type="text/javascript">
    $(function () {
        var table = $('#food_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{url('foods')}}",
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'price', name: 'price'},
            {data: 'description', name: 'description'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        
    });
    
    $('#deleteConfirmation').on('shown.bs.modal', function(event) {
        var link     = $(event.relatedTarget),
        modal    = $(this),
        id = link.data("id"),
        name = link.data("name");
        modal.find("#deleteId").attr('action','foods/'+id);
        modal.find("#deleteName").text(name);
    });
</script>
@endsection