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
      <div class="col-sm-12">
            <div class="card card-membee">
                <div class="card-header">
                    <h3 class="card-title">Table Management</h3>
                </div>

                <div class="card-body">
                <div class="content">
                    <div class="form-group">
                            <div class="row mb-2">
                                    <div class="col-sm-12">
                                            <table class="table table-hover table-bordered data-table" id="index_table">
                                                <thead class="thead-light">
                                                    <th>No</th>
                                                    <th>Branch Store</th>
                                                    <th>Branch Address</th>
                                                </thead>
                                                <tbody></tbody>
                                                <tfoot></tfoot>
                                                {{-- @foreach ($branches as $branch)
                                                    <tbody>
                                                        <th scope="row">{{$number++}}</th>
                                                        <td scope="row"><a class="btn btn-outline-secondary" href="{{route('table.index',['branch_id'=>$branch->id])}}" >
                                                            {{$branch->name}}</td>  </a>
                                                        <td> <a class="btn" href="{{route('table.index',['branch_id'=>$branch->id])}}" >
                                                            {{$branch->address}}</td> </a>
                                                    </tbody>
                                                @endforeach --}}
                                            </table>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
          </div>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<!-- /.content-header -->

      @endsection

@section('script')
    <script type="text/javascript">
    //     $('select').on('change', function() {
    //         alert( this.value );
    //         selectedVal = this.value;
    //         alert(selectedVal);

    //         $.ajax({
    //             type: "POST",
    //         cache: false,
    //         url : "{{url('table.index')}}",
    //         data: { sem : selectedVal },
    //         });
    // });
    $(function () {
        var table = $('#index_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('table.index')}}",
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'address', name: 'address'},
            ]
        });

    });

    </script>
@endsection
