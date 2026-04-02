<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Auth;
use App\Models\{Order, Status, Product, Role, Transaction, User, Payment};

class OrderController extends Controller
{
    public function makeOrderGet(Product $product)
    {
        $title = "Make Order";
        $product = $product;
        $codPaymentId = Payment::where('payment_method', 'COD')->value('id') ?? Payment::query()->value('id');

        return view("/order/make_order", compact("title", "product", "codPaymentId"));
    }


    public function makeOrderPost(Request $request, Product $product)
    {
        $codPaymentId = Payment::where('payment_method', 'COD')->value('id') ?? Payment::query()->value('id');

        $rules = [
            'address' => 'required|max:255',
            'payment_method' => 'required|in:' . $codPaymentId,
            'quantity' => 'required|numeric|gt:0|lte:' . $product->stock,
            'total_price' => 'required|gt:0',
            'coupon_used' => 'required|gte:0'
        ];


        $message = [
            'quantity.lte' => 'sorry the current available stock is ' . $product->stock,
        ];

        $validatedData = $request->validate($rules, $message);

        try {
            $data = [
                "product_id" => $product->id,
                "user_id" => auth()->user()->id,
                "quantity" => $validatedData["quantity"],
                "address" => $validatedData["address"],
                "shipping_address" => $validatedData["address"],
                "total_price" => $validatedData["total_price"],
                "payment_id" => $codPaymentId,
                "note_id" => 1,
                "status_id" => 2,
                "transaction_doc" => null,
                "is_done" => 0,
                "coupon_used" => $validatedData["coupon_used"]
            ];

            Order::create($data);
            $message = "Orders has been created!";

            myFlasherBuilder(message: $message, success: true);
            return redirect("/order/order_data");
        } catch (\Illuminate\Database\QueryException $exception) {
            return abort(500);
        }
    }


    public function orderData()
    {
        $title = "Order Data";
        if (auth()->user()->role_id == Role::ADMIN_ID) {
            $orders = Order::with("bank", "note", "payment", "user", "status", "product")->where(["is_done" => 0])->orderBy("id", "ASC")->get();
        } else {
            $orders = Order::with("bank", "note", "payment", "user", "status", "product")->where(["user_id" => auth()->user()->id, "is_done" => 0])->orderBy("id", "ASC")->get();
        }
        $status = Status::all();


        return view("/order/order_data", compact("title", "orders", "status"));
    }


    public function orderDataFilter(Request $request, $status_id)
    {
        $title = "Order Data";
        $orders = Order::with("bank", "note", "payment", "user", "status", "product")->where("status_id", $status_id)->orderBy("id", "ASC")->get();
        $status = Status::all();

        return view("/order/order_data", compact("title", "orders", "status"));
    }


    public function getOrderData(Order $order)
    {
        $order->load("product", "user", "note", "status", "bank", "payment");
        return $order;
    }


    public function cancelOrder(Order $order)
    {
        if ($order->status_id == 5) {
            $message = "Your order is already canceled!";

            myFlasherBuilder(message: $message, failed: true);
            return redirect("/order/order_data");
        }
        $updated_data = [
            "status_id" => 5,
            "note_id" => 6,
            "refusal_reason" => null,
        ];

        $order->fill($updated_data);

        if ($order->isDirty()) {
            $order->save();

            $this->couponBack($order);

            $message = "Your order has been canceled!";

            myFlasherBuilder(message: $message, success: true);
            return redirect("/order/order_data");
        }
    }


    private function couponBack(Order $order)
    {
        // return the user's coupon if using a coupon
        $user = Auth::user();

        $new_coupon = (int)$user->coupon + (int)$order->coupon_used;

        $user->coupon = $new_coupon;

        if ($user->isDirty()) {
            $user->save();
        }
    }


    public function rejectOrder(Request $request, Order $order, Product $product)
    {
        if ($request->refusal_reason == "") {
            $message = "Refusal reason cannot be empty!";

            myFlasherBuilder(message: $message, failed: true);
            return redirect("/order/order_data");
        }

        if ($order->status_id == 4) {
            $message = "Order status is already succeded by admin";

            myFlasherBuilder(message: $message, failed: true);
            return redirect("/order/order_data");
        }

        if ($order->status_id == 5) {
            $message = "Order status is already canceled by user";

            myFlasherBuilder(message: $message, failed: true);
            return redirect("/order/order_data");
        }

        if ($order->status_id == 3) {
            $message = "Order status is already rejected";

            myFlasherBuilder(message: $message, failed: true);
            return redirect("/order/order_data");
        }

        $updated_data = [
            "status_id" => 3,
            "refusal_reason" => $request->refusal_reason
        ];

        $order->fill($updated_data);

        if ($order->isDirty()) {
            if ($order->getOriginal("status_id") == 1) {
                $this->stockReturn($order, $product);
            }

            $order->save();

            $this->couponBack($order);

            $message = "Order rejected successfully!";

            myFlasherBuilder(message: $message, success: true);
            return redirect("/order/order_data");
        }
    }


