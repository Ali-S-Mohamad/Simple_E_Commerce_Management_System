<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Exception;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $products = Product::paginate();
        // return view('dashboard.products.index', compact('products'));

        $request = request();

        $products = Product::filter($request->query())->paginate(10);
        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->get();
        $product = new Product();
        return view('dashboard.products.create', compact('product', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $request->merge([
            'slug' => Str::slug($request->name)
        ]);

        $data = $request->except('image');

        $data['image'] = $this->uploadImage($request);


        $product = Product::create($data);
        $product->categories()->sync($request->categories_ids);

        return redirect()->route('dashboard.products.index')
            ->with('success', 'Product created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('dashboard.products.show',['product'=>$product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            return view('dashboard.products.edit', compact('product'));
        } catch (Exception $e) {
            return redirect()->route('dashboard.products.index')
                ->with('info', 'Record not found !!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $product = Product::findOrFail($id);

        $old_image = $product->image;
        $data = $request->except('image');

        $new_image = $this->uploadImage($request);
        if ($new_image) {
            $data['image'] = $new_image;
        }

        $product->update($data);
        $categoriesIds = $request->input('categories_ids', []);
        $product->categories()->sync($categoriesIds);

        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }

        return redirect()->route('dashboard.products.index')
            ->with('success', 'Product updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('dashboard.products.index')
            ->with('success', 'Product deleted!');
    }

    public function trash()
    {
        $products = Product::onlyTrashed()->paginate();
        return view('dashboard.products.trash', compact(var_name: 'products'));
    }

    public function restore(Request $request, $id)
    {
        $products = Product::onlyTrashed()->findOrFail($id);
        $products->restore();

        return redirect()->route('dashboard.products.trash')
            ->with('success', 'product restored!');
    }

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        return redirect()->route('dashboard.products.trash')
            ->with('success', 'product deleted forever!');
    }
}
