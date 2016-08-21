<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
// use for ajax responses
use Illuminate\Support\Facades\Response;

class CategoryController extends Controller
{
	
	public function getCategoryIndex()
	{
		$categories = Category::orderBy('created_at', 'desc')->paginate(5);
		return view('admin.blog.categories', ['categories' => $categories]);
	}

	// Laravel will figure out if ajax or not
	public function postCreateCategory(Request $request)
	{
		$this->validate($request, [
			'name' => 'required|unique:categories'
		]);
		$category = new Category();
		$category->name = $request['name'];
		if ($category->save()) {
			return Response::json(['message' => 'Category created!'], 200);
		}
		return Response::json(['message' => 'Error during creation of category!'], 404);
	}

	public function postUpdateCategory(Request $request)
	{
		$this->validate($request, [
			// check if same value, don't run ajax, just close
			'name' => 'required|unique:categories'
		]);

		$category = Category::find($request['category_id']);
		if (!$category) {
			return Response::json(['message' => 'Category not found!'], 404);
		}

		$category->name = $request['name'];
		if ($category->update()) {
			return Response::json(['message' => 'Category updated!', 'new_name' => $request['name']], 200);
		}
		return Response::json(['message' => 'Error during update of category!'], 404);
	}

	public function getDeleteCategory($category_id)
	{
		$category = Category::find($category_id);
		if (!$category) {
			return Response::json(['message' => 'Category not found!'], 404);
		}

		$category->category_id = $category_id;
		if ($category->delete()) {
			return Response::json(['message' => 'Category deleted!'], 200);
		}
		return Response::json(['message' => 'Error during delete of category!'], 404);
	}
}