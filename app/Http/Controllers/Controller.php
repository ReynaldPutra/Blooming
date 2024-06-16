<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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

}
