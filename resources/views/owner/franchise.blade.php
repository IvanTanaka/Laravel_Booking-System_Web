@extends('layouts.base')

@section('content')


<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1 class="m-0 text-dark"></h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-sm-8 offset-md-2">
        <form action="{{ url('/profile') }}" method="POST" enctype="multipart/form-data">
          <div class="card">
            <div class="card-header">
              <h1 class="m-0 text-dark">Profile</h1>
            </div>
            <div class="card-body">
                {{ csrf_field() }}
                <div class="row">
                  <div class="col-12">
                    <div class="card">
                      <div class="card-form card-header">
                        <h3 class="card-title">Owner</h3>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="form-group">
                              <label for="owner_name">Name</label>
                            <input type="text" id="owner_name" value="{{$user->name}}" name="owner_name" class="form-control">
                            </div>
                          </div>
                          <div class="col-lg-12">
                            <div class="form-group">
                              <label for="owner_email">Email</label>
                              <input type="text" id="owner_email" value="{{$user->email}}" name="owner_email" class="form-control">
                            </div>
                          </div>
                          <div class="col-lg-12">
                            <div class="form-group">
                              <label for="owner_phone_number">Phone Number</label>
                              <input type="text" id="owner_phone_number" value="{{$user->phone_number}}" name="owner_phone_number" class="form-control">
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                  </div>
                  
                  <div class="col-12">
                    <div class="card">
                      <div class="card-form card-header">
                        <h3 class="card-title">Franchise</h3>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="form-group">
                              <label for="franchise_name">Name</label>
                              <input type="text" id="franchise_name" value="{{$franchise->name}}" name="franchise_name" class="form-control">
                            </div>
                          </div>
                          <div class="col-lg-12">
                            <div class="form-group">
                              <label for="franchise_logo">Franchise Logo</label>
                              <div class="input-group">
                                <div class="custom-file">
                                  <input type="file" class="custom-file-input" id="franchise_logo" name="franchise_logo" accept="image/jpg, image/png, image/jpeg">
                                  <label class="custom-file-label" for="franchise_logo">Choose image</label>  
                                </div>  
                                <div class="input-group-append">
                                  <input type="hidden" id="franchise_logo_remove" name="franchise_logo_remove" value="false">
                                  <button type="button" class="btn btn-danger" id="remove_image">Remove</button>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <img id="franchise_logo_container" src="{{($franchise->image_path != null)?'/storage/images/'.Auth::user()->franchise->id.'/'.$franchise->image_path:'/assets/images/empty_image.png'}}" alt="franchise logo" style="height:300px; width:300px;" class="img-thumbnail"/>
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
                    <input type="submit" value="Save" class="btn btn-success float-right">
                  </div>
                </div>
            </div>
          </div>

        </form>
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection

@section('script')
<script>

$("#reset_button").click(function(){
    $('#franchise_logo_remove').val(false);
    $('#franchise_logo_container').attr('src', "{{($franchise->image_path != null)?'/storage/images/'.Auth::user()->franchise->id.'/'.$franchise->image_path:'/assets/images/empty_image.png'}}");
  });

  $('#remove_image').click(function(){
    $('#franchise_logo_remove').val(true);
    $('#franchise_logo').val("");
    $('.custom-file-label').text("Change image");
    $('#franchise_logo_container').attr('src','/assets/images/empty_image.png');
  });

  $(document).ready(function () {
    bsCustomFileInput.init();
  });
  function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#franchise_logo_container').attr('src', e.target.result);
            $('#franchise_logo_remove').val(false);
        }

        reader.readAsDataURL(input.files[0]);
    }
  }

  $("#franchise_logo").change(function(){
      readURL(this);
  });
</script>
@endsection