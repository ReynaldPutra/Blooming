<?php

namespace App\Http\Controllers;

use App\Models\Item;

class ProductController extends Controller
{
    public function viewProducts()
    {
        $product = Item::latest()->filter()->paginate(16);
        $category = Item::select('category')->distinct()->get();

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
        return view('product.productDetail', [
            "title" => "Product Detail",
            "product" => $product,
        ]);
    }

    public function filterProduct($category)
    {
        $product = Item::where('category', $category)->latest()->filter()->paginate(16);
        $categoryData = Item::select('category')->distinct()->get();
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
        return view('product.showProduct', [
            'title' => 'Show Products',
            'products' => $product,
            'category' => $categoryData,
            'selectedCategory' => $category,
            'order' => $order,
        ]);
    }
}
