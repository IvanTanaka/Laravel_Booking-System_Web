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
            <h1 class="m-0 text-dark">Edit News</h1>
          </div>
          <div class="card-body">
            <form action="{{ route('news.update',$news->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
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
                          </div>
                          <div class="form-group">
                            <img id="news_image_container" src="{{($news->image_path != null)?'/storage/images/news/'.$news->image_path:'/assets/images/empty_image.png'}}" alt="news image" style="height:500px; width:500px;" class="img-thumbnail"/>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="news_description">Description</label>
                          <textarea id="news_description" class="form-control" rows="10" name="news_description" required>{{$news->description}}</textarea>
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