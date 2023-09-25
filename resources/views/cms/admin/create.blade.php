@extends('cms.parent')

@section('style')

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
                            <h3 class="card-title">Create Admin</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="{{ route('admins.store') }}">
                            <div class="card-body">
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
                                     {{session()->get('message')}}
                                  </div>
                                  @endif
                                  @csrf

                                <div class="form-group">
                                    <label for="name_en">Name Admin</label>
                                    <input type="text" class="form-control" id="user_name"
                                      name="user_name"  placeholder="Enter the Name">
                                </div>
                                <div class="form-group">
                                    <label for="name_er">Your Email</label>
                                    <input type="email" class="form-control" id="user_email"
                                      name="user_email"  placeholder="Enter Your Email">
                                </div>
                                <div class="form-group">
                                    <label for="name_er">Your Password</label>
                                    <input type="password" class="form-control" id="user_password"
                                      name="user_password"  placeholder="Enter Your Password">
                                </div>
                                <div class="form-group">
                                    <label for="name_er">balance</label>
                                    <input type="text" class="form-control" id="balance"
                                      name="balance"  placeholder="Enter Your balance">
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="active" name="active">
                                        <label class="custom-control-label" for="active">
                                            Activet
                                        </label>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                        </form>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
