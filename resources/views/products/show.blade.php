@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Products</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Product Show</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>




<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="card card-solid">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3 class="d-inline-block d-sm-none">{{ $product->name }}</h3>
                    <div class="col-12">
                        <img src="{{ asset('storage/productImage/'.$product->productImages[0]->product_image) }}" class="product-image" alt="Product Image">
                    </div>
                    <div class="col-12 product-image-thumbs">
                        @foreach($product->productImages as $key => $productImage)
                            <?php $activeClass = ''; ?>
                            @if($key == 0)
                                <?php $activeClass = 'active'; ?>
                            @endif
                            <div class="product-image-thumb ".{{ $activeClass }}><img src="{{ asset('storage/productImage/'.$productImage->product_image) }}" alt="Product Image"></div>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <h3 class="my-3">{{ $product->name }}</h3>
                    <p><strong>Slue: </strong>{{ $product->slug }}</p>
                    <hr>
                    <h4>Product Category</h4>
                    <div class="row">
                        @foreach($product->productCategories as $productCategory)
                            <div class="col-sm-2">
                            <p class="btn btn-default text-center">{{ $productCategory->category->name }}</p>
                            </div>
                        @endforeach
                    </div>
                    <hr>
                    @foreach($productAttributeArrayList as $productAttributeArray)
                        <div class="pb-2">
                            <h4>Available {{ $productAttributeArray['attribute']['name'] }}</h4>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                @foreach($product->productAttributes as $productAttribute)
                                    @if($productAttributeArray['attribute_id'] == $productAttribute->attribute_id)
                                        <label class="btn btn-default text-center active">
                                            <input type="radio" name="color_option" id="color_option_a1" autocomplete="off" checked>
                                            {{ $productAttribute->attribute_property }}
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    <div class="bg-gray py-2 px-3 mt-4">
                        <h2 class="mb-0">
                            {{ $product->price }}
                        </h2>
                        <h4 class="mt-0">
                            <small>Ex Tax: {{ $product->price }} </small>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</section>

@endsection
