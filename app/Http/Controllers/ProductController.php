<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    public function index() {
        $products = Product::leftJoin('categories', 'categories.id', '=', 'products.category_id')
        ->select(
            'products.id',
            'products.name',
            DB::raw('GROUP_CONCAT(categories.name) as category_names'),
            'products.price'
        )
        ->groupBy('products.id', 'products.name', 'products.price')
        ->paginate(10);

        return view('products.index',compact('products'));

    }

    public function form($id=null){

        $categories = Category::all();

        $products  = $id ? Product::find($id) : new Product();
        return view('products.form', compact('products','categories'));
    }

    public function store(Request $request, $id=null){
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = $id ? Product::findOrFail($id) : new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->category_id = $request->category_id;

        $product->save();

        return redirect()->route('products.index')
                         ->with('success', $id ? 'Product updated successfully.' : 'Product created successfully.');

    }

    public function destroy($id = null)
    {
       $product  = Product::findOrFail($id);
       $product->delete();  
       
       return redirect()->route('products.index')->with('success',  'Product deleted successfully.');
    }



}
