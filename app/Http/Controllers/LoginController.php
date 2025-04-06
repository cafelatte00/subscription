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
        $user = User::where('email', 'guest@example.com')->first();
        Auth::login($user);

        return redirect('/subscriptions');
    }
}
