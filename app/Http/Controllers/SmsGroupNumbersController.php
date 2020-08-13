<?php

namespace App\Http\Controllers;

use App\SmsGroup;
use App\SmsGroupNumbers;
use Illuminate\Http\Request;

class SmsGroupNumbersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $smsGroups = SmsGroup::where('user_id', auth()->user()->id)->get();
        return view('sms.manage.index', compact('smsGroups'));
    }

    public function addGroup(Request $request)
    {
        $smsGroup = new SmsGroup;
        $smsGroup->user_id = auth()->user()->id;
        $smsGroup->group_name = $request->groupName;
        $smsGroup->save();

        return redirect()->back()->with('alert-success', 'Successfully added a new SMS Group');
    }

    public function manageNumbers(SmsGroup $smsGroup)
    {
        $numbers = SmsGroupNumbers::where('sms_group_id', $smsGroup->id)->paginate(15);
        return view('sms.manage.numbers', compact('smsGroup', 'numbers'));
    }

    public function addNumbers(SmsGroup $smsGroup, Request $request)
    {
        $number = new SmsGroupNumbers;
        $number->sms_group_id = $smsGroup->id;
        $number->name = $request->name;
        $number->phone_number = $request->phoneNumber;
        $number->save();

        return redirect()->back()->with('alert-success', 'Successfully added new Number');
    }
}
