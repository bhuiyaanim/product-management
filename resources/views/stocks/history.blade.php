@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Stocks</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Stock History</li>
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
                        Stock history
                    </h5>
                </div>
                <div class="card-body">
                    @if($stocks->isEmpty())
                        <div class="alert alert-danger">
                            No results found !
                        </div>
                    @else
                        <table class="table table-bordered dataTable">
                            <thead>
                                <tr>
                                    <th>#SL</th>
                                    <th>Date</th>
                                    <th>Product</th>
                                    <th>Size</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stocks as $key => $stock)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $stock->date ?? '' }}</td>
                                        <td>{{ $stock->product->name ?? '' }}</td>
                                        <td>{{ $stock->size->size ?? '' }}</td>
                                        <td>{{ $stock->quantity ?? '' }}</td>
                                        <td>{{ strtoupper($stock->status) ?? '' }}</td>
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