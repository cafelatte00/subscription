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
        $guestUserID = 1;
        $user = User::find($guestUserID);
        Auth::login($user);

        return redirect('/subscriptions');
    }
}
