<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $title = "Product";
        $product = Product::all();

        return view('/product/index', compact("title", "product"));
    }


    public function getProductData($id)
    {
        $product = Product::find($id);

        return $product;
    }


    public function addProductGet()
    {
        $title = "Add Product";

        return view('/product/add_product', compact("title"));
    }


    public function addProductPost(Request $request)
    {
        $validatedData = $request->validate([
            "product_name" => "required|max:50|unique:products,product_name",
            "egg_size" => "required|in:small,medium,large,extra_large",
            "quantity_per_unit" => "required|integer|min:6|max:360",
            "stock" => "required|integer|min:0",
            "price" => "required|numeric|gt:0",
            "discount" => "nullable|numeric|min:0|max:100",
            "description" => "required",
            "image" => "image|max:2048"
        ]);

        $validatedData["discount"] = $validatedData["discount"] ?? 0;

        if (!isset($validatedData["image"])) {
            $validatedData["image"] = env("IMAGE_PRODUCT");
        } else {
            $validatedData["image"] = $request->file("image")->store("product");
        }

        Product::create($validatedData);
        $message = "Product has been added!";

        myFlasherBuilder(message: $message, success: true);

        return redirect('/product');
    }


    public function editProductGet(Product $product)
    {
        $data["title"] = "Edit Product";
        $data["product"] = $product;

        return view("/product/edit_product", $data);
    }


    public function editProductPost(Request $request, Product $product)
    {
        $rules = [
            'egg_size' => 'required|in:small,medium,large,extra_large',
            'quantity_per_unit' => 'required|integer|min:6|max:360',
            'description' => 'required',
            'price' => 'required|numeric|gt:0',
            'stock' => 'required|integer|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'image' => 'image|file|max:2048'
        ];


        if ($product->product_name != $request->product_name) {
            $rules['product_name'] = 'required|max:50|unique:products,product_name';
        } else {
            $rules['product_name'] = 'required|max:50';
        }

        $validatedData = $request->validate($rules);
        $validatedData["discount"] = $validatedData["discount"] ?? 0;

        if ($request->file("image")) {
            if ($request->oldImage != env("IMAGE_PRODUCT")) {
                Storage::delete($request->oldImage);
            }

            $validatedData["image"] = $request->file("image")->store("product");
        }

        $product->fill($validatedData);


        if ($product->isDirty()) {
            $product->save();

            $message = "Product has been updated!";

            myFlasherBuilder(message: $message, success: true);
            return redirect("/product");
        } else {
            $message = "Action <strong>failed</strong>, no changes detected!";

            myFlasherBuilder(message: $message, failed: true);
            return back();
        }
    }
}
