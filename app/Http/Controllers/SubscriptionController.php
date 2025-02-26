<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscription;
use App\Services\CheckSubscriptionService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreSubscriptionRequest;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $subscriptions = Subscription::latest()->where('user_id', '=', $user->id)->paginate(5);

        return view('subscriptions.index', compact('subscriptions', 'user'));
    }

    // モーダルFormからの新規保存 (Ajax)
    public function addSubscription(StoreSubscriptionRequest $request){
        $user = Auth::user();
        $firstPaymentDay = Carbon::parse($request->first_payment_day); // 初回支払日
        $frequency = $request->frequency;

        $paymentDetails =CheckSubscriptionService::calculatePaymentDetails($firstPaymentDay, $frequency);

        Subscription::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'price' => $request->price,
            'frequency' => $request->frequency,
            'first_payment_day' => $firstPaymentDay,
            'next_payment_day' => $paymentDetails['nextPaymentDay'],
            'number_of_payments' => $paymentDetails['numberOfPayments'],
            'url' => $request->url,
            'memo' => $request->memo,
        ]);
        $new_subscription = Subscription::where('user_id','=',$user->id)->orderByDesc('id')
        ->first();
        $title = $new_subscription->title;

        // JSONレスポンスを返す
        return response()->json([
            'new_subscription'=>$new_subscription,   // フラッシュメッセージを返す
        ]);
    }

    public function show($id)
    {
        $subscription = Subscription::find($id);
        $user = auth()->user(); //アクセスしているユーザ情報を取得

        if($user->can('view',$subscription)){
            $frequency = CheckSubscriptionService::checkFrequency($subscription);
            return view('subscriptions.show',compact('subscription', 'frequency'));
        }else{
            return '閲覧権限がありません。';
        }
    }

    public function edit($id)
    {
        $subscription = Subscription::find($id);
        $user = auth()->user();

        if($user->can('update',$subscription)){
            return view('subscriptions.edit', compact('subscription'));
        }else{
            return '閲覧権限がありません。';
        }
    }

    public function update(StoreSubscriptionRequest $request, $id)
    {
        $user = auth()->user();
        $subscription = Subscription::find($id);
        $originalSubscription = clone $subscription; // 変更前のサブスク情報
        $originalSubscription->first_payment_day = Carbon::parse($originalSubscription->first_payment_day);

        if($user->can('update',$subscription)){

            $subscription->title = $request->title;
            $subscription->price = $request->price;
            $subscription->frequency = $request->frequency;
            $subscription->first_payment_day = Carbon::parse($request->first_payment_day);
            $subscription->url = $request->url;
            $subscription->memo = $request->memo;

            // 初回支払日と支払い頻度に変更があれば、初回支払日・次回支払日・支払い回数を確認する
            if($originalSubscription->first_payment_day->ne($subscription->first_payment_day) || $originalSubscription->frequency !== (int)$subscription->frequency){

                // ここにサービスおく
                $paymentDetails =CheckSubscriptionService::calculatePaymentDetails($subscription->first_payment_day, $subscription->frequency);
                $subscription->next_payment_day = $paymentDetails['nextPaymentDay'];
                $subscription->number_of_payments = $paymentDetails['numberOfPayments'];
            }

            $subscription->save();

            return to_route('subscriptions.show', ['id' => $id])->with('status', 'サブスクを更新しました。');
        }else{
            abort(403);
        }
    }

    public function delete(Request $request, $id)
    {
        $subscription = Subscription::find($id);
        $user = auth()->user(); //アクセスしているユーザ情報を取得

        if($user->can('delete',$subscription)){
            $subscription->delete();
            return to_route('subscriptions.index')->with('status', 'サブスクを1件削除しました。');
        }else{
            abort(403);
        }
    }
}
