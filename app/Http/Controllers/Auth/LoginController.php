<?php

namespace App\Http\Controllers\Auth;

use App\Models\user;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'email' => 'regex:/^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i',
        ], [
            'password.required' => 'Please enter your password',
            'email.regex' => 'Please enter a valid email address',
        ]);
        if ($validator->fails()) {
            return Response::json(array(
                'message' => $validator->getMessageBag()->toArray(),
                'errors' => true
            ), 200);
         }
        $user = User::where('email', '=', $request->email)->first();
        if(hash::check($request->password, $user->password)){
            Session::put('name',$user->name);
            Session::put('email',$user->email);
            auth()->login($user);
            // return redirect('/dashboard')->with('success', "Login successfully.");
        } else {
            return Response::json(array(
                'message' => "Invalid email or password",
                'error' => true
            ), 200);
            // return Response::json(array(
            //     'message' => "Invalid email or password",
            //     'errors' => true
            // ), 200);
        }
    }
}
