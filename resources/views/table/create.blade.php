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
        <h1 class="m-0 text-dark">Table Create</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->


<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <form>

            

            <div class="form-group">
              <label for="Number">Table Number</label>
              <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Table Number">
            </div>

            <div class="form-group">
              <label for="exampleInputPassword1">Table Size</label>
              <input type="number" class="form-control" id="exampleInputPassword1" placeholder="Table Size">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>

          </form>
      </div>
    </div>
</div>
      @endsection
