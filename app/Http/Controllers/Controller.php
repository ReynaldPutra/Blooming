<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Mail\sendMail;
use App\Mail\VerifyEmail;
use App\Models\Carts;
use App\Models\Item;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //HOME
    public function viewHome()
    {
        $data_recycle = item::where("category", "=", "Recycle")->orderBy('created_at', 'desc')->take(4)->get();
        $data_second = item::where("category", "=", "Second")->orderBy('created_at', 'desc')->take(4)->get();
        if (Auth::id()) {
            $id = Auth::user()->id;
            $cart_count = Carts::join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
                ->where('carts.user_id', $id)
                ->sum('cart_details.qty');
            return view('home', compact('data_recycle', 'data_second', 'cart_count'));
        }
        return view('home', compact('data_recycle', 'data_second'));
    }

    //ABOUT US
    public function viewAboutUs()
    {
        if (Auth::id()) {
            $id = Auth::user()->id;
            $cart_count = Carts::join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
                ->where('carts.user_id', $id)
                ->sum('cart_details.qty');
            return view('aboutUs', compact('cart_count'));
        }
        return view('aboutUs');
    }

    //CONTACT
    public function viewContact()
    {
        if (Auth::id()) {
            $id = Auth::user()->id;
            $cart_count = Carts::join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
                ->where('carts.user_id', $id)
                ->sum('cart_details.qty');
            return view('contact', compact('cart_count'));
        }
        return view('contact');
    }

    public function post_message(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ];

        Mail::to('developerbocil@gmail.com')->send(new sendMail($data));

        return redirect()->back()->with('message', 'Thanks for reaching out. Your message has been sent successfully.');

    }

    //PROFILE

    public function viewLogin()
    {
        if (Session::get('user')) {
            return redirect()->route('home');
        }

        return view('login');
    }

    public function runLogin(Request $req)
    {
        $rules = [
            'email' => 'required|exists:users,email',
            'password' => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $user = Auth::getProvider()->retrieveByCredentials([
            'email' => $req->email,
        ]);

        $credentials = [
            'email' => $req->email,
            'password' => $req->password,
        ];

        if (!$user || !Auth::attempt($credentials)) {
            return back()->withErrors('invalid credentials');
        }

        if (!$user->verified_at) {

            $user->email_verification_token = Str::random(32);
            $user->save();

            $verificationLink = route('verify.email', ['token' => $user->email_verification_token]);
            Mail::to($user->email)->send(new VerifyEmail($user, $verificationLink));

            Auth::logout();
            return back()->withErrors('Please verify your email before logging in.');
        }

        Session::put('user', Auth::user());

        if ($req->remember === 'on') {

            Cookie::queue('email', $req->email, 20);
            Cookie::queue('password', $req->password, 20);
        } else {
            Cookie::queue(Cookie::forget('email'));
            Cookie::queue(Cookie::forget('password'));
        }

        if (Session::get('user')['role'] === 'admin') {
            return redirect('/dashboard');
        }

        return redirect('/home');
    }

    public function forgetPassword()
    {
        return view('forgetPassword');
    }

    public function runForgetPassword(Request $request)
    {
        $customMessage = [
            'email.exists' => 'The email is not registered',
        ];

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], $customMessage);

        $token = Str::random(60);
        PasswordReset::updateOrCreate(
            [
                'email' => $request->email,
            ],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => now(),
            ]
        );

        Mail::to($request->email)->send(new ResetPasswordMail($token));

        return redirect()->back()->with('success', 'We\'ve sent you an email with a link to reset your password');

    }

    public function resetPassword(Request $request, $token)
    {

        $getToken = PasswordReset::where('token', $token)->first();

        if (!$getToken) {
            return redirect()->route('login')->with('failed', 'Token invalid');
        }
        return view('resetPassword', compact('token'));
    }

    public function runResetPassword(Request $request)
    {
        $rules = [
            'password' => 'required',
            'newpassword' => 'required|min:6',
            'confirmPassword' => 'required|same:newpassword',
        ];
        $request->validate($rules);

        $token = PasswordReset::where('token', $request->token)->first();

        if (!$token) {
            return redirect()->route('login')->with('failed', 'Token Invalid');
        }

        $user = User::where('email', $token->email)->first();

        if (!$user) {
            return redirect()->route('login')->with('failed', 'The email is not registered');
        }

        if (!Hash::check($request->input('password'), $user->password)) {
            return redirect()->back()->with('failed', 'Incorrect old password');
        }

        $user->password = Hash::make($request->input('newpassword'));
        $user->save();

        $token->delete();
        return redirect()->route('login')->with('register_success', 'Password Successfully Reset!');
    }

    public function runLogout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }

    public function viewEdit()
    {

        $user = auth()->user();
        $cart_count = Carts::join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
            ->where('carts.user_id', $user->id)
            ->sum('cart_details.qty');
        return view('editProfile', compact('user', 'cart_count'));
    }

    public function runEditProfile(Request $request)
    {
        $rules = [
            'username' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email,' . auth()->user()->id,
        ];
        $request->validate($rules);

        $user = User::find(auth()->user()->id);
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->save();

        return redirect('/editProfile')->with('success', 'Profile Successfully Updated!');
    }

    public function viewChange()
    {
        $user = auth()->user();
        $cart_count = Carts::join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
            ->where('carts.user_id', $user->id)
            ->sum('cart_details.qty');
        return view('changePassword', compact('user', 'cart_count'));
    }

    public function runChangePassword(Request $request)
    {

        $rules = [
            'password' => 'required',
            'newpassword' => 'required|min:6',
            'confirmPassword' => 'required|same:newpassword',
        ];
        $request->validate($rules);

        $user = User::find(auth()->user()->id);
        if (!Hash::check($request->input('password'), $user->password)) {
            return redirect()->back()->with('fail', 'Incorrect old password');
        }
        $user->password = Hash::make($request->input('newpassword'));
        $user->save();

        return redirect()->back()->with('success', 'Password Successfully Changed!');
    }
}
