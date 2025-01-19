<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscription;
use App\Services\CheckSubscriptionService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreSubscriptionRequest;

class SubscriptionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $subscriptions = $user->subscriptions;

        return view('subscriptions.index', compact('subscriptions', 'user'));
    }

    public function create()
    {
        return view('subscriptions.create');
    }

    public function store(StoreSubscriptionRequest $request)
    {
        Subscription::create([
            'user_id' =>$request->user_id,
            'title' => $request->title,
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
        $frequency = CheckSubscriptionService::checkFrequency($subscription);

        return  view('subscriptions.show', compact('subscription', 'frequency'));
    }

    public function edit($id)
    {
        $subscription = Subscription::find($id);
        return view('subscriptions.edit', compact('subscription'));
    }

    public function update(Request $request, $id)
    {
        $subscription = Subscription::find($id);

        $subscription->title = $request->title;
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
