@extends('cms.parent')

@section('style')

@endsection

@section('lg-title', '')
@section('main-title', '')
@section('sm-title', '')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Admin</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('admins.update', $admin->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (session()->has('message'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Alert!</h5>
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="user_name"
                                        placeholder="Enter name" value="{{ old('user_name') ?? $admin->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="user_email">Email address</label>
                                    <input type="email" class="form-control" id="user_email" name="user_email"
                                        placeholder="Enter email" value="{{ old('user_email') ?? $admin->email }}">
                                </div>
                                <div class="form-group">
                                    <label for="user_email">balance</label>
                                    <input type="text" class="form-control" id="balance" name="balance"
                                        placeholder="Enter balance" value="{{ old('balance') ?? $admin->balance }}">
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="active" name="active"
                                            @if ($admin->active) checked @endif name="active">
                                        <label class="custom-control-label" for="active">
                                            Activet
                                        </label>
                                    </div>
                                </div>

                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('js_content')
@endsection
