@extends('layouts.base')

@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js" defer></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" defer></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" defer></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" defer></script>

@endsection

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
            <h1 class="m-0 text-dark">@if($branch->franchise->name != $branch->name){{$branch->franchise->name}} - @endif{{$branch->name}}</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->


<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body table-responsive p-2">
                        <div class="form-group">
                            <strong>Name:</strong>
                            {{ $branch->name }}
                        </div>
                        <div class="form-group">
                            <strong>Open Time:</strong>
                            {{ $branch->open_time }}
                        </div>
                        <div class="form-group">
                            <strong>Close Time:</strong>
                            {{ $branch->close_time }}
                        </div>
                        <div class="form-group">
                            <strong>Phone Number:</strong>
                            {{ $branch->phone_number }}
                        </div>
                        <div class="form-group">
                            <strong>Address:</strong>
                            {{ $branch->address }}
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection