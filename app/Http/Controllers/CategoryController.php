<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    //TODO go to list.blade.php
    public function goToCategoryListPage() {
        $categories = Category::when(request('key'), function($query) {
            $query->where('name', 'like', '%'.request('key').'%');
        })->orderBy('created_at', 'desc')->paginate(4);
        // dd($categories);
        // $categories->appends(request()->all());
        return view('admin.category.list', compact('categories'));
    }

    //TODO go to create.blade.php
    public function goToCategoryCreatePage() {
        return view('admin.category.create');
    }

    //TODO creating a category (adding)
    public function createCategoty(Request $request) {
        $this->checkCategoryValidation($request);
        $data = $this->requestCategoryData($request);
        Category::create($data);
        return redirect()->route('category#goToCategoryListPage')->with(['categoryCreated' => 'A Category has been created..']);
    }

    //TODO deleting a category (removing from database)
    public function deleteCategory($id) {
        // dd($id);
        Category::where('id', '=', $id)->delete();
        return redirect()->route('category#goToCategoryListPage')->with(['categoryDeleted' => 'Category has been deleted..']); /* return back() နဲ့ရေးလည်းရတယ် */
    }

    //TODO go to edit.blade.php
    public function goToCategoryEditPage($id) {
        $category = Category::where('id', '=', $id)->first();
        return view('admin.category.edit', compact('category'));
    }

    //TODO editing a category
    public function editCategory(Request $request) {
        $this->checkCategoryValidation($request);
        $data = $this->requestCategoryData($request);
        Category::where('id', '=', $request->categoryId)->update($data);
        return redirect()->route('category#goToCategoryListPage');
    }



    // TODO checkCategoryValidation Private Function

    private function checkCategoryValidation($request) {
        Validator::make($request->all(), [
            'categoryName' => 'required|min:4|unique:categories,name,'.$request->categoryId
        ])->validate();
    }

    //TODO requestCategoryData Private Function

    private function requestCategoryData($request) {
        return [
            'name' => $request->categoryName
        ];
    }
}
