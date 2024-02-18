<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Animated Login From</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

    <link rel="stylesheet" href="login.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            letter-spacing: 1px;
            background-color: #0c1022;
        }

        .login_form_container {
            position: relative;
            width: 400px;
            height: 470px;
            max-width: 400px;
            max-height: 470px;
            background: #040717;
            border-radius: 50px 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-top: 70px;
        }

        .login_form_container::before {

            position: absolute;
            width: 170%;
            height: 170%;
            content: '';
            background-image: conic-gradient(transparent, transparent, transparent, #ee00ff);
            animation: rotate_border 6s linear infinite;

        }

        .login_form_container::after {

            position: absolute;
            width: 170%;
            height: 170%;
            content: '';
            background-image: conic-gradient(transparent, transparent, transparent, #00ccff);
            animation: rotate_border 6s linear infinite;
            animation-delay: -3s;
        }

        @keyframes rotate_border {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .login_form {
            position: absolute;
            content: '';
            background-color: #0c1022;
            border-radius: 50px 5px;
            inset: 5px;
            padding: 50px 40px;
            z-index: 10;
            color: #00ccff;

        }

        h2 {
            font-size: 40px;
            font-weight: 600;
            text-align: center;
        }

        .input_group {
            margin-top: 40px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: start;
        }

        .input_text {
            width: 95%;
            height: 30px;
            background: transparent;
            border: none;
            outline: none;
            border-bottom: 1px solid #00ccff;
            font-size: 20px;
            padding-left: 10px;
            color: #00ccff;

        }

        ::placeholder {
            font-size: 15px;
            color: #00ccff52;
            letter-spacing: 1px;

        }

        .fa {
            font-size: 20px;

        }

        #login_button {
            position: relative;
            width: 300px;
            height: 40px;
            transition: 1s;
            margin-top: 70px;


        }

        #login_button a {
            position: absolute;
            width: 100%;
            height: 100%;
            text-decoration: none;
            z-index: 10;
            cursor: pointer;
            font-size: 22px;
            letter-spacing: 2px;
            border: 1px solid #00ccff;
            border-radius: 50px;
            background-color: #0c1022;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .fotter {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;

        }

        .fotter a {
            text-decoration: none;
            cursor: pointer;
            font-size: 18px;
        }

        .glowIcon {
            text-shadow: 0 0 10px #00ccff;

        }
    </style>
</head>

<body>
    <div class="login_form_container">
        <div class="login_form">
            <h2>تسجيل الدخول</h2>
            <div class="input_group">
                <i class="fa fa-user"></i>
                <input type="text" placeholder=" البريد الاكتروني " class="input_text" autocomplete="off" />
            </div>
            <div class="input_group">
                <i class="fa fa-unlock-alt"></i>
                <input type="password" placeholder=" كلمة السر " class="input_text" autocomplete="off" />
            </div>
            <div class="button_group" id="login_button">
                <a>تسجيل الدخول</a>
            </div>
            <div class="fotter">
                <a> نسيت كلمة السر</a>
                <a>انشاء حساب</a>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="login.js"></script>
</body>


<script>
    $(".input_text").focus(function() {
        $(this).prev('.fa').addclass('glowIcon')
    })
    $(".input_text").focusout(function() {
        $(this).prev('.fa').removeclass('glowIcon')
    })
</script>

</html>




















{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ml-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
