<?php


namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use App\Models\PaymentGateway;
use Illuminate\Http\Request;

class PaymentGatewayController extends Controller
{
     function __construct()
    {
         $this->middleware('permission:بوبات الدفع', ['only' => ['index','store','show','edit','update','destroy']]);
        //  $this->middleware('permission:role-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
       $paymentgateway= PaymentGateway::first();
        return view('dashboard.setting.Payment-gateway',compact('paymentgateway'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentGateway  $paymentGateway
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentGateway $paymentGateway)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentGateway  $paymentGateway
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentGateway $paymentGateway)
    {
        //
    }

public function update(Request $request)
{
    // Validation rules
    $rules = [
        'PAYPAL_SANDBOX_API_USERNAME' => 'required|string|max:255',
        'PAYPAL_SANDBOX_API_PASSWORD' => 'required|string|min:8|max:255',
        'PAYPAL_SANDBOX_API_SECRET' => 'required|string|min:8|max:255',
        'PAYPAL_SANDBOX_API_CERTIFICATE' => 'required|string|max:255',
        'PAYPAL_CURRENCY' => 'required|string|max:10',
        'PAYPAL_SECURT_KEY' => 'nullable|string|min:8|max:255',
        'PAYPAL_PUBLIC_KEY' => 'nullable|string|max:255',
        'PAYPAL_MODE' => 'required|in:sandbox,production', // Valid values are 'sandbox' or 'production'
        'CLAIENT_ID' => 'required|string|max:255',
        'STRIPE_PUBLISHABLE_KEY' => 'required|string|max:255',
        'STRIPE_SECRET_KEY' => 'required|string|max:255',
    ];

    // Validate the request data
    $validatedData = $request->validate($rules);

    // Update the payment gateway settings
    $paymentgateway = PaymentGateway::first();
    PaymentGateway::updateOrCreate(['id' => $paymentgateway->id], $validatedData);
    $this->setEnvironmentValue('PAYPAL_SANDBOX_API_USERNAME', $request->PAYPAL_SANDBOX_API_USERNAME);
    $this->setEnvironmentValue('PAYPAL_SANDBOX_API_PASSWORD', $request->PAYPAL_SANDBOX_API_PASSWORD);
    $this->setEnvironmentValue('PAYPAL_SANDBOX_API_SECRET', $request->PAYPAL_SANDBOX_API_SECRET);
    $this->setEnvironmentValue('PAYPAL_SANDBOX_API_CERTIFICATE', $request->PAYPAL_SANDBOX_API_CERTIFICATE);
    $this->setEnvironmentValue('PAYPAL_CURRENCY', $request->PAYPAL_CURRENCY);


    $this->setEnvironmentValue('PAYPAL_MODE', $request->PAYPAL_MODE);
    $this->setEnvironmentValue('CLAIENT_ID', $request->CLAIENT_ID);
        $this->setEnvironmentValue('STRIPE_PUBLISHABLE_KEY', $request->STRIPE_PUBLISHABLE_KEY);
    $this->setEnvironmentValue('STRIPE_SECRET_KEY', $request->STRIPE_SECRET_KEY);


    session()->flash('edit', 'تم تعديل الاعدادت بنجاح');
    return back();
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentGateway  $paymentGateway
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentGateway $paymentGateway)
    {
        //
    }


    public function setEnvironmentValue($envKey, $envValue)
{
    $envFile = app()->environmentFilePath();
    $str = file_get_contents($envFile);

    $oldValue = env($envKey);
    
    if ($oldValue === false) {
        // Key does not exist in the .env file, so we append it
        $str .= "\n{$envKey}={$envValue}\n";
    } else {
        // Key exists, so we replace it
        $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}", $str);
    }

    $fp = fopen($envFile, 'w');
    fwrite($fp, $str);
    fclose($fp);
}

}





            //    $setting = Setting::all();
            //     // Get the Stripe keys from the database
            //     $public_key = $setting->where('key', 'public_key')->first()->value;
            //     $secret_key = $setting->where('key', 'Secrt_key')->first()->value;
         
            //     putenv("STRIPE_PUBLISHABLE_KEY=$public_key");
            //     putenv("STRIPE_SECRET_KEY=$secret_key");

            //     // Read the contents of the .env file
            //     $envFile = base_path('.env');
            //     $envContents = File::get($envFile);

            //     // Replace the corresponding lines
            //     $envContents = preg_replace('/^STRIPE_PUBLISHABLE_KEY=.*$/m', "STRIPE_PUBLISHABLE_KEY=$public_key", $envContents);
            //     $envContents = preg_replace('/^STRIPE_SECRET_KEY=.*$/m', "STRIPE_SECRET_KEY=$secret_key", $envContents);