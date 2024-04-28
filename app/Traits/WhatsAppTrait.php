<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

use GuzzleHttp\Client;

trait WhatsAppTrait
{
    function sendWhatsapp($phone, $message) //: bool
    {

        try {

            // function sendOtpWhatsApp($body, $recieveNumber = "+201113051656")
            // {

            $response = Http::post('https://api.ultramsg.com/instance64835/messages/chat', [
                'token' => '1jeqxe85deo79r2a',
                'to' => $phone,
                'body' => $message
            ]);

            return true;

            // $client = new Client([
            //     'headers' => [
            //         'Authorization' => 'Bearer ' . env('LETS_BOT_TOKEN'),
            //         'Content-Type' => 'application/json',
            //         'Accept' => 'application/json',
            //     ]
            // ]);

            // $response = $client->post('https://letsbot.net/api/v1/message/send', [
            //     'json' => [
            //         'phone' => $phone, // Replace this with the correct phone number
            //         'body' => $message,
            //     ],
            // ]);

            // $body = $response->getBody()->getContents();
            // $data = json_decode($body, true); // Decode the JSON response

            // $message = $data['Message'];
            // if ($data == true) {
            //     $key = $data['data']['key'];
            //     $remoteJid = $key['remoteJid'];
            //     $messageId = $key['id'];
            //     return true;
            // } else {
            //     return false;
            // }
        } catch (\Throwable $th) {

            return false;
        }
    } // done

    /////////////////////////////////////////////////////////////### MerchantService ###//////////////////////////////////////////////////////////////////////////////// 
    public function registerStore($merchantName, $packageName): string
    {
        // إرسال رسالة تسجيل المتجر
        return "عزيزي التاجر {$merchantName}\nتم تسجيل متجرك بنجاح في الباقة {$packageName} و يتم حالياً مراجعة بياناتك.\nمتاجر السعودية";
    } // done

    public function activateStore($merchantName): string
    {
        // إرسال رسالة تفعيل المتجر
        return "عزيزي التاجر {$merchantName}\nتم تفعيل متجرك بنجاح ونتمنى لك النجاح معنا، و لا تتردد دائماً بطلب الدعم.\nمتاجر السعودية";
    } // done

    public function upgradePackage($merchantName, $newPackage, $expiryDate): string
    {
        // إرسال رسالة ترقية الباقة
        return "عزيزي التاجر {$merchantName}\nتم ترقية الباقة الى {$newPackage} و تنتهي بتاريخ {$expiryDate} و يتم حالياً مراجعة بياناتك.\nمتاجر السعودية";
    } // done
    public function purchaseNotification($merchantName, $orderNumber, $amount): string
    {
        // إرسال إشعار بعملية شراء
        return "عزيزي التاجر {$merchantName}\nتمت عملية شراء لمنتجاتك برقم الطلب {$orderNumber} و قيمة {$amount}.\nمتاجر السعودية";
    } // done

    public function shippingPolicyIssued($merchantName, $policyNumber, $orderNumber): string
    {
        // إرسال إشعار بإصدار بوليصة شحن
        return "عزيزي التاجر {$merchantName}\nتم اصدار بوليصة شحن رقم {$policyNumber} برقم الطلب {$orderNumber}.\nمتاجر السعودية";
    } // done

    public function orderShipped($merchantName, $orderNumber): string
    {
        // إرسال إشعار بشحن الطلب
        return "عزيزي التاجر {$merchantName}\nتم شحن طلباتك برقم الطلب {$orderNumber}.\nمتاجر السعودية";
    } // done

    public function orderDelivered($merchantName, $orderNumber): string
    {
        // إرسال إشعار بتسليم الطلب
        return "عزيزي التاجر {$merchantName}\nتم تسليم طلباتك برقم الطلب {$orderNumber}.\nمتاجر السعودية";
    } // done

    public function financialClaimClosed($merchantName, $amount, $orderNumber): string
    {
        // إرسال إشعار بإغلاق مطالبة مالية
        return "عزيزي التاجر {$merchantName}\nتم اغلاق مطالبة مالية بمبلغ {$amount} لطلباتك برقم الطلب {$orderNumber}.\nمتاجر السعودية";
    }

