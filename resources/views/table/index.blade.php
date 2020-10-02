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
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="form-group">
    <label for="cashier_branch">Branch Store</label>
    <select class="form-control custom-select" name="branch" required>
      <option selected disabled>Select the branch</option>
      @foreach ($branches as $branch)
      <option value="{{$branch->id}}">{{$branch->name}}</option>
      @endforeach
    </select>
  </div>

  @foreach ($branches as $branch)
    @if ($branch->id == $table->branch_id)

        echo $branch->tables()->id;

    @endif
  @endforeach


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
                        <a href="table/{{{$table->id}}}/edit" class="btn btn-info">edit</a>
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
