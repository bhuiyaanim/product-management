<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\ReturnProduct;
use App\Models\ProductSizeStock;

class ReturnProductsController extends Controller
{
    public function returnProducts()
    {
        return view('returnProducts.return');
    }

    public function returnProductSubmit(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'product_id' => 'required',
            'date' => 'required|string',
            'items' => 'required',
        ]);
        
        // error response
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validate->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            // store return product
            foreach($request->items as $item) {
                if ($item['quantity'] && $item['quantity'] > 0) {
                    $productItem = new ReturnProduct();
                    $productItem->product_id = $request->product_id[0];
                    $productItem->date = $request->date;
                    $productItem->size_id = $item['size_id'];
                    $productItem->quantity = $item['quantity'];
                    $productItem->save();

                    // update product size stock
                    $psq = ProductSizeStock::where('product_id', $request->product_id)
                        ->where('size_id', $item['size_id'])
                        ->first();
                    
                    // stock in
                    $psq->quantity = $psq->quantity + $item['quantity'];
                    $psq->save();
                }
            }
            
            flash('Return product updated successfully')->success();
            return response()->json([
                'success' => true,
            ], Response::HTTP_OK);
        }
    }

    public function history ()
    {
        $returnProducts = ReturnProduct::with(['product', 'size'])->orderBy('created_at', 'desc')->get();
        return view('returnProducts.history', compact('returnProducts'));
    }
}
