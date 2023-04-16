<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductStock;
use App\Models\ProductSizeStock;

class StocksController extends Controller
{
    public function stock()
    {
        return view('stocks.stock');
    }

    public function stockSubmit(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'product_id' => 'required',
            'date' => 'required|string',
            'stock_type' => 'required|string',
            'items' => 'required',
        ]);
        
        // error response
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validate->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            // store product stock
            foreach($request->items as $item) {
                if ($item['quantity'] && $item['quantity'] > 0) {
                    $stock = new ProductStock();
                    $stock->product_id = $request->product_id[0];
                    $stock->date = $request->date;
                    $stock->status = $request->stock_type;
                    $stock->size_id = $item['size_id'];
                    $stock->quantity = $item['quantity'];
                    $stock->save();

                    // update product size stock
                    $psq = ProductSizeStock::where('product_id', $request->product_id)
                        ->where('size_id', $item['size_id'])
                        ->first();

                    if ($request->stock_type == ProductStock::STOCK_IN) {
                        $psq->quantity = $psq->quantity + $item['quantity'];
                    } else {
                        $psq->quantity = $psq->quantity - $item['quantity'];
                    }
                    $psq->save();
                }
            }
            
            flash('Stock updated successfully')->success();
            return response()->json([
                'success' => true,
            ], Response::HTTP_OK);
        }
    }

    public function history ()
    {
        $stocks = ProductStock::with(['product', 'size'])->orderBy('created_at', 'desc')->get();
        return view('stocks.history', compact('stocks'));
    }
}
