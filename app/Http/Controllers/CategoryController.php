<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{   

    public function index()
{
    $categories = DB::table('categories')
        ->leftJoin('products', 'categories.id', '=', 'products.category_id')
        ->select(
            'categories.id',
            'categories.name',
            DB::raw('COUNT(products.id) as products_count')
        )
        ->groupBy('categories.id', 'categories.name')
        ->paginate(10);

    return view('categories.index', compact('categories'));
}

    public function form($id = null)
    {
        $category = $id ? Category::findOrFail($id) : null;

        return view('categories.form', compact('category'));
    }

    public function store(Request $request, $id = null){
        $request->validate([
            'name' => 'required|unique:categories,name,' . $id,
        ]);

        $category = $id ? Category::findOrFail($id) : new Category;
        $category->name = $request->input('name');
        $category->save();
        return redirect()->route('categories.index')
                         ->with('success', $id ? 'Category updated successfully.' : 'Category created successfully.');


    }

    public function destroy( $id = null){
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');

    }
}
