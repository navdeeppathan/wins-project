<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // Show all categories
    public function index()
    {
        $categories = Category::with('subcategories')->get();
        return view('admin.categories.index', compact('categories'));
    }

    // Store category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => 1
        ]);

        return redirect()->back()->with('success', 'Category created successfully');
    }

    // Update category
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->back()->with('success', 'Category updated successfully');
    }

    // Delete category
    public function destroy($id)
    {
        Category::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Category deleted successfully');
    }

    // Get subcategories by category (AJAX)
    public function getSubcategories($category_id)
    {
        $subcategories = Subcategory::where('category_id', $category_id)->get();

        return response()->json($subcategories);
    }

    public function status($id)
    {
        $category = Category::findOrFail($id);

        $category->status = !$category->status;

        $category->save();

        return back();
    }
}