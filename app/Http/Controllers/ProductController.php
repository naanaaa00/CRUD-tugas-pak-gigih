<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return view('products.index', ['products' => $products]);
    }

    public function create(){
        return view('products.create');
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'qty' => 'required|numeric',
            'price' => 'required|decimal:0,2',
            'description' => 'nullable'
        ]);

        $data['user_id'] = auth()->id();
        
        $newProduct = Product::create($data);

        return redirect(route('product.index'));
    }

    public function edit(Product $product){
        if ($product->user_id !== auth()->id()) {
            return redirect(route('product.index'))->with('error', 'You are not authorized to edit this product');
        }

        return view('products.edit', ['product' => $product]);
    }

    public function update(Product $product, Request $request){
        if ($product->user_id !== auth()->id()) {
            return redirect(route('product.index'))->with('error', 'You are not authorized to update this product');
        }

        $data = $request->validate([
            'name' => 'required',
            'qty' => 'required|numeric',
            'price' => 'required|decimal:0,2',
            'description' => 'nullable'
        ]);

        $product->update($data);

        return redirect(route('product.index'))->with('success', 'Product Updated Successfully');
    }

    public function destroy(Product $product){
        if ($product->user_id !== auth()->id()) {
            return redirect(route('product.index'))->with('error', 'You are not authorized to delete this product');
        }

        $product->delete();
        return redirect(route('product.index'))->with('success', 'Product deleted Successfully');
    }
}
