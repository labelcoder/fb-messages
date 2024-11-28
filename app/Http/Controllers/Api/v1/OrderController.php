<?php

namespace App\Http\Controllers\Api\v1;

use App\Order;
use App\Product;
use App\Customer;
use App\FacebookComment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Claims\Custom;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Libs\OrderLib;
use App\OrderItem;
use App\ProductPromotion;

class OrderController extends Controller
{
    function __construct()
    {;
    }
    function store(Request $request)
    {
        $response = ['success' => false, 'data' => [], 'message' => 'Error!'];

        if ($request->method('POST')) {
            $input = $request->all();
            var_dump($input);
            exit;
            $response = OrderLib::placeOrders($input);
        }
        return response()->json($response, 200);
    }
    /*
    function store(Request $request)
    {
        $response = ['success' => false, 'data' => [], 'message' => 'Error!'];

        if ($request->method('POST')) {
            $input = $request->all();
            $response = DB::transaction(function () use ($input) {
                $customer = Customer::find($input['customer_id']);
                $discountAmount = $priceAmount = $totalAmount = 0;
                $data = [
                    'customer_id' => intval($customer->id),
                    'order_date' => Carbon::now()->format('Y-m-d H:i:s'),
                    'status' => 'wait', // wait, processing, paid
                    'total_amount' => $priceAmount,
                    'code' => time(),
                    'price_amount' => $priceAmount,
                    'discount_amount' => $discountAmount,
                    'address' => $input['address'],
                    'note' => $input['note'],
                ];
                $order = Order::create($data);
                // check and cut stock 
                if (isset($input['item_ids']) && count($input['item_ids']) > 0) {
                    foreach ($input['item_ids'] as $itemId) {
                        $product = Product::where('id', intval($itemId))->lockForUpdate()->first();
                        $qty = $input['qty_numbers'][intval($itemId)];
                        $discountAtOrder = $totalOrder = $priceAtOrder = $allQty = 0;
                        $priceAtOrder = $product->price * $qty;
                        $priceAmount += $priceAtOrder;
                        $allQty = $qty;
                        
                        // START check promotion :: ออกแบบให้ product 1 : 1 promotion //
                        $productPromotion = ProductPromotion::where(['product_id' => intval($itemId)])->first();
                        if ($productPromotion) {
                            $promotion = $productPromotion->promotion;
                            if ($promotion) {
                                if ($promotion->discount_percentage > 0) {
                                    $discountAtOrder = $priceAtOrder * ($promotion->discount_percentage / 100);
                                    $discountAmount += $discountAtOrder;
                                }
                                // check if promotion is for all product or not
                                if ($promotion->qty_free > 0) {
                                    $allQty += (intval(floor(($qty/$promotion->qty))) * intval($promotion->qty_free));
                                }
                            }
                        }
                        // END check promotion :: ออกแบบให้ product 1 : 1 promotion //

                        // check qty in stock
                        if ($product->stock_quantity < $allQty) {
                            throw new \Exception('สินค้าไม่เพียงพอ: ' . $product->name);
                        }
                        // cut stock
                        $product->stock_quantity -= intval($allQty);
                        $product->save();

                        // create order items
                        $orderItem = OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $product->id,
                            'price_at_order' => $priceAtOrder,
                            'total_order' => ($priceAtOrder - $discountAtOrder),
                            'quantity' => $allQty
                        ]);
                    }
                }
                $totalAmount = $priceAmount - $discountAmount;
                // update order
                $order->total_amount = $totalAmount;
                $order->price_amount = $priceAmount;
                $order->discount_amount = $discountAmount;
                $order->save();

                return $response = ['success' => true, 'data' => ['order_id' => $order->id], 'message' => 'สั่งซื้อสำเร็จ!'];
            });
        }
        return response()->json($response, 200);
    }
    */
    function findProductCode(Request $request) {
        $pattern = '/SKU-\d{5}/';
        $matchedSkus = [];

        $comments = FacebookComment::all();
        foreach ($comments as $item) {
            if (preg_match($pattern, $item->content, $matches)) {
                $matchedSkus[] = $matches[0];
            }
        }
        dd($matchedSkus);
    }
}
