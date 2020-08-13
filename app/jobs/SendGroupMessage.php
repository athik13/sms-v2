<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\GroupMessage;
use App\User;

class SendGroupMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $groupMessage;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(GroupMessage $groupMessage)
    {
        $this->groupMessage = $groupMessage;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $phoneNumbers = $this->groupMessage->phoneNumbers;

        foreach ($phoneNumbers as $number) {
            $response = $this->sendMessageNemo($number->phone_number, $this->groupMessage->message, $this->groupMessage->sender_id);

            if($response['messages'][0]['status'] == 0) {
                $number->success = 1;
                $number->status = $response['messages'][0]['status'];
                $number->message_price = $response['messages'][0]['message-price'];
                $number->network = $response['messages'][0]['network'];
                $number->save();
            } else {
                $number->error = 1;
                $number->error_message = $response['messages'][0]['status'];
                $number->status = $response['messages'][0]['status'];
                $number->save();
            }
        }
    }

    private function sendMessageNemo($phoneNumber, $message, $from){
        $client = app('Nexmo\Client');

        $message = $client->message()->send([
            'to'   => $phoneNumber,
            'from' => $from,
            'text' => $message
        ]);

        $response = $message->getResponseData();
        
        return $response;
    }
}
