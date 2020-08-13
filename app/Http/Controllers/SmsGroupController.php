<?php

namespace App\Http\Controllers;

use App\SmsGroup;
use App\SmsGroupNumbers;
use Illuminate\Http\Request;
use App\GroupMessage;
use App\IndividualGroupMessage;
use App\Jobs\SendGroupMessage;

class SmsGroupController extends Controller
{
    public function index()
    {
        $groups = SmsGroup::where('user_id', auth()->user()->id)->get();
        return view('sms.group', compact('groups'));
    }

    public function groupSend(Request $request)
    {
        $from = $request->senderId;
        $message = $request->message;

        $groupMessage = new GroupMessage;
        $groupMessage->user_id = auth()->user()->id;
        $groupMessage->sender_id = $from;
        $groupMessage->message = $message;
        $groupMessage->save();

        // Dealing with phone numbers
        $phoneNumbers = array();
        if ($request->has('groupId')) {
            if ($request->groupId !== '0') {
                $group = SmsGroup::find($request->groupId);
                $numbers = $group->numbers->pluck('phone_number')->toArray();
            }
        }
        if ($request->has('phoneNumbers')) {
            $phoneNumbers = explode(',', $request->phoneNumbers);
        }
        $results = array_filter($phoneNumbers, function($value) { return !is_null($value) && $value !== ''; });
        if ($request->has('groupId')) {
            if ($request->groupId !== '0') {
                $result = array_merge($results, $numbers);
            }
        }
        $result = $results;
        $count = count($result);

        if (!auth()->user()->hasRole('admin')) {
            if ($count > auth()->user()->messages_left) {
                $groupMessage->state = 'Insufficient Balance - No messages left';
                $groupMessage->save();
                return redirect('/sms/group')->with('alert-danger', 'Insufficient Balance - No messages left');
            }
        }

        foreach ($result as $number) {
            $sms = new IndividualGroupMessage;
            $sms->phone_number = $number;
            $sms->group_message_id = $groupMessage->id;
            $sms->save();
        }

        // SendGroupMessage::dispatch($groupMessage);

        return redirect('/sms/group')->with('alert-success', 'Success - Message has been added to queue.');
    }
}
