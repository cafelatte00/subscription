<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    // ゲストログイン
    public function guest()
    {
        $guestUserId = 1;
        $user = User::find($guestUserId);
        Auth::login($user);

        return redirect('/subscriptions');
    }
}
