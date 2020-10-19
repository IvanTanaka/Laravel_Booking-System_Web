@extends('layouts.base')

@section('head')
<style>
  input[type='number'] {
    -moz-appearance:textfield;
  }

  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
  }
</style>
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
      <div class="col-sm-12">
          <div class="card">
                <div class="card-header">
                    <h3 class="m-0 text-dark">Table Management</h3>
                    <form action="{{route('table.create')}}">
                        <input type ="hidden" value="{{request()->get('branch_id')}}" name ="branch_id">
                        <input type="submit" value="Create new table" class="btn btn-info">
                    </form>
                </div>
                <div class="card-body">
                    <div class="row">
                    <!-- /.content-header -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body table-responsive p-2">
                                    <table class = "table table-bordered data-table" id="show_table" >
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Size</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
          </div>
      </div>

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
        {{-- <a href="{{route('table.create',$var)}}" class="btn btn-info" >Create New Table</a> --}}

      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->

      @endsection

 @section('script')
    <script type="text/javascript">
    $(function () {
        var table = $('#show_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{Request::fullUrl()}}",
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'number', name: 'number'},
            {data: 'size', name: 'size'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

    });

    $('#deleteConfirmation').on('shown.bs.modal', function(event) {
        var link     = $(event.relatedTarget),
        modal    = $(this),
        id = link.data("id"),
        name = link.data("name");
        modal.find("#deleteId").attr('action','table/'+id);
        modal.find("#deleteName").text(number);
    });
    </script>
@endsection
