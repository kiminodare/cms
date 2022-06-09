<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\article;
use App\Models\article_category;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $article = Article::all();
        return view('articles.index', compact('article'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cat = article_category::all();
        $category = array_map(function($item){
            $items = [];
           $items[$item['id']] = $item['name'];
           return $items;
        }, $cat->toArray());
        return view('articles.create',compact('cat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required|min:10',
            'categories' => 'required',

        ], [
            'title.required' => 'Please enter your title',
            'content.regex' => 'Minimum 10 characters',
            'categories.required' => 'Please select category',
        ]);
        if ($validator->fails()) {
            return Response::json(array(
                'message' => $validator->getMessageBag()->toArray(),
                'errors' => true
            ), 200);
        }
        $data = 
        [
            'title' => $request->title,
            'content' => $request->content,
            'id_category' => $request->categories,
        ];
        $Content = article::create($data);
        return Response::json(array(
            'message' => "Article successfully created.",
            'errors' => false
        ), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::find($id);
        $cat = article_category::find($article->id_category);
        $categories = article_category::all();
        return view('articles.edit', compact('article','id','cat','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required|min:10',
            'categories' => 'required',

        ], [
            'title.required' => 'Please enter your title',
            'content.regex' => 'Minimum 10 characters',
            'categories.required' => 'Please select category',
        ]);
        if ($validator->fails()) {
            return Response::json(array(
                'message' => $validator->getMessageBag()->toArray(),
                'errors' => true
            ), 200);
        }
        $data = 
        [
            'title' => $request->title,
            'content' => $request->content,
            'id_category' => $request->categories,
        ];
        $Content = article::find($id)->update($data);
        return Response::json(array(
            'message' => "Article successfully updated.",
            'errors' => false
        ), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        article::where('id', $id)->delete();
        return Response::json(array(
            'message' => "Article successfully deleted.",
            'errors' => false
        ), 200);
    }
}
