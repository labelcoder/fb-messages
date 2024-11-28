<?php 
namespace App\Libs;

use App\Order;
use App\Product;
use App\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\OrderItem;
use App\ProductPromotion;

class OrderLib
{
    public static function placeOrders($input = [])
    {
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
                                $allQty += (intval(floor(($qty / $promotion->qty))) * intval($promotion->qty_free));
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

        return $response;
    }
    public static function createCustomer($data=[]) {
        $data = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => 'Customer From Facebook',
            'facebook_id' => $data['facebook_id'],
            'line_id' => $data['line_id']
        ];
        $result = Customer::create($data);
        return $result;
    }
}
