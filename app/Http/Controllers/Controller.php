<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //HOME
    public function viewHome()
    {
        return view('home');
    }

    //PROFILE
    public function viewRegister()
    {
        if (Session::get('user')) {
            return redirect()->route('home');
        }

        return view('register');
    }

    public function runRegister(Request $req)
    {
        $rules = [
            'fullname' => 'required|string|min:3',
            'email' => 'unique:users,email|email',
            'password' => 'required|string|min:6',
            'confirmPassword' => 'required|same:password',
        ];

        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $user = new User();
        $user->username = $req->fullname;
        $user->email = $req->email;
        $user->role = 'customer';
        $user->password = Hash::make($req->password, [
            'rounds' => 12,
        ]);
        $user->save();
        return redirect()->route('login')->with('register_success', 'Account Successfully Registered!');
    }

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

        $credentials = [
            'email' => $req->email,
            'password' => $req->password,
        ];

        if (!Auth::attempt($credentials)) {
            return back()->withErrors('invalid credentials');
        }

        Session::put('user', Auth::user());
        if ($req->remember === 'on') {

            Cookie::queue('email', $req->email, 20);
            Cookie::queue('password', $req->password, 20);
        } else {
            Cookie::queue(Cookie::forget('email'));
            Cookie::queue(Cookie::forget('password'));
        }
        return redirect('/home');
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
        return view('editProfile', compact('user'));
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
        return view('changePassword', compact('user'));
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
            return redirect('/changePassword')->with('fail', 'Incorrect old password');
        }
        $user->password = Hash::make($request->input('newpassword'));
        $user->save();

        return redirect('/changePassword')->with('success', 'Password Successfully Changed!');
    }

    //PRODUCTS

    public function viewProducts()
    {
        return view('product.showProduct', [
            'title' => 'Show Products',
            'products' => Item::latest()->filter()->paginate(3),
        ]);
    }

    public function viewProductDetail(Item $product)
    {
        return view('product.productDetail', [
            "title" => "Product Detail",
            "product" => $product,
        ]);
    }

}
