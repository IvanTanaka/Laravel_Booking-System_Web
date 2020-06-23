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
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h1 class="m-0 text-dark">Create News</h1>
          </div>
          <div class="card-body">
            <form action="{{ route('news.store') }}" method="POST" enctype='multipart/form-data'>
              @csrf
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header card-form">
                      News
                    </div>
                    <div class="card-body table-responsive p-2">
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="news_image">News Image</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="news_image" name="news_image" accept="image/jpg, image/png, image/jpeg" required>
                                <label class="custom-file-label" for="news_image">Choose image</label>  
                              </div>  
                              <div class="input-group-append">
                                <input type="hidden" id="news_image_remove" name="news_image_remove" value="false">
                                <button type="button" class="btn btn-danger" id="remove_image">Remove</button>
                              </div>
                              
                              
                            </div>
                          </div>
                          <div class="form-group">
                            <img id="news_image_container" src="\assets\images\empty_image.png" alt="news image" style="height:300px; width:300px;" class="img-thumbnail"/>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="news_description">Description</label>
                            <textarea id="news_description" class="form-control" rows="4" name="news_description" required></textarea>
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
                    <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Discard</button>
                    <button type="submit" class="btn btn-success"><i class="far fa-save"></i> Save</button>
                  </div>
                </div>
              </div>
              <!-- /.row -->
            </form>
          </div>
        </div>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection

@section('script')
<!-- bs-custom-file-input -->
<script src="/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
  
  $('#remove_image').click(function(){
    $('#news_image_remove').val(true);
    $('#news_image').val("");
    $('#news_image_container').attr('src','/assets/images/empty_image.png');
  });
  
  $(document).ready(function () {
    bsCustomFileInput.init();
  });
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function (e) {
        $('#news_image_container').attr('src', e.target.result);
        $('#news_image_remove').val(false);
      }
      
      reader.readAsDataURL(input.files[0]);
    }
  }
  
  $("#news_image").change(function(){
    readURL(this);
  });
</script>
@endsection