<?php

namespace App\Http\Controllers;

use App\Models\CartDetail;
use App\Models\Carts;
use App\Models\Item;
use App\Models\TransactionDetail;
use App\Models\TransactionHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //CART
    public function viewCart()
    {

        $id = Auth::user()->id;
        $cart_count = Carts::join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
            ->where('carts.user_id', $id)
            ->sum('cart_details.qty');

        return view('user.cartList', [
            'title' => 'Cart Page',
            'cartitems' => Carts::latest('carts.created_at')->where('carts.user_id', '=', strval(Session::get('user')['id']))
                ->join('cart_details', 'carts.id', '=', 'cart_details.cart_id')->join('items', 'items.id', '=', 'cart_details.item_id')
                ->groupBy('carts.id')->selectRaw('sum(qty*price) as sum,sum(qty) as ctr, carts.id')->first(),
            'cart_count' => $cart_count,
        ]);
    }

    public function runAddCart(Request $req)
    {
        $validator = $req->validate([
            'qty' => 'required|gte:1',
            "id" => 'exists:items',
        ]);
        if (!Session::get('user')) {
            return redirect()->route('login');
        }
        if (Carts::where('user_id', '=', strval(Session::get('user')['id']))->get()->count() == 0) {
            $cart = new Carts();
            $cart->user_id = Session::get('user')['id'];
            $cart->save();
        }
        $cartId = Carts::where('user_id', '=', strval(Session::get('user')['id']))->select('id')->first()['id'];
        if (CartDetail::where([['cart_id', '=', $cartId], ['item_id', '=', $validator['id']]])->get()->count() != 0) {
            CartDetail::where([['cart_id', '=', $cartId], ['item_id', '=', $validator['id']]])->increment('qty', $validator['qty']);
        } else {
            $cartDetail = new CartDetail();
            $cartDetail->cart_id = $cartId;
            $cartDetail->item_id = $validator['id'];
            $cartDetail->qty = $validator['qty'];
            $cartDetail->save();
        }
        return back()->with('success', 'Added!');
    }

    public function viewUpdateCart(Item $product)
    {
        $id = Auth::user()->id;
        $cart_count = Carts::join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
            ->where('carts.user_id', $id)
            ->sum('cart_details.qty');

        return view('user.updateCart', [
            'title' => "Update Cart Item",
            "product" => $product,
            "qty" => Carts::where('user_id', '=', strval(Session::get('user')['id']))->first()->cartDetail()->where('cart_details.item_id', '=', $product->id)->first()['qty'],
            "cart_count" => $cart_count,
        ]);
    }
    public function runUpdateCartqty(Request $req)
    {
        $rules = [
            'qty' => 'required|gte:1',
            "id" => 'exists:items',
        ];

        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        if (!Session::get('user') || Carts::where('user_id', '=', strval(Session::get('user')['id']))->get()->count() == 0) {
            return redirect()->route('login');
        }
        $header = Carts::where('user_id', '=', strval(Session::get('user')['id']))->first('id');
        CartDetail::where([['cart_id', '=', $header['id']], ['item_id', '=', $req->id]])->update(['qty' => $req->qty]);
        return back()->with('success', 'Updated!');
    }

    public function runDeleteCartItem(Request $req)
    {
        if (!Session::get('user') || Carts::where('user_id', '=', strval(Session::get('user')['id']))->get()->count() == 0) {
            return redirect()->route('login');
        }
        CartDetail::where([['cart_id', '=', $req->cart_id], ['item_id', '=', $req->item_id]])->delete();
        return back();
    }

    public function viewTransaction()
    {
        $id = Auth::user()->id;
        $cart_count = Carts::join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
            ->where('carts.user_id', $id)
            ->sum('cart_details.qty');
        return view('user.transactionHistory', [
            'title' => 'Transaction History',
            'histories' => TransactionHeader::latest('transaction_headers.created_at')->where('transaction_headers.user_id', '=', strval(Session::get('user')['id']))
                ->join('transaction_details', 'transaction_headers.id', '=', 'transaction_details.transaction_id')->join('items', 'items.id', '=', 'transaction_details.item_id')
                ->groupBy(['transaction_headers.id', 'transaction_headers.created_at'])->selectRaw('sum(qty*price) as sum,sum(qty) as ctr, transaction_headers.id, transaction_headers.created_at as created')->get(),
            'cart_count' => $cart_count,
        ]);
    }

    public function runCheckout(Request $req)
    {
        $rules = [
            'name' => 'required',
            "address" => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $transheader = new TransactionHeader();
        $transheader->receiver_name = $req->name;
        $transheader->receiver_address = $req->address;
        $transheader->user_id = Session::get('user')['id'];
        $transheader->save();
        $cartdetail = CartDetail::where('cart_id', '=', $req->cart_id)->get();

        foreach ($cartdetail as $detail) {
            $transdetail = new TransactionDetail();
            $transdetail->transaction_id = $transheader->id;
            $transdetail->item_id = $detail->item_id;
            $transdetail->qty = $detail->qty;
            $transdetail->save();
        }
        CartDetail::where('cart_id', '=', $req->cart_id)->delete();
        return redirect()->route('transactionHistory');
    }
}
