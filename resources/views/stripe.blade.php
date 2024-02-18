<!DOCTYPE html>
<html>

<head>
    <title>الخيمه (khayma)</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <style type="text/css">
        h2 {
            margin: 80px auto;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --text-color: rgb(110, 110, 110);
        }

        h3 {
            color: #000;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: rgb(245, 164, 177);
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 350px;
            background: #fff;
            padding: 30px;
            position: relative;
        }

        button {
            border: none;
            outline: none;
            background: rgb(233, 220, 220);
            color: rgb(31, 30, 30);
            width: 100%;
            height: 40px;
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }

        h6 {
            font-size: 20px;
            color: var(--text-color);
        }

        span {
            position: absolute;
            right: 34px;
            top: 28px;
            font-size: 18px;
            color: var(--text-color);
        }

        h1 {
            padding: 30px 0px;
            font-size: 40px;
            color: var(--text-color);
        }

        form label {
            color: var(--text-color);
            text-transform: uppercase;
            position: relative;
            font-size: 10px;
            word-spacing: 4px;
        }

        form select {
            width: 100%;
            outline: none;
            border: none;
            border-bottom: 1px solid rgb(223, 223, 223);
            text-transform: capitalize;
            padding-top: 3px;
            color: var(--text-color);
            padding-bottom: 3px;
            font-size: 18px;
            margin-left: -3px;
            margin-bottom: 20px;
            background-color: transparent;
        }

        form #cardno {
            width: 100%;
            outline: none;
            border: none;
            border-bottom: 1px solid rgb(223, 223, 223);
            padding-top: 5px;
            margin-bottom: 20px;
            padding-bottom: 5px;
            padding-right: 30px;
            color: var(--text-color);
            font-size: 18px;
            background-color: transparent;
        }

        .float {
            display: flex;
        }

        #validtill,
        #cvv {
            border: none;
            border-bottom: 1px solid rgb(207, 207, 207);
            outline: none;
            width: 130px;
            padding-top: 14px;
            margin-bottom: 56px;
            color: var(--text-color);
            background-color: transparent;
            font-size: 18px;
        }

        p {
            margin-left: 25px;
            margin-bottom: 56px;
            margin-top: -20px;
            font-size: 16px;
            text-transform: none;
        }
    </style>
    <style>
        /* General Header Styling */
        .site-header {
            background-color: white;
            /* Dark Background */
            color: white;
            /* White Text */
            /* padding: 20px; */
            text-align: center;
            display: flex;
            /* Using Flexbox for alignment */
            align-items: center;
            /* Vertically align items in the center */
            justify-content: center;
            /* Horizontally align items in the center */
        }

        /* Logo Styling */
        .logo-container {
            margin-right: 20px;
            /* Space between logo and title */
        }

        .site-logo {
            width: 100px;
            /* Set width */
            border-radius: 50%;
            /* Circular shape */
        }

        /* Site Title Styling */
        .site-title {
            margin: 0;
            /* Removes default margin */
        }

        .english-title,
        .arabic-title {
            margin: 0;
            /* Removes default margin */
            font-family: 'YourPowerfulFont', sans-serif;
            /* Replace 'YourPowerfulFont' with actual font-family */
            font-size: 36px;
            /* Adjust size as needed */
        }

        .arabic-title {
            font-family: 'YourArabicFont', sans-serif;
            /* Replace 'YourArabicFont' with actual Arabic font-family */
            direction: rtl;
            /* Right-to-left direction for Arabic text */
        }

        /* Responsive Design - Adjusts for smaller screens */
        @media (max-width: 768px) {
            .site-header {
                flex-direction: column;
                /* Stack logo and title vertically on small screens */
            }

            .logo-container {
                margin-right: 0;
                margin-bottom: 10px;
                /* Space between logo and title on small screens */
            }
        }
    </style>

</head>

