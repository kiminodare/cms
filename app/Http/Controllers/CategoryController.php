<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\article_category;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = article_category::all();
        return view('category.index', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',

        ], [
            'name.required' => 'Please enter your category',
        ]);
        if ($validator->fails()) {
            return Response::json(array(
                'message' => $validator->getMessageBag()->toArray(),
                'errors' => true
            ), 200);
        }
        $data = 
        [
            'name' => $request->name,
        ];
        $user = article_category::create($data);

        return Response::json(array(
            'message' => 'Successfully created category!',
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
        $category = article_category::find($id);
        return view('category.edit',compact('category','id'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',

        ], [
            'name.required' => 'Please enter your category',
        ]);
        if ($validator->fails()) {
            return Response::json(array(
                'message' => $validator->getMessageBag()->toArray(),
                'errors' => true
            ), 200);
        }
        $data = 
        [
            'name' => $request->name,
        ];
        $user = article_category::create($data);
        return Response::json(array(
            'message' => 'Successfully created category!',
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
        $category = article_category::find($id);
        $category->delete();
        return Response::json(array(
            'message' => 'Successfully created category!',
            'errors' => false
        ), 200);
    }
}
