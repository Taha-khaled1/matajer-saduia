<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\AdminMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendRememberCartJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $carts;
    public $titleFromAdmin = "";
    public $messageFromAdmin = "";
    public function __construct($data)
    {
        $this->carts = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $this->carts->each(function ($latestExpiredItem) {
            $user = User::find($latestExpiredItem->user_id);

            Notification::send([$user], new AdminMessage($this->titleFromAdmin, $this->messageFromAdmin));
            if ($user->fcm)
            {
                SendFCMNotificationJob::dispatch($user->fcm, $this->titleFromAdmin, $this->messageFromAdmin);
            }
        });
    }
}