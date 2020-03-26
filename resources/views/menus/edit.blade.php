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
        <h1 class="m-0 text-dark">Edit {{$menu->name}}</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->


<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    
    <form action="{{ route('menus.update',$menu->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="row">
        @if ($message = Session::get('error'))
        <div class="col-lg-12">
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Error!</h5>
            {{$message}}
          </div>
        </div>
        @elseif($errors->any())
        <div class="col-lg-12">
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Error!</h5>
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        </div>
        @endif
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body table-responsive p-2">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="menu_name">Name</label>
                    <div class="input-group">
                    <input type="text" class="form-control" im-insert="true" id="menu_name" name="menu_name" required value="{{$menu->name}}">
                    </div>
                    <!-- /.input group -->
                  </div>
                  <div class="form-group">
                    <label for="menu_price">Price</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Rp </span>
                      </div>
                    <input type="number" class="form-control" im-insert="true" id="menu_price" name="menu_price" required autocomplete="menu_price" value="{{$menu->price}}">
                    </div>
                    <!-- /.input group -->
                  </div>
                  <div class="form-group">
                    <label for="menu_description">Description</label>
                  <textarea id="menu_description" class="form-control" rows="4" name="menu_description">{{$menu->description}}</textarea>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="menu_image">Menu Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="menu_image" name="menu_image" accept="image/jpg, image/png, image/jpeg">
                        <label class="custom-file-label" for="menu_image">Change image</label>  
                      </div>  
                      <div class="input-group-append">
                        <input type="hidden" id="menu_image_remove" name="menu_image_remove" value=false>
                        <button type="button" class="btn btn-danger" id="remove_image">Remove</button>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <img id="menu_image_container" src="{{($menu->image_path != null)?'/storage/images/'.Auth::user()->franchise->id.'/'.'menu/'.$menu->image_path:'/assets/images/empty_image.png'}}" alt="menu image" style="height:300px; width:300px;" class="img-thumbnail"/>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        
      </div>
      
      <div class="row">
        <div class="col-12">
          <div class="float-right">
            <button type="reset" class="btn btn-default" id="reset_button"><i class="fas fa-times"></i> Discard</button>
            <button type="submit" class="btn btn-success"><i class="far fa-save"></i> Save</button>
          </div>
        </div>
      </div>
      <!-- /.row -->
    </form>
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection

@section('script')
<!-- bs-custom-file-input -->
<script src="/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">

  $("#reset_button").click(function(){
    $('#menu_image_remove').val(false);
    $('#menu_image_container').attr('src', "{{($menu->image_path != null)?'/storage/images/'.Auth::user()->franchise->id.'/'.'menu/'.$menu->image_path:'/assets/images/empty_image.png'}}");
  });

  $('#remove_image').click(function(){
    $('#menu_image_remove').val(true);
    $('#menu_image').val("");
    $('.custom-file-label').text("Change image");
    $('#menu_image_container').attr('src','/assets/images/empty_image.png');
  });

  $(document).ready(function () {
    bsCustomFileInput.init();
  });
  function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#menu_image_container').attr('src', e.target.result);
            $('#menu_image_remove').val(false);
        }

        reader.readAsDataURL(input.files[0]);
    }
  }

  $("#menu_image").change(function(){
      readURL(this);
  });
</script>
@endsection