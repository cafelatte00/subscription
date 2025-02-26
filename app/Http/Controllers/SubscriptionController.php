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


        // $today = Carbon::today();   // 本日を取得
        // $nextPaymentDay = null;  //次回支払日
        // $numberOfPayme- nts = 0;  // 支払い回数
        $paymentsDetails =CheckSubscriptionService::calculatePaymentDetails($firstPaymentDay, $frequency);
        /*
        * 初回支払日が今日と比べて未来・同じ・過去かで次回支払日と支払い回数を計算
        */
        // if($today == $firstPaymentDay){
        //     $nextPaymentDay = $firstPaymentDay->copy()->addMonthNoOverflow($frequency);
        //     $numberOfPayments = 1;
        // }elseif( $today < $firstPaymentDay){
        //     $nextPaymentDay = $firstPaymentDay;
        // }else{
        //     $numberOfPayments = 1;      // 支払い回数：初回支払日が過去なので初回の支払いを必ず１回している
        //     $calcPaymentDay = $firstPaymentDay->copy()->addMonthNoOverflow($frequency);   // 計算用の課金日(frequency1つ分ずつ進めて計算するため)
        //     $nextPaymentDay =  $calcPaymentDay; // この段階では初回支払日の次の支払日が次回支払日に設定

        //     while($today >= $calcPaymentDay){             // 計算用の支払日より今日が大きい間（未来になるまでの間）
        //         $numberOfPayments++;
        //         $calcPaymentDay = $calcPaymentDay->copy()->addMonthNoOverflow($frequency);
        //         $nextPaymentDay = $calcPaymentDay;
        //     }
        // }

        Subscription::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'price' => $request->price,
            'frequency' => $request->frequency,
            'first_payment_day' => $firstPaymentDay,
            'next_payment_day' => $paymentsDetails['nextPaymentDay'],
            'number_of_payments' => $paymentsDetails['numberOfPayments'],
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

                $today = Carbon::today();
                $subscription->next_payment_day = null;
                $subscription->number_of_payments = 0;

                // 初回支払日が本日・未来・過去かによって代入値をかえる
                if($today == $subscription->first_payment_day){               // 初回支払日が本日
                    $subscription->next_payment_day = $subscription->first_payment_day->copy()->addMonthNoOverflow($subscription->frequency);
                    $subscription->number_of_payments = 1;
                }elseif( $today < $subscription->first_payment_day){                      // 初回支払日が未来
                    $subscription->next_payment_day = $subscription->first_payment_day;
                }else{
                    $subscription->number_of_payments = 1;                                                   // 初回支払日が過去
                    $calcPaymentDay = $subscription->first_payment_day->copy()->addMonthNoOverflow($subscription->frequency); // 計算用の課金日
                    $subscription->next_payment_day = $calcPaymentDay;

                    while($today >= $calcPaymentDay){
                        $subscription->number_of_payments++;
                        $calcPaymentDay = $calcPaymentDay->copy()->addMonthNoOverflow($subscription->frequency);
                        $subscription->next_payment_day = $calcPaymentDay;
                    }
                }
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
