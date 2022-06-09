<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
// use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Session;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all();

        // $admins = User::whereHas('roles', function ($q) {
        // $q->where('roles.name', '=', 'admin');
        // })->get();
        return view('home', compact('users'));
    }
    public function profile($id)
    {
        // dd($email);
        $users = User::where('id', $id)->first();
        
        return view('profile', compact('users', 'id'));
    }
    public function update(Request $request, $id)
    {
        // dd($request->file);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'regex:/^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i',
            'file'=> 'required|mimes:jpeg,jpg,png,gif'

        ], [
            'name.required' => 'Please enter your name',
            'email.regex' => 'Please enter a valid email address',
            'file.required' => 'Please select a file',
            'file.mimes' => 'Please select a valid file',
        ]);
        if ($validator->fails()) {
            return Response::json(array(
                'message' => $validator->getMessageBag()->toArray(),
                'errors' => true
            ), 200);
        }
        $password = Hash::make($request->password);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time().$file->getClientOriginalName();
            $request->file('file')->storeAs('public/images/', $filename);
            if ($request->password == null) {
                $users = User::where('id', $id)->update(['name' => $request->name, 'email' => $request->email, 'path' => $filename]);
            } else {
                $users = User::where('id', $id)->update(['name' => $request->name, 'email' => $request->email, 'password' => $password, 'path' => $filename]);
            }
        }
    }
    public function delete($id)
    {
        User::where('id', $id)->delete();
    }
    public function addUser()
    {
        return view('add');
    }
    public function storeUser(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
            'email' => 'unique:users,email|regex:/^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i',
            'file'=> 'required|mimes:jpeg,jpg,png,gif|dimensions:max_width=500,max_height=500'
        ], [
            'name.required' => 'Please enter your name',
            'password.required' => 'Please enter your password',
            'email.unique' => 'This email is already registered',
            'email.regex' => 'Please enter a valid email address',
            'file.required' => 'Please select a file',
            'file.mimes' => 'Please select a valid file',
            'file.dimensions' => 'Please upload photo 200x200',
        ]);
        if ($validator->fails()) {
            return Response::json(array(
                'message' => $validator->getMessageBag()->toArray(),
                'errors' => true
            ), 200);
        }
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time().$file->getClientOriginalName();
            $request->file('file')->storeAs('public/images/', $filename);
        }
        $data =
        [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'path' => $filename
        ];
        $user = User::create($data);

        auth()->login($user);
    }
}
