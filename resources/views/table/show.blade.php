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
@endsection

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
          <div class="card">
                <div class="card-header">
                    <h1 class="m-0 text-dark">Table Management</h1>
                    {{-- <a href="{{route('table.create')}}" class = "btn btn-info" value="{{$request()->get('branch_id')}}" name="branch_id">
                    Create New Table</a> --}}
                    <form action="{{route('table.create')}}">
                        <input type ="hidden" value="{{request()->get('branch_id')}}" name ="branch_id">
                        <input type="submit" value="Create new table" class="btn btn-info">
                    </form>
                </div>
                <div class="card-body">

                    <!-- /.content-header -->
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <table class = "table ">
                                 <thead>
                                        <th scope="col">No</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Size</th>
                                        <th scope="col">Action</th>
                                        <th></th>
                                </thead>
                                <tbody>
                                    <?php $number = 1; ?>
                                    @foreach ($tables as $table)
                                    <tr>
                                        <th  scope="row">{{ $number++ }}</th>
                                        <td>{{$table->number}}</td>
                                        <td>{{$table->size}}</td>
                                        <td>
                                            {{-- <a href="/table/{{$table->id}}/edit" class="btn btn-info">Edit Table</a> --}}
                                            <a href="/table/{{$table->id}}/edit" class="btn btn-info">Edit Table</a>
                                        </td>
                                        <td>
                                            <form method ="POST" action="{{route( 'table.destroy', $table->id) }}">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button class = "btn btn-danger">Delete table</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach

                                 </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
          </d   iv>
      </div>
        {{-- <a href="{{route('table.create',$var)}}" class="btn btn-info" >Create New Table</a> --}}

      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->

      @endsection

@section('script')
    <script type="text/javascript">
        $('select').on('change', function() {
            alert( this.value );
            selectedVal = this.value;
            alert(selectedVal);

            $.ajax({
                type: "POST",
            cache: false,
            url : "{{url('table.index')}}",
            data: { sem : selectedVal },
            });
    });
    </script>
@endsection