    private function stockReturn(Order $order, Product $product)
    {
        $product->stock = $product->stock + $order->quantity;

        if ($product->isDirty()) {
            $product->save();
        }
    }


    public function approveOrder(Order $order, Product $product)
    {
        if ($order->status_id == 1) {
            $message = "Order status is already approved by admin";
            myFlasherBuilder(message: $message, failed: true);

            return redirect("/order/order_data");
        }

        if ($order->status_id == 3) {
            $message = "Can't approve the order that have been rejected before";
            myFlasherBuilder(message: $message, failed: true);

            return redirect("/order/order_data");
        }

        if ($order->status_id == 5) {
            $message = "Can't approve the order that have been canceled by user";
            myFlasherBuilder(message: $message, failed: true);

            return redirect("/order/order_data");
        }

        if ($product->stock - $order->quantity < 0) {
            $message = "Quantity order is out of stock";
            myFlasherBuilder(message: $message, failed: true);

            return redirect("/order/order_data");
        }

        // Approve order
        $updated_data = [
            "status_id" => 1,
            "refusal_reason" => null,
            "note_id" => ($order->payment_id == 1) ? 4 : 1,
        ];

        $order->fill($updated_data);

        if ($order->isDirty()) {
            $order->save();
        }

        // Reduce product stock
        $product->stock = $product->stock - $order->quantity;

        if ($product->isDirty()) {
            $product->save();
        }

        $message = "Order approved successfully!";
        myFlasherBuilder(message: $message, success: true);

        return redirect("/order/order_data");
    }


    public function endOrder(Order $order, Product $product)
    {
        if ($order->status->order_status == "done") {
            $message = "The order has already succeded by admin!";
            myFlasherBuilder(message: $message, failed: true);

            return redirect("/order/order_data");
        }

        if ($order->status->order_status != "approve") {
            $message = "Order has not been approved by the admin!";
            myFlasherBuilder(message: $message, failed: true);

            return redirect("/order/order_data");
        }

        // change order status
        $updated_data = [
            "status_id" => 4,
            "note_id" => 5,
            "is_done" => 1,
            "refusal_reason" => null,
        ];

        $order->fill($updated_data);

        if ($order->isDirty()) {
            $order->save();
        }

        $point_rules = [
            "1" => 3,
            "2" => 4,
            "3" => 5
        ];

        // add point to user
        $user = User::find($order->user_id);
        $point_total = ($point_rules[$product->id] * (int)$order->quantity) + $user->point;
        $user->point = $point_total;
        $user->save();

        $transactional_data = [
            "category_id" => 1,
            "description" => "sales of {$order->quantity} unit of product {$product->product_name}",
            "income" => $order->total_price,
            "outcome" => null,
        ];

        // add transactional data
        Transaction::create($transactional_data);

        $message = "Order has been ended by admin";
        myFlasherBuilder(message: $message, success: true);

        return redirect("/order/order_history");
    }


    public function orderHistory()
    {
        $title = "History Data";
        if (auth()->user()->role_id == Role::ADMIN_ID) {
            $orders = Order::with("bank", "note", "payment", "user", "status", "product")->where(["is_done" => 1])->orderBy("id", "ASC")->get();
        } else {
            $orders = Order::with("bank", "note", "payment", "user", "status", "product")->where(["user_id" => auth()->user()->id, "is_done" => 1])->orderBy("id", "ASC")->get();
        }
        $status = Status::all();

        return view("/order/order_data", compact("title", "orders", "status"));
    }

    public function editOrderGet(Order $order)
    {
        if ($order->status_id == 5) {
            $message = "Action failed, order is already canceled by the user";
            myFlasherBuilder(message: $message, failed: true);

            return redirect("/order/order_data/");
        }

        $title = "Edit Order";
        $order->load("product", "user", "note", "status", "bank", "payment");

        return view("/order/edit_order", compact("title", "order"));
    }

    public function editOrderPost(Request $request, Order $order)
    {
        $rules = [
            'address' => 'required|max:255',
            'quantity' => 'required|numeric|gt:0|lte:' . $order->product->stock,
            'total_price' => 'required|gt:0',
            'coupon_used' => 'required|gte:0'
        ];


        $message = [
            'quantity.lte' => 'sorry the current available stock is ' . $order->product->stock,
        ];

        $validatedData = $request->validate($rules, $message);
        $validatedData["shipping_address"] = $validatedData["address"];

        $order->fill($validatedData);

        if ($order->isDirty()) {

            $order->save();

            $message = "Order has beed updated!";
            myFlasherBuilder(message: $message, success: true);

            return redirect("/order/order_data");
        } else {
            $message = "Action failed, no changes detected";
            myFlasherBuilder(message: $message, failed: true);

            return redirect("/order/edit_order/" . $order->id);
        }
    }

}
