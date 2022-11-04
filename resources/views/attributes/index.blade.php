@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Product Attributes</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Product Attribute List</li>
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
                        Product Attribute List
                        <a href="{{ route('attributes.create') }}" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus"></i> Add Attribute</a>
                    </h5>
                </div>
                <div class="card-body">
                    @if($attributes->isEmpty())
                        <div class="alert alert-danger">
                            No results found !
                        </div>
                    @else
                        <table class="table table-bordered dataTable">
                            <thead>
                                <tr>
                                    <th>#SL</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attributes as $key => $attribute)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $attribute->name ?? '' }}</td>
                                        <td>
                                            <a href="{{ route('attributes.edit', $attribute->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Edit</a>
                                            <a href="javascript:" class="btn btn-sm btn-danger sa-delete" data-form-id="attribute-delete-{{ $attribute->id }}"><i class="fa fa-trash"></i> Delete</a>
                                            <form id="attribute-delete-{{ $attribute->id }}" action="{{ route('attributes.destroy', $attribute->id) }}" method="post">
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