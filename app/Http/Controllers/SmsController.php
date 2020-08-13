<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\SingleMessage;
use Illuminate\Support\Facades\Auth;

class SmsController extends Controller
{
    public function index()
    {
        return view('sms.index');
    }

    public function send(Request $request)
    {
        $phoneNumber = $request->phoneNumber;
        // return $phoneNumber;
        $message = $request->message;
        $from = $request->senderId;

        $log = new SingleMessage;
        $log->user_id = auth()->user()->id;
        $log->sender_id = $from;
        $log->message = $message;
        $log->phone_number = $phoneNumber;
        
        if (!auth()->user()->hasRole('admin')) {
            if (auth()->user()->messages_left == 0) {
                $log->error = '1';
                $log->error_message = 'Insufficient Balance - No messages left';
                $log->save();

                return redirect('sms')->with('alert-danger', 'Insufficient Balance - No messages left');
            }
        }

        try {
            $response = $this->sendMessageNemo($phoneNumber, $message, $from);

            if($response['messages'][0]['status'] == 0) {
                $log->success = 1;
                $log->status = $response['messages'][0]['status'];
                $log->message_price = $response['messages'][0]['message-price'];
                $log->network = $response['messages'][0]['network'];
                $log->save();

                return redirect('sms')->with('alert-success', 'Success - Message has been sent successfully.');
            } else {
                $log->error = 1;
                $log->error_message = $response['messages'][0]['status'];
                $log->status = $response['messages'][0]['status'];
                $log->save();

                return redirect('sms')->with('alert-danger', "The message failed with status: " . $response['messages'][0]['status']);
            }

        } catch (\Nexmo\Client\Exception\Request $e) {
            return $e;
            $log->error = 1;
            $log->error_message = $e;
            $log->save();

            return redirect('sms')->with('alert-danger', "The message was not sent. Error: " . $e->getMessage());
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
