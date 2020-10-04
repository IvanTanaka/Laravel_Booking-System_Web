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
    <label for="cashier_branch">Branch Store</label><br>
      @foreach ($branches as $branch)
      <label value ="{{$branch->id}}">Branch Store</label> <br>
      <p>
      <a class="btn btn-primary" href="{{route('table.index',['branch_id'=>$branch->id])}}" >
            {{$branch->name}}
        </a>
      </p>
      @endforeach
    </select>
  </div>

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
