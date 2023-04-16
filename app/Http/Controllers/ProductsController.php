<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Product;
use App\Models\ProductSizeStock;
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
        $products = Product::with(['category', 'brand'])->get();
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
            'name' => 'required|string|min:2|max:200',
            'category_id' => 'required|numeric',
            'brand_id' => 'required|numeric',
            'sku' => 'required|string|max:100|unique:products',
            'cost_price' => 'required|numeric',
            'retail_price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:1024',
            'year' => 'required',
            'description' => 'required|max:200',
            'status' => 'required|numeric',
        ]);
        
        // error response
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validate->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            // store product
            $product = new Product();
            $product->user_id = Auth::id();
            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            $product->sku = $request->sku;
            $product->cost_price = $request->cost_price;
            $product->retail_price = $request->retail_price;
            $product->year = $request->year;
            $product->description = $request->description;
            $product->status = $request->status;

            if($request->hasFile('image')) {
                $image = $request->image;
                $name = Str::random(60) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/productImages', $name);
                $product->image = $name;
            }

            // save product
            $product->save();

            // Store product size stock
            if ($request->items) {
                foreach (json_decode($request->items) as $key => $item) {
                    $productSizeStock = new ProductSizeStock();
                    $productSizeStock->product_id = $product->id;
                    $productSizeStock->size_id = $item->size_id;
                    $productSizeStock->location = $item->location;
                    $productSizeStock->quantity = $item->quantity;
                    $productSizeStock->save();
                }
            }
        }

        flash('Product created successfully')->success();
        return response()->json([
            'success' => true,
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with(['category', 'brand', 'product_stocks.size'])->where('id', $id)->first();
        
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::where('id', $id)->with(['product_stocks'])->first();
        return view('products.edit', compact('product'));
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
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:200',
            'category_id' => 'required|numeric',
            'brand_id' => 'required|numeric',
            'sku' => 'required|string|max:100|unique:products,sku,'.$id,
            'cost_price' => 'required|numeric',
            'retail_price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'year' => 'required',
            'description' => 'required|max:200',
            'status' => 'required|numeric',
        ]);
        
        // error response
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validate->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            // update product
            $product = Product::findOrFail($id);
            $product->user_id = Auth::id();
            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            $product->sku = $request->sku;
            $product->cost_price = $request->cost_price;
            $product->retail_price = $request->retail_price;
            $product->year = $request->year;
            $product->description = $request->description;
            $product->status = $request->status;

            if($request->hasFile('image')) {
                $image = $request->image;
                $name = Str::random(60) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/productImages', $name);
                $product->image = $name;
            }

            // update product
            $product->save();

            // delete old product size stock
            ProductSizeStock::where('product_id', $product->id)->delete();

            // Store product size stock
            if ($request->items) {
                foreach (json_decode($request->items) as $key => $item) {
                    $productSizeStock = new ProductSizeStock();
                    $productSizeStock->product_id = $product->id;
                    $productSizeStock->size_id = $item->size_id;
                    $productSizeStock->location = $item->location;
                    $productSizeStock->quantity = $item->quantity;
                    $productSizeStock->save();
                }
            }
        }

        flash('Product updated successfully')->success();
        return response()->json([
            'success' => true,
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        flash('Product deleted successfully')->success();
        return back();
    }
}
