<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with([
                'productImage'
            ])->get();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:products',
            'slug' => 'required|unique:products',
            'price' => 'required|numeric',
            'status' => 'required|numeric',
        ]);
        
        // error response
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validate->errors()
            ], \Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY);
        } else if (empty(json_decode($request->category_id))) {
            return response()->json([
                'success' => false,
                'error' => ['Category need to be selected']
            ], \Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY);
        } else if (empty($request->product_images)) {
            return response()->json([
                'success' => false,
                'error' => ['Product image need to be uploaded']
            ], \Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            // store product
            $product = new Product();
            $product->name = $request->name;
            $product->slug = Str::slug($request->slug);
            $product->user_id = Auth::id();
            $product->price = $request->price;
            $product->status = $request->status;
            $product->save();

            // save product category
            foreach (json_decode($request->category_id) as $key => $category) {
                $productCategory = new ProductCategory();
                $productCategory->product_id = $product->id;
                $productCategory->category_id = $category;
                $productCategory->save();
            }

            // save product attributes
            if ($request->attribute_items) {
                foreach (json_decode($request->attribute_items) as $key => $attribute) {
                    $productAttribute = new ProductAttribute();
                    $productAttribute->product_id = $product->id;
                    $productAttribute->attribute_id = $attribute->attribute_id;
                    $productAttribute->attribute_property = $attribute->attribute_property;
                    $productAttribute->save();
                }
            }

            // save product images
            foreach ($request->product_images as $key => $productImage) {
                $image = $productImage;
                $name = Str::random(60) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/productImage', $name);

                $productImage = new ProductImage();
                $productImage->product_id = $product->id;
                $productImage->product_image = $name;
                $productImage->save();
            }
        }

        

        return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
