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

    public function store(Request $request)
    {
        // dd($request, $request->name, $request->first_payment_day);
        Subscription::create([
            'user_id' =>$request->user_id,
            'name' => $request->name,
            'price' => $request->price,
            'frequency' => $request->frequency,
            'first_payment_day' => $request->first_payment_day,
            'url' => $request->url,
            'memo' => $request->memo,
        ]);

        return to_route('subscriptions.index');
    }

    public function show($id)
    {
        $subscription = Subscription::find($id);

        return  view('subscriptions.show', compact('subscription'));
    }

    public function edit($id)
    {
        $subscription = Subscription::find($id);
        return view('subscriptions.edit', compact('subscription'));
    }

    public function update(Request $request, $id)
    {
        $subscription = Subscription::find($id);

        $subscription->name = $request->name;
        $subscription->price = $request->price;
        $subscription->frequency = $request->frequency;
        $subscription->first_payment_day = $request->first_payment_day;
        $subscription->url = $request->url;
        $subscription->memo = $request->memo;
        $subscription->save();

        return to_route('subscriptions.show', ['id' => $id]);
    }

    public function delete(Request $request, $id)
    {
        $subscription = Subscription::find($id);
        $subscription->delete();

        return to_route('subscriptions.index');
    }
}