    public function returnShippingPolicyIssued($merchantName, $orderNumber, $shippingPolicyNumber): string
    {
        // إرسال إشعار بإصدار بوليصة شحن الإرجاع
        return "عزيزي التاجر {$merchantName}\nتم اصدار بوليصة شحن ارجاع لطلبك برقم {$orderNumber} و رقم بوليصة الشحن {$shippingPolicyNumber}.\nمتاجر السعودية";
    }

    /////////////////////////////////////////////////////////////### CustomerService ###////////////////////////////////////////////////////////////////////////////////

    public function successfulLogin($customerName): string
    {
        // إرسال رسالة تسجيل دخول ناجح
        return "عزيزي العميل {$customerName}\nتم تسجيل دخولك بنجاح و رحلة تسوق ممتعة\nمتاجر السعودية";
    } // done
    public function successfulRegistration($customerName): string
    {
        // إرسال رسالة تسجيل دخول ناجح
        return "عزيزي العميل {$customerName}\nتم انشاء حسابك بنجاح و رحلة تسوق ممتعة\nمتاجر السعودية";
    }
    public function walletRecharge($customerName, $amount, $walletBalance): string
    {
        // إرسال إشعار بشحن المحفظة
        return "عزيزي العميل {$customerName}\nتمت عملية شحن لمحفظتك بمبلغ {$amount} و صيد محفظتك هو {$walletBalance}.\nمتاجر السعودية";
    } // done

    public function purchaseConfirmation($customerName, $orderNumber, $amount): string
    {
        // إرسال تأكيد عملية الشراء
        return "عزيزي العميل {$customerName}\nتمت عملية شراء لطلب رقم {$orderNumber} بمبلغ {$amount}.\nمتاجر السعودية";
    } // done

    public function orderShipping($customerName, $orderNumber, $shipmentNumber): string
    {
        // إرسال إشعار بشحن الطلب
        return "عزيزي العميل {$customerName}\nتمت عملية شحن لطلب رقم {$orderNumber} و رقم الشحنة {$shipmentNumber}.\nمتاجر السعودية";
    } // done

    public function orderDelivery($customerName, $orderNumber, $shipmentNumber): string
    {
        // إرسال إشعار بتسليم الطلب
        return "عزيزي العميل {$customerName}\nتمت عملية تسليم لطلب رقم {$orderNumber} و رقم الشحنة {$shipmentNumber}.\nمتاجر السعودية";
    } // done

    public function returnShippingPolicyIssuedForCustomer($customerName, $orderNumber, $shippingPolicyNumber): string
    {
        // إرسال إشعار بإصدار بوليصة شحن الإرجاع للعميل
        return "عزيزي العميل {$customerName}\nتم اصدار بوليصة شحن ارجاع لطلبك برقم {$orderNumber} و رقم بوليصة الشحن {$shippingPolicyNumber}.\nمتاجر السعودية";
    } // done


    /////////////////////////////////////////////////////////////### AffiliateService ###////////////////////////////////////////////////////////////////////////////////

    public function registerAffiliate($marketerName, $marketingCode): string
    {
        // إرسال رسالة قبول التسجيل في برنامج التسويق بالعمولة
        return "عزيزي المسوق {$marketerName}\nتم قبول تسجيلك في برنامج التسويق بالعمولة و كود التسويق الخاص بك هو {$marketingCode}.\nمتاجر السعودية";
    } // done
    public function purchaseThroughCode($marketerName, $commissionAmount, $totalDue): string
    {
        // إرسال إشعار بعملية شراء عبر كود التسويق
        return "عزيزي المسوق {$marketerName}\nتمت عملية شراء عن طريق كود التسويق الخاص بك و عمولتك هي مبلغ {$commissionAmount} و اجمالي مبالغك المستحقة هو {$totalDue}.\nمتاجر السعودية";
    } // done

    public function claimClosure($marketerName, $transferredAmount, $currentBalance): string
    {
        // إرسال إشعار بإغلاق المطالبة بالتحويل
        return "عزيزي المسوق {$marketerName}\nتم اغلاق مطالبتك بتحويل مبلغ {$transferredAmount} و رصيدك حالياً هو {$currentBalance}.\nمتاجر السعودية";
    }

    /////////////////////////////////////////////////////////////### Auth ###////////////////////////////////////////////////////////////////////////////////
    public function sendCodeVerification($userName, $code): string
    {
        //  ارسال رمز التحقق
        return "عزيزي المستخدم {$userName}\nكود التحقق هو {$code}.\nمتاجر السعودية";
    }
}
