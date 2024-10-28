<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Product::active()->apiFilter($request->query())
            ->paginate();

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
}
