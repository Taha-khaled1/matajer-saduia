<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendFCMNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

   protected $fcmToken;
    protected $title;
    protected $message;

    public function __construct($fcmToken, $title, $message)
    {
        $this->fcmToken = $fcmToken;
        $this->title = $title;
        $this->message = $message;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
   public function handle()
    {
        $SERVER_API_KEY = env('FCM_SERVER_KEY'); // Get this from your Firebase Console

        $data = [
            "registration_ids" => [$this->fcmToken],
            "notification" => [
                "title" => $this->title,
                "body" => $this->message,
                "sound" => "default" // required for sound on ios
            ],
        ];

        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        // Handle errors
        if (curl_errno($ch)) {
            // You may want to log this error, instead of echoing
            echo 'Error:' . curl_error($ch);
        }

        curl_close($ch);
        echo $response;
        // You can decode and process the response further as per your requirement
        // $responseArray = json_decode($response, true); 
    }

}