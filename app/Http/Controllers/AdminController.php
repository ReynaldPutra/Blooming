<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\TransactionHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function viewManageItem()
    {
        $products = Item::whereNotIn('category_id', function ($query) {
            $query->select('id')->from('categories')->where('name', 'Custom');
        })->latest()->filter()->paginate(10);
        return view('admin.manageItem', compact('products'));
    }
    public function viewOrder()
    {
        $orders = TransactionHeader::latest()->get();
        return view('admin.viewOrder', compact('orders'));
    }
    public function viewOrderDetail($id)
    {
        $orderDetail = TransactionHeader::latest('transaction_headers.created_at')->where('transaction_headers.id', '=', $id)
            ->join('transaction_details', 'transaction_headers.id', '=', 'transaction_details.transaction_id')
            ->join('items', 'items.id', '=', 'transaction_details.item_id')
            ->selectRaw('transaction_headers.*')->first();

        // dd($orderDetail);
        return view('admin.viewOrderDetail', compact('orderDetail'));
    }

    public function runUpdateDeliver($id)
    {
        $orders = TransactionHeader::latest()->get();

        $order = TransactionHeader::find($id);

        if ($order) {
            if ($order->delivery_status == 'Delivered') {
                return redirect()->back()->with('success', 'Order Already Delivered');
            }
            $order->delivery_status = 'Delivered';
            $order->save();

            return redirect()->back()->with('success', 'Order delivered successfully');
        } else {
            return redirect()->back()->with('error', 'Order not found.');
        }

        return view('admin.viewOrder', compact('orders'));
    }

    public function viewDashboard()
    {
        $product_count = Item::all()->count();
        $sales_count = TransactionHeader::all()->count();
        $delivery_count = TransactionHeader::where('delivery_status', 'Delivered')->count();
        $order = TransactionHeader::all();
        return view('admin.dashboard', compact('product_count', 'sales_count', 'delivery_count', 'order'));
    }

    public function viewAddItem()
    {
        $category = Category::where('name', '!=', 'Custom')->get();

        return view('admin.addItem', compact('category'));
    }

    public function runAddItem(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id' => 'required|unique:items|string|min:3|max:3',
            'name' => 'required|unique:items|string|max:20',
            'price' => 'required|numeric|gte:500',
            'description' => 'required|string|max:500',
            'image' => 'required|image',
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $image = $req->file('image');
        $imageName = date('YmdHi') . $image->getClientOriginalName();
        $imageURL = 'images/' . $imageName;

        $destinationPath = public_path('images');
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }
        $image->move($destinationPath, $imageName);

        $item = new Item([
            'id' => $req->id,
            'name' => $req->name,
            'price' => $req->price,
            'description' => $req->description,
            'image' => $imageURL,
            'category_id' => $req->category_id,
        ]);
        $item->save();
        return redirect('/viewItem')->with('success', 'Item Successfully Added!');
    }

    public function viewUpdateItem(Item $product)
    {

        $category = Category::where('name', '!=', 'Custom')->get();

        return view('admin.updateItem', [
            'title' => "updateItem",
            "product" => $product,
            "category" => $category,
        ]);
    }

    public function runUpdateItem(Request $req, Item $product)
    {

        $rules = [
            'price' => 'required|numeric|gte:500',
            'description' => 'required|string|max:500',
            'category_id' => 'required',
        ];

        if ($req->name != $product->name) {
            $rules['name'] = 'required|unique:items|string|max:20';
        }

        if ($req->has('image')) {
            $rules['image'] = 'required|image';
            $validator = $req->validate($rules);
            if ($product->image !== 'images/default-image.jpg') {
                Storage::delete('public/' . $product->image);
            }

            $image = $req->file('image');
            $imageName = date('YmdHi') . $image->getClientOriginalName();
            Storage::putFileAs('public/images', $image, $imageName);
            $imageURL = 'images/' . $imageName;
            $validator['image'] = $imageURL;
            Item::where('id', $product->id)->update($validator);
        } else {
            $validator = $req->validate($rules);
            $validator['image'] = $product->image;
            Item::where('id', $product->id)->update($validator);
        }
        return redirect('/viewItem')->with('success', 'Item Successfully Updated!');
    }

    public function deleteItem(item $product)
    {
        Item::destroy($product->id);
        return redirect('/viewItem')->with('success', 'Item Successfully Deleted!');
    }

    public function viewManageCategory()
    {

        $category = Category::where('name', '!=', 'Custom')->latest()->filter()->paginate(10);
        return view('admin.manageCategory', compact('category'));
    }

    public function deleteCategory(Category $product)
    {
        Category::destroy($product->id);
        Item::where('category_id', $product->id)->delete();
        return redirect('/viewCategory')->with('success', 'Item Successfully Deleted!');
    }

    public function viewAddCategory()
    {
        $category = Category::where('name', '!=', 'Custom')->get();

        return view('admin.addCategory', compact('category'));
    }

    public function runAddCategory(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|unique:items|string|max:20',
            'description' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category = new Category([
            'name' => $req->name,
            'description' => $req->description,
        ]);
        $category->save();
        return redirect('/viewCategory')->with('success', 'Category Successfully Added!');
    }

    public function viewUpdateCategory(Category $product)
    {

        return view('admin.updateCategory', [
            'title' => "updateItem",
            "product" => $product,
        ]);
    }

    public function runUpdateCategory(Request $req, Category $product)
    {

        $rules = [
            'description' => 'required|string|max:500',
        ];

        if ($req->name != $product->name) {
            $rules['name'] = 'required|unique:items|string|max:20';
        }

        $validator = $req->validate($rules);
        Category::where('id', $product->id)->update($validator);

        return redirect('/viewCategory')->with('success', 'Category Successfully Updated!');
    }
}
