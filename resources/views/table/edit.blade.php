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


<form method ="POST" action="{{route('table.update', $table->id)}}">
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
      <label for="exampleFormControlInput1">Table Name</label>
        <input type="text" class="form-control" name ="number" value ="{{$table->number}}">
    </div>

    <div class="form-group">
        <label for="exampleFormControlInput1">Table Name</label>
        <input type="text" class="form-control" value ="{{$table->size}}" name ="size">
      </div>

    <div class="form-group">
        <input type="submit" value="Save">
    </div>

  </form>

@endsection
