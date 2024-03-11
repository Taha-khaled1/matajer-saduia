<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Notifications\AdminMessage;
use Illuminate\Support\Facades\Notification;

function Getusername()
{
    return Auth::User()->name;
}

function Getuserphone()
{
    return Auth::User()->phone ?? '0';
}

function  Getusertype()
{
    return Auth::User()->user_type;
}


function Getuserid()
{
    return Auth::User()->id;
}


function Getuseremail()
{
    return Auth::User()->email;
}

function ReverseLanguage($lang)
{
    if (app()->getLocale() == "ar") {
        return "en";
    }
    return "ar";
}
function typeStatusAfallite($status)
{
    if ($status == 'procedure') {
        return 'تحت الاجراء';
    } else if ($status == 'sold') {
        return 'تم البيع';
    } else if ($status == 'charge') {
        return 'تم التحويل للمحفظه';
    } else if ($status == 'return') {
        return 'مرتجع';
    } else {
        return 'مشكله';
    }
}
function typeWithdrawer($status)
{
    if ($status == 'won') {
        return 'ربح';
    } else if ($status == 'drawn') {
        return 'مغلق';
    } else {
        return 'مفتوح';
    }
}
function subScribeStatus($status)
{
    if ($status == 'silver') {
        return 'فضي';
    } else if ($status == 'golden') {
        return 'الذهبي';
    } else {
        return 'العادي';
    }
}
function statusToArabic($status)
{

    if ($status == 'pending') {
        return 'قيد الانتظار';
    } else if ($status == 'processing') {
        return 'قيد المعالجه';
    } else if ($status == 'delivering') {
        return 'جاري التوصيل';
    } else if ($status == 'completed') {
        return 'مكتمل';
    } else if ($status == 'shipped') {
        return 'تم الشحن';
    } else if ($status == 'cancelled') {
        return 'تم الالغاء';
    } else {
        return 'تم الاسترجاع';
    }
}
function roleToArabic($status)
{

    if ($status == 'user') {
        return 'مستخدم';
    } else if ($status == 'affiliate') {
        return 'مسوق بالعموله';
    } else if ($status == 'vendor') {
        return 'بائع';
    } else if ($status == 'admin') {
        return 'مالك';
    } else {
        return 'مستخدم';
    }
}
function generateUniqueInvitationCode()
{
    // Generate a unique random code, for example, a combination of letters and numbers
    $code = strtoupper(substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 10));

    // Check if the generated code already exists in the database
    while (User::where('invitation_code', $code)->exists()) {
        $code = strtoupper(substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 10));
    }

    return $code;
}


function statusPayment($status)
{

    if ($status == 'pending') {
        return 'بانتظار الدفع';
    } else if ($status == 'paid') {
        return 'تم الدفع';
    } else {
        return 'فشل الدفع';
    }
}


function sendNotificationToAdmin($title, $massge, $link = "")
{
    $user = User::where('type', 'admin')->first();
    Notification::send([$user], new AdminMessage($massge, $title, $link));
}


function extractCountryName($fullAddress)
{
    // Use a regular expression to match the last occurrence of a country name
    if (preg_match('/\b(\w+\s*)+\b$/', $fullAddress, $matches)) {
        // $matches[0] contains the matched country name
        $countryName = trim($matches[0]);

        // You may need to further process $countryName to remove any extra characters or formatting
        return $countryName;
    }

    // If no country name is found, return a default value or handle it accordingly
    return "Country not found";
}
