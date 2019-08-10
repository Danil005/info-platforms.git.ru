<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use VK\Client\VKApiClient;
use VK\OAuth\Scopes\VKOAuthGroupScope;
use VK\OAuth\VKOAuth;
use VK\OAuth\VKOAuthDisplay;
use VK\OAuth\VKOAuthResponseType;

class LoginController extends Controller
{


    public function callback(Request $request)
    {
        $vk = new VKApiClient();
        $response = $vk->users()->get(self::API_TOKEN, [
            'user_ids' => [$request->user_id],
        ]);

        $check = DB::table('users')->where('user_id', $request->user_id)->exists();

        $access_id = md5(rand(0, 10000) . $request->user_id);

        if( !$check ) {
            DB::table('users')->insert([
                'user_id' => $request->user_id,
                'first_name' => $response[0]['first_name'],
                'last_name' => $response[0]['last_name'],
                'access_id' => $access_id
            ]);
        }


        $this->send($request->user_id, 'Добро пожаловать!', [
            'keyboard' => json_encode($this->mainMenuKeyboard)
        ]);
    }

    public function login(Request $request)
    {
        return view('login');
    }
}
