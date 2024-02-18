<?php

namespace App\Console\Commands;

use App\Jobs\SendRememberCartJob;
use App\Models\CartItem;
use Illuminate\Console\Command;

class RememberCart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:RememberCart';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

  
    public function handle()
    {
$usersWithLatestExpiredItems = CartItem::where('created_at', '<', now()->subDays(30))
    ->orderBy('user_id')
    ->latest()
    ->get()
    ->groupBy('user_id')
    ->map(function ($cartItems) {
        return $cartItems->first(); // Get the latest expired item for each user
    });
      dispatch(new SendRememberCartJob($usersWithLatestExpiredItems));
    }
}