@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Users</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">User List</li>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="content">
    <div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">
                        User List
                        <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus"></i> Add User</a>
                    </h5>
                </div>
                <div class="card-body">
                    @if($users->isEmpty())
                        <div class="alert alert-danger">
                            No results found !
                        </div>
                    @else
                        <table class="table table-bordered dataTable">
                            <thead>
                                <tr>
                                    <th>#SL</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $key => $user)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $user->name ?? '' }}</td>
                                        <td>{{ $user->email ?? '' }} @if(auth()->id() == $user->id) (you) @endif</td>
                                        <td>{{ $user->created_at->format('yy-m-d') ?? '' }}</td>
                                        <td>
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Edit</a>
                                            @if(auth()->id() != $user->id)
                                                <a href="javascript:" class="btn btn-sm btn-danger sa-delete" data-form-id="user-delete-{{ $user->id }}"><i class="fa fa-trash"></i> Delete</a>
                                                <form id="user-delete-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="post">
                                                    @csrf
                                                    @method("DELETE")
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
        <!-- /.col-md-6 -->
    </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection