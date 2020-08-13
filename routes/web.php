<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Twilio\Rest\Client;
use App\GroupMessage;
use App\IndividualGroupMessage;
use App\Jobs\SendGroupMessage;
use App\SingleMessage;
use App\SmsGroup;
use App\SmsGroupNumbers;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use App\ReceivedSms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $role_admin = Role::firstOrCreate(['name' => 'admin']);
    $role_user = Role::firstOrCreate(['name' => 'user']);

    $permission = Permission::firstOrCreate(['name' => 'view received messages']);
    $permission1 = Permission::firstOrCreate(['name' => 'delete messages']);

    $role_admin->givePermissionTo('delete messages');

    return view('welcome');
});

// Auth::routes(['register' => false]);
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth', 'role:admin|user'])->prefix('sms')->group(function () {
    Route::get('/', 'SmsController@index');
    Route::post('/', 'SmsController@send');

    // Route::get('/group', 'SmsGroupController@index');
    // Route::post('/group', 'SmsGroupController@groupSend');

    Route::prefix('groups')->group(function () {
        Route::prefix('manage')->group(function () {
            Route::get('/', 'SmsGroupNumbersController@index');
            Route::post('/', 'SmsGroupNumbersController@addGroup');

            Route::get('{smsGroup}','SmsGroupNumbersController@manageNumbers');
            Route::post('{smsGroup}','SmsGroupNumbersController@addNumbers');
        });
    });

    Route::prefix('sent')->group(function () {
        Route::get('/', function() {
            if (auth()->user()->hasRole('admin')) {
                $single_messages = SingleMessage::withTrashed()->orderBy('created_at', 'desc')->paginate(25);
            } else {
                $single_messages = SingleMessage::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->paginate(25);
            }
            return view('sms.sent-single', compact('single_messages'));
        });
        Route::get('/delete/{id}', function ($id) {
            $sms = SingleMessage::withTrashed()->where('id', $id)->first();
            if (auth()->user()->hasRole('admin')) {
                $sms->forceDelete();
            } else {
                $sms->delete();
            }
            return redirect()->back();
        });

        Route::get('/group', function() {
            $group_messages = GroupMessage::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->paginate(25);
            
            return view('sms.sent-group', compact('group_messages'));
        });
        Route::get('/group/{id}', function ($id) {
            if (request()->has('filter')) {
                if (request('filter') == 'error') {
                    $individual_messages = IndividualGroupMessage::where('group_message_id', $id)->where('error', '1')->paginate(20);
                    return view('sms.sent-detail', compact('individual_messages'));
                }
            }

            $individual_messages = IndividualGroupMessage::where('group_message_id', $id)->paginate(20);
            return view('sms.sent-detail', compact('individual_messages'));
        });
    });    
});

Route::middleware(['auth', 'role:admin'])->prefix('users')->group(function () {
    Route::get('/', 'UserController@index');
    Route::post('/', 'UserController@create');

    Route::get('add-message/{user}', function (User $user) {
        return view('users.add-message', compact('user'));
    });
    Route::post('add-message/{user}', function (User $user, Request $request) {
        $user->messages_left = $request->messages_left;
        $user->save();

        return redirect('users');
    });
    Route::get('add-role/{user}/{role}', function (User $user, $role) {
        $user->syncRoles($role);

        return redirect()->back();
    });
    Route::get('remove-role/{user}/{role}', function (User $user, $role) {
        $user->removeRole($role);

        return redirect()->back();
    });

    Route::get('disable-user/{user}', function (User $user) {
        $user->active = 0;
        $user->syncRoles();
        $user->save();

        return redirect()->back();
    });
    Route::get('enable-user/{user}', function (User $user) {
        $user->active = 1;
        $user->syncRoles('user');
        $user->save();

        return redirect()->back();
    });

    Route::get('user-permissions/{user}', function (User $user) {
        $permissions = DB::table('permissions')->pluck('name')->toArray();
        return view('users.user-permissions', compact('user', 'permissions'));
    });

    Route::post('user-permissions/{user}/update-permission', function (User $user, Request $request) {
        if ($request->add == '1') {
            $user->givePermissionTo($request->permission);
            return response()->json([
                'status' => 'permission given'
            ]);
        } else {
            $user->revokePermissionTo($request->permission);
            return response()->json([
                'status' => 'permission revoked'
            ]);
        }
    });
});

Route::middleware(['auth', 'role:admin', 'permission:view received messages'])->prefix('received-sms')->group(function () {
    Route::get('/', function () {
        $received = ReceivedSms::paginate(25);

        return view('sms.received-sms', compact('received'));
    });
    Route::get('/delete/{sms}', function (ReceivedSms $sms) {
        $sms->delete();

        return redirect()->back();
    });
});

Route::post('/nexmo/webhook/receive/sms', function(Request $request){
    $sms = new ReceivedSms;
    $sms->from = $request->msisdn;
    $sms->to = $request->to;
    $sms->message = $request->text;
    $sms->type = $request->type;
    $sms->timestamp = $request->get('message-timestamp');
    $sms->save();

    return response()->noContent();
});