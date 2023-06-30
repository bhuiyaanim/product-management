@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Categories</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Category List</li>
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
                        Category List
                        <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus"></i> Add Category</a>
                    </h5>
                </div>
                <div class="card-body">
                    @if($categories->isEmpty())
                        <div class="alert alert-danger">
                            No results found !
                        </div>
                    @else
                        <table class="table table-bordered dataTable">
                            <thead>
                                <tr>
                                    <th>#SL</th>
                                    <th>Name</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $key => $category)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $category->name ?? '' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Edit</a>
                                            <a href="javascript:" class="btn btn-sm btn-danger sa-delete" data-form-id="category-delete-{{ $category->id }}"><i class="fa fa-trash"></i> Delete</a>
                                            <form id="category-delete-{{ $category->id }}" action="{{ route('categories.destroy', $category->id) }}" method="post">
                                                @csrf
                                                @method("DELETE")
                                            </form>
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