<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function viewManageItem()
    {
        return view('admin.viewItem', ['products' => Item::all()]);
    }

    public function viewAddItem()
    {
        return view('admin.addItem');
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
        $validator['image'] = $imageURL;
        Item::create($validator);
        return redirect('/viewItem')->with('success', 'Item Successfully Added!');
    }

    public function viewUpdateItem(Item $product)
    {
        return view('admin.updateItem', [
            'title' => "updateItem",
            "product" => $product,
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
