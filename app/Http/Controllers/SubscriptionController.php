<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    public function index()
    {
        // 1対多　親→子
        $subscriptions = User::find(1)->subscriptions;

        //       親←子
        $user = Subscription::find(1)->user;

        // dd($subscriptions, $user);

        return view('subscriptions.index', compact('subscriptions', 'user'));
    }

    public function create()
    {
        return view('subscriptions.create');
    }
}
