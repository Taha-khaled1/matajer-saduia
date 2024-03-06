<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;


class CartItemController extends Controller
{
    public function addToCart(Request $request)
    {
        try {
            $userId = $request->user->id;

            $productId = $request->input('product_id');
            $quantity = $request->input('quantity', 1);
            $attributeId = $request->input('attribute_id');

            // Validate the inputs
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id',
                'attribute_id' => 'nullable|exists:attributes,id',
                'quantity' => 'required|integer|min:1',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => __('custom.validation_error'), 'errors' => $validator->errors(), 'status_code' => 400], 400);
            }

            // Check if the same product with the same attribute is already in the user's cart
            $cartItem = CartItem::where('user_id', $userId)
                ->where('product_id', $productId)
                ->where('attribute_id', $attributeId) // Include attribute in the comparison
                ->first();

            if ($cartItem) {
                // Update the quantity
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                // Create a new cart item
                $cartItem = new CartItem([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'attribute_id' => $attributeId,
                ]);
                $cartItem->save();
            }

            return response()->json(['message' => __('custom.product_added_successfully'), 'status_code' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => __('custom.product_not_added'), 'status_code' => 500], 500);
        }
    }
    public function increaseQuantity(Request $request)
    {
        try {
            $cartID = $request->input('cart_id');

            // Validate the inputs
            $validator = Validator::make($request->all(), [
                'cart_id' => 'required|exists:cart_items,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => __('custom.validation_error'), 'errors' => $validator->errors(), 'status_code' => 400], 400);
            }

            // Check if the product is in the user's cart
            $cartItem = CartItem::find($cartID);

            if ($cartItem) {
                // Increase the quantity by one
                $cartItem->quantity++;
                $cartItem->save();
            } else {
                return response()->json(['message' => __('custom.product_not_found_in_cart'), 'status_code' => 404], 404);
            }

            return response()->json(['message' => __('custom.product_quantity_increased_successfully'), 'status_code' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => __('custom.server_issue'), 'status_code' => 500], 500);
        }
    }

    public function reduceQuantity(Request $request)
    {
        try {

            $cartID = $request->input('cart_id');

            // Validate the inputs
            $validator = Validator::make($request->all(), [
                'cart_id' => 'required|exists:cart_items,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => __('custom.validation_error'), 'errors' => $validator->errors(), 'status_code' => 400], 400);
            }

            // Check if the product is already in the user's cart
            $cartItem = CartItem::where('id', $cartID)->first();

            if ($cartItem) {
                // Reduce the quantity by one
                $cartItem->quantity--;

                // If the resulting quantity is zero or less, remove the product from the cart
                if ($cartItem->quantity <= 0) {
                    $cartItem->delete();
                } else {
                    $cartItem->save();
                }
            } else {
                return response()->json(['message' => __('custom.product_not_found_in_cart'), 'status_code' => 404], 404);
            }

            return response()->json(['message' => __('custom.product_quantity_reduced_successfully'), 'status_code' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => __('custom.server_issue'), 'status_code' => 500], 500);
        }
    }

    public function removeFromCart(Request $request)
    {
        try {

            $cartID = $request->input('cart_id');

            // Validate the inputs
            $validator = Validator::make($request->all(), [
                'cart_id' => 'required|exists:cart_items,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => __('custom.validation_error'), 'errors' => $validator->errors(), 'status_code' => 400], 400);
            }


            $cartItem = CartItem::where('id', $cartID)->first();

            if (!$cartItem) {
                return response()->json(['message' => __('custom.product_not_found_in_cart'), 'status_code' => 404], 404);
            }

            // Remove the product from the user's cart
            $cartItem->delete();

            return response()->json(['message' => __('custom.product_removed_successfully'), 'status_code' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => __('custom.failed_to_remove_product'), 'status_code' => 500], 500);
        }
    }
    // // DB::raw('(products.price - IFNULL(products.discount, 0)) * cart_items.quantity as subtotal'),
    public function getCartItems(Request $request)
    {
        try {
            $userId = $request->user->id;
            $cartItemsss = CartItem::cartItemsData($userId)->get();
            $dataPrices = $this->calculateTotalAndPrices($cartItemsss);
            $cartItems = CartItem::with('product.user')->where('user_id', $userId)->get();


            // Group products by merchant
            $itemsByMerchant = $cartItems->groupBy('product.user.id')->map(function ($items, $merchantId) {
                $merchant = $items->first()->product->user;
                return [
                    'merchant_info' => [
                        'id' => $merchant->id,
                        'name' => $merchant->name,
                        'phone' => $merchant->phone,
                        'shipping_companies' => $merchant->shippingCompanies, //->where("name_ar", "asdasd"),  // Include any other merchant details you need
                    ],
                    'products' => $items->map(function ($item) {
                        return [
                            "cart_id" => $item->id,
                            "attribute_id" => $item->attribute_id,
                            "product_id" => $item->product_id,
                            "product" => [
                                "id" => $item->product->id,
                                "name" => $item->product->name_ar,
                                "image" => $item->product->image,
                                "quantity" => $item->product->quantity,
                                "price" => $item->product->price,
                                "discount" => $item->product->discount,
                                "percentage_discount" => $item->product->percentage_discount,
                                "shipping_fee" => $item->product->shipping_fee,
                                "discount_start" => $item->product->discount_start,
                                "discount_end" => $item->product->discount_end,
                                "weight" => $item->product->weight,
                                "final_price" => $item->product->final_price,
                            ]
                        ];
                        //["product" => $item->product->select('id')];
                    }),
                ];
            })->values(); // هنا تتم إضافة values() لحذف المفاتيح العشوائية والاحتفاظ فقط بالقيم.
            return response()->json([
                'cart_items_by_merchant' => $itemsByMerchant,
                'cart_prices' => $dataPrices->original,
                'message' => 'Success',
                'status_code' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => __('custom.failed_to_retrieve_data') . $e, 'status_code' => 500], 500);
        }
    }
    public function deleteCartItemsByMerchant(Request $request)
    {
        try {
            $userId = $request->user->id;
            $merchantId = $request->merchantId;
            // Find cart items associated with the specified merchant for the current user
            $cartItemsToDelete = CartItem::whereHas('product.user', function ($query) use ($merchantId) {
                $query->where('id', $merchantId);
            })->where('user_id', $userId)->get();

            // Delete the cart items
            $cartItemsToDelete->each(function ($cartItem) {
                $cartItem->delete();
            });

            return response()->json([
                'message' => 'Cart items from the specified merchant have been deleted successfully',
                'status_code' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => __('custom.failed_to_delete_cart_items') . $e, 'status_code' => 500], 500);
        }
    }



    public function checkOut(Request $request)
    {
        try {
            $token = $request->header('Authorization');
            $mainRoute = env('MAIN_ROUTE');
            $user = $request->user;
            $cartPriceResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get($mainRoute . '/cart/items');
            // return $cartPriceResponse;
            $cartPrice = $cartPriceResponse->json();

            $userId = $user->id;
            $couponCode = $request->input('coupon_code');
            $country_tax = 0.0;

            $cartItems = CartItem::cartItemsData($userId)->get();
            $adreess = UserAddress::find($request->user_address_id);
            $country_tax = $this->calculateWeightProduct($cartItems, $adreess->country);
            $coupon = Coupon::where('code', $couponCode)
                ->where('start_date', '<=', now())
                ->where(function ($query) {
                    $query->where('end_date', '>=', now())
                        ->orWhereNull('end_date');
                })
                ->first();
            if ($coupon) {
                if ($coupon->type == "shipping") {
                    $country_tax = 0.0;
                } else {
                    $cartPrice['cart_prices']['discount_coupon'] = $coupon->discount_amount;
                    $cartPrice['cart_prices']['total_discount'] += $coupon->discount_amount;
                    $cartPrice['cart_prices']['total'] -= $coupon->discount_amount ?? 0;
                }
            }

            $cartPrice['cart_prices']['country_tax'] = $country_tax ?? 0;
            $cartPrice['cart_prices']['total'] += $country_tax ?? 0;

            if ($cartPrice['cart_prices']['total'] < 0) {
                $cartPrice['cart_prices']['total'] = 0;
            }

            if ($user->refund > 0) {
                if ($user->refund < $cartPrice['cart_prices']['total']) {
                    $cartPrice['cart_prices']['total'] -= $user->refund;
                    $cartPrice['cart_prices']['refound_money'] = $user->refund;
                } elseif ($user->refund >= $cartPrice['cart_prices']['total']) {
                    $totalrefund = $cartPrice['cart_prices']['total'];
                    $cartPrice['cart_prices']['total'] -= $totalrefund;
                    $cartPrice['cart_prices']['refound_money'] = $totalrefund;
                }
                $cartPrice['cart_prices']['isrefund'] = true;
            } else {
                $cartPrice['cart_prices']['isrefund'] = false;
                $cartPrice['cart_prices']['refound_money'] = 0;
            }
            return response()->json([
                'check_out' => $cartPrice["cart_prices"],
                'message' => 'Success',
                'status_code' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => __('custom.failed_to_retrieve_data') . $e, 'status_code' => 500], 500);
        }
    }

    public function clear(Request $request)
    {
        $userId = $request->user->id;
        CartItem::where('user_id', $userId)->delete();

        return response()->json(['message' => __('custom.cart_cleared'),]);
    }







    public function applyCoupon(Request $request)
    {
        // subtotal -> without total_shipping_fee
        $userId = $request->user->id;
        $couponCode = $request->input('coupon_code');
        if (!$couponCode) {
            return response()->json(['error' => __('custom.coupon_code_required')], 400);
        }

        $coupon = Coupon::where('code', $couponCode)
            ->where('start_date', '<=', now())
            ->where(function ($query) {
                $query->where('end_date', '>=', now())
                    ->orWhereNull('end_date');
            })
            ->first();

        if (!$coupon) {
            return response()->json(
                [
                    'message' => __('custom.invalid_coupon_code'),
                    'status_code' => 400


                ],
                400

            );
        }

        $cartItems = CartItem::cartItemsData($userId)->get();
        $dataPrices = $this->calculateTotalAndPrices($cartItems, $coupon->discount_amount ?? 0);

        return response()->json([
            'cart_prices' => $dataPrices->original,
            'coupon' => $coupon,
            'message' => 'Success',
            'status_code' => 200
        ]);
    }


    public function calculateWeightProduct($cartItems, $country)
    {
        $responsCountry = Country::where('name', $country)->first();
        $tax = $responsCountry->country_tax;
        $country_tax = 0.0;
        foreach ($cartItems as $item) {
            $country_tax += ($item->weight * $item->quantity) * $tax;
        }


        return $country_tax;
    }
    public function calculateTotalAndPrices($cartItems, $coupon = 0)
    {
        $total_shipping_fee = 0.0;
        $total_discount = 0.0;
        $subtotal = 0.0;
        $total = 0.0;
        $currentTime = Carbon::now();
        foreach ($cartItems as $item) {
            $total_shipping_fee += $item->shipping_fee * $item->quantity;

            $discountStartTime = Carbon::parse($item->discount_start);
            $discountEndTime = Carbon::parse($item->discount_end);

            // Check if the current time is within the discount start and end time
            if ($currentTime->isBetween($discountStartTime, $discountEndTime)) {

                $total_discount += $item->discount * $item->quantity;
            }



            $price = $item->price;
            if ($item->attribute) {
                $price = $item->attribute->price;
                $item->price = $price;
            }
            $subtotal += $price * $item->quantity;
        }
        $total_discount = $total_discount + $coupon;
        $total = ($total_shipping_fee + $subtotal) - $total_discount;

        return response()->json([

            'total_shipping_fee' => $total_shipping_fee,
            'total_discount' => $total_discount,
            'subtotal' => $subtotal,
            'total' => $total,
        ], 200);
    }
}

// Calculate total_country_tax based on the total weight of the products in the cart
// $total_country_tax = 0;
// foreach ($cartItems as $cartItem)
// {
//     $product = Product::find($cartItem->product_id);
//     $total_country_tax += ($product->weight * $cartItem->quantity) * $product->country_tax;
// }                // 'total_country_tax' => $total_country_tax,