<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\PaymentGateway;
use Illuminate\Database\Seeder;

class PaymentGetwayTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentGateway::create([
            'PAYPAL_SANDBOX_API_USERNAME' => 'sb-zwjus26893223_api1.business.example.com',
            'PAYPAL_SANDBOX_API_PASSWORD' => 'ZJYK3DLJACDGW7PK',
            'PAYPAL_SANDBOX_API_SECRET' => 'AVE9cPphSnpfmxmkIck6AsyDJubuAk536n1QrXbNyo3xSu2hme9afJun',
            'PAYPAL_SANDBOX_API_CERTIFICATE' => 'test',
            'PAYPAL_CURRENCY' => 'USD',
            'PAYPAL_SECURT_KEY' => 'test', 
            'PAYPAL_PUBLIC_KEY' => 'test',
            "PAYPAL_MODE" => 'sandbox',
            'CLAIENT_ID' => 'test',
            'STRIPE_PUBLISHABLE_KEY' => 'pk_test_51MU9CFCCrii3tAGhhhWlPda7dhODreaYeE8HtdP4gvjoIalVprrKcl7QHnEfLFzvlHC7jrlOpYMR8ncwLjDeOh5V00PcfEjAX9',
            'STRIPE_SECRET_KEY' => 'sk_test_51MU9CFCCrii3tAGhjMS2lA168mdfX5xkvJpdM5aBOWVDyaczVSCyPDI4UNilOo6QkK8gDr8NaLiwxLKjY5Bv2HqT006FQ6Vg7g',
        ]);





    }
}