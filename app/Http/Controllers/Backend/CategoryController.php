<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'contact_person' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
        ]);

        $data = $request->only(['name', 'contact_person', 'telephone']);

        // 👉 generate slug otomatis
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('categories', 'public');
        }

        Category::create($data);

        return redirect()->route('admin.category')->with('success', 'Category created successfully.');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'contact_person' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
        ]);

        $data = $request->only(['name', 'contact_person', 'telephone']);

        // 👉 update slug juga (biar tetap konsisten)
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('icon')) {
            if ($category->icon) {
                Storage::disk('public')->delete($category->icon);
            }
            $data['icon'] = $request->file('icon')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('admin.category')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        // Delete icon if exists
        if ($category->icon) {
            Storage::disk('public')->delete($category->icon);
        }

        $category->delete();

        return redirect()->route('admin.category')->with('success', 'Category deleted successfully.');
    }

    public function edit(Category $category)
    {
        return response()->json([
            'id' => $category->id,
            'name' => $category->name,
            'contact_person' => $category->contact_person,
            'telephone' => $category->telephone,
            'icon' => $category->icon
        ]);
    }
}
