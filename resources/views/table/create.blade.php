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

        <form action="{{ route('table.store') }}" method="POST">
            @csrf
            <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-header card-form">
                    Store
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                            <label for="cashier_branch">Branch Name</label><br>
                            <select class="custom-select" name ="branches">
                            @foreach ($branches as $branch)
                                @if ( $branch->id == $branch_id)
                                    <div class="container">
                                        <option value="{{$branch->id}}" selected> {{$branch->name}} </option>
                                    </div>
                                @endif
                            @endforeach
                            </select>

                            <div class="form-group">
                            <label for="Number">Table Number</label>
                            <input name ="number"type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Table Number">
                          </div>


                          <div class="form-group">
                            <label for="exampleInputPassword1">Table Size</label>
                            <input name ="size" type="number" class="form-control" id="exampleInputPassword1" placeholder="Table Size">
                          </div>


                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="row">
                    <div class="col-12">
                      <div class="float-right">
                        <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Discard</button>
                        <button type="submit" class="btn btn-success"><i class="far fa-save"></i> Save</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card -->
              </div>


            </div>


          </form>






        {{-- <form method="POST" action="{{route('table.store')}}">
            @csrf
            <div class="form-group">
                    <label for="cashier_branch">Branch Name</label><br>
                    <select class="custom-select" name ="branches">
                    @foreach ($branches as $branch)
                        @if ( $branch->id == $branch_id)
                            <div class="container">
                                <option value="{{$branch->id}}" selected> {{$branch->name}} </option>
                            </div>
                        @endif
                    @endforeach
                    </select>
            </div>

            <div class="form-group">
              <label for="Number">Table Number</label>
              <input name ="number"type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Table Number">
            </div>

            <div class="form-group">
              <label for="exampleInputPassword1">Table Size</label>
              <input name ="size" type="number" class="form-control" id="exampleInputPassword1" placeholder="Table Size">
            </div>

            <button type="submit" class="btn btn-success"></i> Save</button>
            <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Discard</button>
          </form> --}}


          @if(count($errors) > 0)
                <div class="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

      </div>
    </div>
</div>


{{-- <div class="container-fluid">
    <div class="card">
    <div class="row mb-2">
      <div class="col-sm-12">
        <table class = "table">
            <thead>
                <th scope="col">No</th>
                <th scope="col">Name</th>
                <th scope="col">Size</th>
                <th scope="col">Action</th>
            </thead>
            <tbody>

                @foreach ($tables as $table)
                <tr>
                    <th  scope="row">{{ $number++ }}</th>
                    <td>{{$table->number}}</td>
                    <td>{{$table->size}}</td>
                    <td>
                    <div >
                        <a href="/table/{{$table->id}}/edit" class="btn btn-info">edit</a>
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
</div> --}}
</div>
      @endsection