<body>
    <div class="container">
        {{-- <h6>Khayma - خيمة</h6> --}}

        <header class="site-header">
            <div class="logo-container">
                <img src="{{ asset('assets/img/Logo.png') }}" alt="Khayma Logo" class="site-logo" />
            </div>
            {{-- <div class="site-title"> --}}
            {{-- <h1>Checkout</h1> --}}
            {{-- <h3 class="english-title">Khayma</h3>
                <h3 class="arabic-title">خيمة</h3> --}}
            {{-- </div> --}}
        </header>
        {{-- <h2 class="text-center">الخيمه (khayma)</h2> --}}

        {{-- <div class="row">
            <div class="col-md-7 col-md-offset-3">
                <div class="panel panel-default credit-card-box">
                    <div class="panel-heading display-table">
                        <h3 class="panel-title text-center"><strong>تفاصيل الدفع</strong></h3>
                    </div>
                    <div class="panel-body"> --}}

        @if (Session::has('success'))
            <div class="alert alert-success text-center">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                <p>{{ Session::get('success') }}</p>
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger text-center">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                <p>{{ Session::get('error') }}</p>
            </div>
        @endif

        <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation"
            data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_PUBLISHABLE_KEY') }}" id="payment-form">
            @csrf

            <div class='form-row row'>
                <div class='col-xs-12 form-group required'>
                    <label class='control-label'>Name on Card</label>
                    <input class='form-control' size='4' type='text'>
                </div>
            </div>

            <div class='form-row row'>
                <div class='col-xs-12 form-group card required'>
                    <label class='control-label'>Card Number</label>
                    <input autocomplete='off' class='form-control card-number' size='20' type='text'>
                </div>
            </div>

            <div class='form-row row'>
                <div class='col-xs-12 col-md-4 form-group cvc required'>
                    <label class='control-label'>CVC</label>
                    <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4'
                        type='text'>
                </div>
                <div class='col-xs-12 col-md-4 form-group expiration required'>
                    <label class='control-label'>EXP Month</label> <input class='form-control card-expiry-month'
                        placeholder='MM' size='2' type='text'>
                </div>
                <div class='col-xs-12 col-md-4 form-group expiration required'>
                    <label class='control-label'>EXP Year</label>
                    <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
                </div>
            </div>
            <input type="hidden" name="order_id" value="{{ $order->id }}" hidden>
            <input type="hidden" name="total" value="{{ $order->total }}" hidden>
            <div class='form-row row'>
                <div class='col-md-12 error form-group hide'>
                    <div class='alert-danger alert'>Please correct the errors and try again.</div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <button type="submit">Pay Now
                        ({{ $order->total }} AED) </button>
                </div>
            </div>

        </form>



        {{--                         
                    </div>
                </div>
            </div>
        </div> --}}

    </div>

</body>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">
    $(function() {

        /*------------------------------------------
        --------------------------------------------
        Stripe Payment Code
        --------------------------------------------
        --------------------------------------------*/

        var $form = $(".require-validation");

        $('form.require-validation').bind('submit', function(e) {
            var $form = $(".require-validation"),
                inputSelector = ['input[type=email]', 'input[type=password]',
                    'input[type=text]', 'input[type=file]',
                    'textarea'
                ].join(', '),
                $inputs = $form.find('.required').find(inputSelector),
                $errorMessage = $form.find('div.error'),
                valid = true;
            $errorMessage.addClass('hide');

            $('.has-error').removeClass('has-error');
            $inputs.each(function(i, el) {
                var $input = $(el);
                if ($input.val() === '') {
                    $input.parent().addClass('has-error');
                    $errorMessage.removeClass('hide');
                    e.preventDefault();
                }
            });

            if (!$form.data('cc-on-file')) {
                e.preventDefault();
                Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                Stripe.createToken({
                    number: $('.card-number').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                }, stripeResponseHandler);
            }

        });

        /*------------------------------------------
        --------------------------------------------
        Stripe Response Handler
        --------------------------------------------
        --------------------------------------------*/
        function stripeResponseHandler(status, response) {
            if (response.error) {
                $('.error')
                    .removeClass('hide')
                    .find('.alert')
                    .text(response.error.message);
            } else {
                /* token contains id, last4, and card type */
                var token = response['id'];

                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }

    });
</script>

</html>
