<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            // 'status' => 'in:delivered,pending,shipped',
            // 'total_price' => 'required|numeric|min:0',
        ]);

        $product = Product::findOrFail($request->product_id);
        // dd($product);

        $order = Order::create([
            'user_id' => Auth::user()->id,
            'product_id' => $request->product_id,
            'status' => 'pending',
            'total_price' => $product->price,
        ]);


        return Response::json($order, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return $order
            ->load('user:id,name', 'product:id,name');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'shipped'
        ]);

        $user = $request->user();

        if (!$user->tokenCan('orders.update')) {
            abort(403, 'Not allowed');
        }
        if ($user->id == $order->user_id) {
            $order->update($request->all());
        } else {
            return Response::json(['message' => 'You are not allowed to update this order!'], 403);
        }


        return Response::json($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        if (!$user->tokenCan('orders.delete')) {
            return response([
                'message' => 'Not allowed'
            ], 403);
        }
        $order = Order::findOrFail($id);
        if ($user->id == $order->user_id) {
            Order::destroy($id);
            return [
                'message' => 'Product deleted successfully',
            ];
        } else {
            return Response::json(['message' => 'You are not allowed to delete this order!'], 403);
        }


    }
}
