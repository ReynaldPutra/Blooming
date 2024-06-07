<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function viewProducts()
    {
        $product = Item::whereNotIn('category', ['Custom'])->latest()->filter()->paginate(16);
        $category = Item::select('category')->distinct()->get();

        if (Auth::id()) {
            $id = Auth::user()->id;
            $cart_count = Carts::join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
                ->where('carts.user_id', $id)
                ->sum('cart_details.qty');
            return view('product.showProduct', [
                'title' => 'Show Products',
                'products' => $product,
                'category' => $category,
                'selectedCategory' => 'All',
                'order' => 'none',
                'cart_count' => $cart_count,
            ]);
        }

        return view('product.showProduct', [
            'title' => 'Show Products',
            'products' => $product,
            'category' => $category,
            'selectedCategory' => 'All',
            'order' => 'none',
        ]);
    }

    public function viewProductDetail(Item $product)
    {
        if (Auth::id()) {
            $id = Auth::user()->id;
            $cart_count = Carts::join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
                ->where('carts.user_id', $id)
                ->sum('cart_details.qty');
            return view('product.productDetail', [
                "title" => "Product Detail",
                "product" => $product,
                "cart_count" => $cart_count,
            ]);
        }
        return view('product.productDetail', [
            "title" => "Product Detail",
            "product" => $product,
        ]);
    }

    public function filterProduct($category)
    {
        $product = Item::where('category', $category)->latest()->filter()->paginate(16);
        $categoryData = Item::select('category')->distinct()->get();
        if (Auth::id()) {
            $id = Auth::user()->id;
            $cart_count = Carts::join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
                ->where('carts.user_id', $id)
                ->sum('cart_details.qty');
            return view('product.showProduct', [
                'title' => 'Show Products',
                'products' => $product,
                'category' => $categoryData,
                'selectedCategory' => $category,
                'order' => 'none',
                'cart_count' => $cart_count,
            ]);
        }

        return view('product.showProduct', [
            'title' => 'Show Products',
            'products' => $product,
            'category' => $categoryData,
            'selectedCategory' => $category,
            'order' => 'none',
        ]);

    }

    public function orderProducts($category, $order)
    {
        if ($order === 'High') {
            $order = "DESC";
        } elseif ($order === 'Low') {
            $order = "ASC";
        }

        if ($category == 'All') {
            $product = Item::latest()->filter()->orderBy('price', $order)->paginate(16);
        } else {
            $product = Item::where('category', $category)->orderBy('price', $order)->latest()->filter()->paginate(16);
        }

        $categoryData = Item::select('category')->distinct()->get();
        if (Auth::id()) {
            $id = Auth::user()->id;
            $cart_count = Carts::join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
                ->where('carts.user_id', $id)
                ->sum('cart_details.qty');

            return view('product.showProduct', [
                'title' => 'Show Products',
                'products' => $product,
                'category' => $categoryData,
                'selectedCategory' => $category,
                'order' => $order,
                'cart_count' => $cart_count,
            ]);
        }
        return view('product.showProduct', [
            'title' => 'Show Products',
            'products' => $product,
            'category' => $categoryData,
            'selectedCategory' => $category,
            'order' => $order,
        ]);
    }
}
