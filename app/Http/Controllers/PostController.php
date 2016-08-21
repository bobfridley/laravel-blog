<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;

class PostController extends Controller {
	
	public function getBlogIndex()
	{
		$posts = Post::paginate(5);
		foreach ($posts as $post) {
			$post->body = $this->shortenText($post->body, 20);
		}

		return view('frontend.blog.index', ['posts' => $posts]);
	}

	public function getPostIndex()
	{
		$posts = Post::paginate(5);

		return view('admin.blog.index', ['posts' => $posts]);
	}

	public function getSinglePost($post_id, $end = 'frontend')
	{
		$post = Post::find($post_id);
		if (!$post) {
			return redirect()->route('blog.index')->with(['fail', 'Post not found!']);
		}
		return view($end . '.blog.single', ['post' => $post]);
	}

	public function getUpdatePost($post_id)
	{
		$post = Post::find($post_id);
		if (!$post) {
			return redirect()->route('admin.blog.index')->with(['fail', 'Post not found!']);
		}

		// Find categories
		$categories = Category::all();
		$post_categories = $post->categories;
		$post_categories_ids = array();
		$i = 0;

		foreach($post_categories as $post_category) {
			$post_categories_ids[$i] = $post_category->id;
			$i++;
		}

		return view('admin.blog.edit-post', ['post' => $post, 'categories' => $categories, 'post_categories' => $post_categories, 'post_categories_ids' => $post_categories_ids]);
	}

	public function getCreatePost()
	{
		$categories = Category::all();

		return view('admin.blog.create-post', ['categories' => $categories]);
	}

	public function postCreatePost(Request $request)
	{
		$this->validate($request, [
			// unique in posts table
			'title' => 'required|max:120|unique:posts',
			'author' => 'required|max:80',
			'body' => 'required'
		]);

		$post = new Post();
		$post->title = $request['title'];
		$post->author = $request['author'];
		$post->body = $request['body'];
		$post->save();

		if (strlen($request['categories']) > 0) {
			$categoryIDs = explode(',', $request['categories']);
			foreach($categoryIDs as $categoryID) {
				// attaches category_id to post_id and inserts into post_categories
				// because of the relationship between posts and categories
				$post->categories()->attach($categoryID);
			}
		}
		// Check for failure
		// Attaching categories

		return redirect()->route('admin.index')->with(['success' => 'Post successfully created!']);
	}

	public function postUpdatePost(Request $request)
	{
		$this->validate($request, [
			'title' => 'required|max:120',
			'author' => 'required|max:80',
			'body' => 'required'
		]);

		$post = Post::find($request['post_id']);
		if (!$post) {
			return redirect()->route('admin.blog.index')->with(['fail', 'Post not found!']);
		}

		$post->title = $request['title'];
		$post->author = $request['author'];
		$post->body = $request['body'];
		$post->update();
		// Check for failure

		// remove relationship between posts and categories but leaves
		// the posts and categories records
		// since we will rebuild the relationships
		$post->categories()->detach();
		
		if (strlen($request['categories']) > 0) {
			$categoryIDs = explode(',', $request['categories']);
			foreach($categoryIDs as $categoryID) {
				// attaches category_id to post_id and inserts into post_categories
				// because of the relationship between posts and categories
				$post->categories()->attach($categoryID);
			}
		}

		// Categories ...

		return redirect()->route('admin.index')->with(['success' => 'Post successfully updated!']);
	}

	public function getDeletePost($post_id)
	{
		$post = Post::find($post_id);
		if (!$post) {
			return redirect()->route('admin.blog.index')->with(['fail', 'Post not found!']);
		}
		$post->delete();

		return redirect()->route('admin.index')->with(['success' => 'Post successfully deleted!']);
	}

	private function shortenText($text, $words_count)
	{
		// get words count
		if (str_word_count($text, 0) > $words_count) {
			// return associative array of words (key=numerical position, value=actual word)
			$words = str_word_count($text, 2);
			// return array of keys (numerical position)
			$pos = array_keys($words);
			// return number of words ($words_count)
			$text = substr($text, 0, $pos[$words_count]) . '...';
		}
		return $text;
	}
}