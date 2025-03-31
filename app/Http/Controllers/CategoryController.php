<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::get()->toTree();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::get()->toTree();
        return view('categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);

        if ($request->parent_id) {
            $parent = Category::findOrFail($request->parent_id);
            $category->parent_id = $parent->id;
        }

        $category->save();

        return redirect()->route('categories.index')->with('success', '分类创建成功！');
    }

    public function edit(Category $category)
    {
        $categories = Category::where('id', '!=', $category->id)
            ->get()
            ->toTree();
        return view('categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);

        if ($request->parent_id && $request->parent_id != $category->parent_id) {
            $parent = Category::findOrFail($request->parent_id);
            $category->parent_id = $parent->id;
            $category->save();
        } elseif (is_null($request->parent_id) && !is_null($category->parent_id)) {
            $category->parent_id = null;
            $category->save();
        } else {
            $category->save();
        }

        return redirect()->route('categories.index')->with('success', '分类更新成功！');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', '分类删除成功！');
    }
}
