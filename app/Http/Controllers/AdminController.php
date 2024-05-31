<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\TransactionHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function viewManageItem()
    {
        $products = Item::latest()->filter()->paginate(10);
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
        $delivery_count = TransactionHeader::all()->count();
        $order = TransactionHeader::all();
        return view('admin.dashboard', compact('product_count', 'sales_count', 'delivery_count', 'order'));
    }

    public function viewAddItem()
    {
        $category = Item::select('category')->distinct()->get();

        return view('admin.addItem', compact('category'));
    }

    public function runAddItem(Request $req)
    {

        $validator = $req->validate([
            'id' => 'required|unique:items|string|min:3|max:3',
            'name' => 'required|unique:items|string|max:20',
            'price' => 'required|numeric|gte:500',
            'description' => 'required|string|max:500',
            'image' => 'required|image',
            'category' => 'required|in:Second,Recycle',
        ]);

        $image = $req->file('image');
        $imageName = date('YmdHi') . $image->getClientOriginalName();
        $imageURL = 'images/' . $imageName;

        $destinationPath = public_path('images');
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }
        $image->move($destinationPath, $imageName);

        $validator['image'] = $imageURL;
        Item::create($validator);
        return redirect('/viewItem')->with('success', 'Item Successfully Added!');
    }

    public function viewUpdateItem(Item $product)
    {
        $category = Item::select('category')->distinct()->get();

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
            'category' => 'required|in:Recycle,Second',
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
}
