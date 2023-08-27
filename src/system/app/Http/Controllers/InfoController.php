<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Info;
use App\Gift;
use App\User;

class InfoController extends Controller
{

	public function getCreate()
	{

		$list = Info::where('status','unpublished')->get();

		if($list->count() > 1)
		{
			$model = Info::where('status', 'unpublished')->first();
		}
		else
		{
			$model = Info::create([
				'title' => 'New Post',
				'slug' => strtolower(str_random(5) . '-' . str_random(5)),
				'body' => '<h1>Enter Your Post Here</h1>',
				'posted_by' => Auth::user()->name,
				'status' => 'unpublished',
				'category' => 'untitled'
			]);
		}



		$post = Info::where('id', $model->id)->first();
		return view('admin.create-info')->with('post', $post);
	}

	public function publish(Request $request)
	{
		Info::where('slug', $request->slug)->update([
			'title' => $request->title,
			'slug' => $request->slug,
			'category' => 'uncategory',
			'body' => $request->body,
			'status' => 'published'
		]);

		return redirect('/info/' . $request->slug);
	}

	public function show($slug)
	{
		$info = Info::where('slug', $slug)->where('status', 'published')->first();
		if(!$info)
		{
			return abort(404);
		}

		return view('global.show-post')->with('post', $info);
	}

	public function list_info()
	{
		$list = Info::get();
		return view('admin.info-list')->with('posts', $list);
	}

	public function delete($id)
	{
		$post = Info::where('id', $id)->first();
		if(!$post)
		{
			return response()->json([
				'success' => false
			],500);
		}

		Info::where('id', $id)->delete();
		return response()->json([
			'success' => true
		]);
	}

	public function edit($id)
	{
		$info = Info::where('id', $id)->first();
		if(!$info)
		{
			return abort(404);
		}

		return view('admin.info-edit')->with('post', $info);
	}

	public function editPost(Request $request)
	{
		Info::where('slug', $request->slug)->update([
			'title' => $request->title,
			'slug' => $request->slug,
			'category' => 'uncategory',
			'body' => $request->body,
			'status' => 'published'
		]);

		return redirect('/info/' . $request->slug);
	}

	public function publishInfo($id)
	{
		$info = Info::where('id', $id)->first();

		if(!$info)
		{
			return response()->json([
				'success' => false
			],500);
		}

		Info::where('id', $id)->update([
			'status' => 'published'
		]);

		return response()->json([
			'/info/' . $info->slug,
		]);
	}

	public function unpublishInfo($id)
	{
		$info = Info::where('id', $id)->first();

		if(!$info)
		{
			return response()->json([
				'success' => false
			],500);
		}

		Info::where('id', $id)->update([
			'status' => 'unpublished'
		]);

		return response()->json([
			'/info/' . $info->slug,
		]);
	}

	public function showList()
	{
		$info = Info::where('status', 'published')->get();
		return view('global.list-info')->with('posts', $info);
	}

	public function reedem(Request $request)
	{
		$gift = Gift::where('code', $request->code)->first();
		if(!$gift)
		{
			return response()->json([
				'success' => false
			],500);
		}

		if($gift->is_reedemed)
		{
			return response()->json([
				'message' => 'used'
			],500);
		}

		User::where('email', Auth::user()->email)->update([
			'balance' => $gift->amount + Auth::user()->balance,
		]);

		Gift::where('id', $gift->id)->update([
			'is_reedemed' => 1,
			'reedemed_by' => Auth::user()->email,
			'reedemed_at' => \Carbon\Carbon::now()
		]);

		return response()->json([
			'message' => $gift->messages
		]);
	}
}
