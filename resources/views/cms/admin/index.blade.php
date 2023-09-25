@extends('cms.parent')

@section('style')
    <link rel="stylesheet" href="{{ asset('cms/css/style.css') }}">
@endsection

@section('lg-title', '')
@section('main-title', '')
@section('sm-title', '')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Responsive Hover Table</h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right"
                                        placeholder="Search">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Active</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td><span
                                                    class="badge @if ($item->active) bg-success @else bg-danger @endif">{{ $item->active_key }}</span>
                                            </td>
                                            <td>{{ $item->created_at ?? '--' }}</td>
                                            <td class="options">
                                                <a href="{{ route('admins.edit', $item->id) }}">Edit</a>
                                                <form action="{{ route('admins.destroy', $item->id) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="delete-btn">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('js_content')
@endsection
