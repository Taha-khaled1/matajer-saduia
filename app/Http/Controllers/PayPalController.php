<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\AdaptivePayments;

class PayPalController extends Controller
{

    public function goPayment()
    {

        return view('products.welcome');
    }
    public function payment(Request $request)
    {
        $data = [];
        $order = Order::find($request['order_id']);

        $data['items'] = [
            [
                'name' => 'one order',
                'price' => $order->total,
                'desc' => $order->description,
                'qty' => 1
            ],

        ];

        $data['invoice_id'] = $order->id;
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = route('payment.success', ['order_id' => $order->id]);
        $data['cancel_url'] = route('payment.cancel', ['order_id' => $order->id]);
        $data['total'] = $order->total;

        $provider = new ExpressCheckout;

        $response = $provider->setExpressCheckout($data);

        $response = $provider->setExpressCheckout($data, true);
        if (!isset($response['paypal_link'])) {
            Log::error('PayPal link not set in the response.', ['response' => $response]);
            return response()->json(['message' => 'Error processing the payment.', 'response' => $response], 500);
        }
        return redirect($response['paypal_link']);
    }

    public function cancel(Request $request)
    {
        $orderId = $request->query('order_id');
        $order = Order::find($orderId);
        $order->payment_status = 'failed';
        $order->payment_method = 'paypal';
        $order->cancelled = true;
        $order->save();
        return response()->json([
            'status_code' => 200,
            'message' => 'Payment is canceled',
        ], 200);
    }

    public function success(Request $request)
    {
        $provider = new ExpressCheckout;
        $response = $provider->getExpressCheckoutDetails($request->token);

        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            $orderId = $request->query('order_id');
            $order = Order::find($orderId);
            $order->payment_status = 'paid';
            $order->payment_method = 'paypal';
            $order->save();
            $user = User::find($order->user_id);
            CartItem::where('user_id',  $user->id)->delete();
            $user->refund -=  $order->refound_money;
            $user->save();
            sendNotificationToAdmin('اضافة طلبيه', ' قام العميل ' . $user->name . ' بانشاء طلبيه جديده ' . ' معرف الطلبيه ' . $orderId, env("BASE_URL") . "/dashboard/orders/invoice/" . $orderId);
            // return response()->json([
            //     'status_code' => 200,
            //     'message' => 'Payment completed successfully',
            // ], 200);
            return view("sucss-page");
        }

        return response()->json(['message' => 'Please try again later.'], 500);
    }




    public function initiateRefund($token)
    {
        $provider = new ExpressCheckout();

        // Get the transaction details from PayPal
        $transactionDetails = $provider->getExpressCheckoutDetails($token);

        // Ensure that the transaction is completed and eligible for a refund
        if ($transactionDetails['ACK'] === 'Success' && $transactionDetails['PAYERSTATUS'] === 'verified') {
            // Check if the payment is eligible for a refund (optional, but recommended)
            // if (!$this->isEligibleForRefund($transactionDetails)) {
            //     return "Transaction is not eligible for a refund.";
            // }

            // Calculate the refund amount (you can either refund the full amount or a partial amount)
            $refundAmount = $transactionDetails['AMT'];

            // Initiate the refund
            $refundResponse = $provider->refundTransaction($token, $refundAmount);

            // Check if the refund was successful
            if ($refundResponse['ACK'] === 'Success') {
                // Refund successful, perform necessary actions (e.g., update database, notify the user, etc.)
                // You can also access the refund transaction ID as $refundResponse['REFUNDTRANSACTIONID']
                return "Refund Successful: Transaction ID - " . $refundResponse['REFUNDTRANSACTIONID'];
            } else {
                // Refund failed, handle the error (e.g., log, notify admin, etc.)
                return "Refund Failed: " . $refundResponse['L_LONGMESSAGE0'];
            }
        } else {
            // The transaction is not eligible for a refund or not completed, handle the error
            return "Transaction is not eligible for a refund or not completed.";
        }
    }
}
