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
                </div>

                <div class="card-body">
                <div class="content">
                    <div class="form-group">
                            <div class="row mb-2">
                                    <div class="col-sm-12">
                                            <table class="table table-hover table-bordered">
                                                <thead class="thead-light">
                                                    <th scope="col">No</th>
                                                    <th scope="col">Branch Store</th>
                                                    <th scope="col">Branch Address</th>
                                                </thead>
                                                <?php $number = 1; ?>
                                                @foreach ($branches as $branch)
                                                    <tbody>
                                                        <th scope="row">{{$number++}}</th>
                                                        <td scope="row"><a class="btn btn-outline-secondary" href="{{route('table.index',['branch_id'=>$branch->id])}}" >
                                                            {{$branch->name}}</td>  </a>
                                                        <td> <a class="btn" href="{{route('table.index',['branch_id'=>$branch->id])}}" >
                                                            {{$branch->address}}</td> </a>
                                                    </tbody>
                                                @endforeach
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

{{-- @section('script')
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
@endsection --}}
