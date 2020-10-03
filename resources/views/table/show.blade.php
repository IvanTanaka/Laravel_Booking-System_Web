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
        <h1 class="m-0 text-dark">Table Management</h1>
        <a href="{{route('table.create')}}" class="btn btn-info" >Create New Table</a>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <table class = "table">
            <thead>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Size</th>
                <th scope="col">Action</th>
            </thead>
            <tbody>

                @foreach ($tables as $table)
                <tr>
                    <th  scope="row">{{$table->id}}</th>
                    <td>{{$table->number}}</td>
                    <td>{{$table->size}}</td>
                    <td>
                    <div >
                        <a href="{{{$table->id}}}/edit" class="btn btn-info">edit</a>
                            <form method ="POST" action="{{route( 'table.destroy', $table->id) }}">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button class = "btn btn-danger">Delete table</button>
                            </form>
                    </div>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
      </div>
    </div>
</div>
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
