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
        $subscriptions = Subscription::latest()->where('user_id', '=', $user->id)->paginate(5);

        return view('subscriptions.index', compact('subscriptions', 'user'));
    }

    public function create()
    {
        return view('subscriptions.create');
    }

    // public function store(StoreSubscriptionRequest $request)
    // {
    //     Subscription::create([
    //         'user_id' =>$request->user_id,
    //         'title' => $request->title,
    //         'price' => $request->price,
    //         'frequency' => $request->frequency,
    //         'first_payment_day' => $request->first_payment_day,
    //         'url' => $request->url,
    //         'memo' => $request->memo,
    //     ]);

    //     return to_route('subscriptions.index')->with('status', 'サブスクを登録しました。');
    // }

    // モーダルFormからの新規保存
    public function addSubscription(StoreSubscriptionRequest $request){
        $user = Auth::user();
        Subscription::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'price' => $request->price,
            'frequency' => $request->frequency,
            'first_payment_day' => $request->first_payment_day,
            'url' => $request->url,
            'memo' => $request->memo,
        ]);
        $new_subscription = Subscription::where('user_id','=',$user->id)->orderByDesc('id')
        ->first();
        $title = $new_subscription->title;

         // フラッシュメッセージをセッションに追加 session()->flash('キー', 'メッセージ')
        // session()->flash('status', 'サブスクリプションが正常に追加されました！');

        // JSONレスポンスを返す
        return response()->json([
            // 'status' => 'success',
            'new_subscription'=>$new_subscription,
            // 'message' => session('status'),       // フラッシュメッセージを返す
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

    public function update(Request $request, $id)
    {
        $subscription = Subscription::find($id);
        $user = auth()->user();

        if($user->can('update',$subscription)){
            $subscription->title = $request->title;
            $subscription->price = $request->price;
            $subscription->frequency = $request->frequency;
            $subscription->first_payment_day = $request->first_payment_day;
            $subscription->url = $request->url;
            $subscription->memo = $request->memo;
            $subscription->save();

            return to_route('subscriptions.show', ['id' => $id])->with('status', 'サブスクを更新しました。');
        }else{
            abort(403);
        }
    }

    // モーダルFormからのデータ更新
    // public function updateModal(StoreSubscriptionRequest $request){
    public function updateModal(Request $request){
        // Subscription::create([
        //     'user_id' => $request->user_id,
        //     'title' => $request->title,
        //     'price' => $request->price,
        //     'frequency' => $request->frequency,
        //     'first_payment_day' => $request->first_payment_day,
        //     'url' => $request->url,
        //     'memo' => $request->memo,
        // ]);
        // return response()->json([
        //     'status'=>'success',
        // ]);

        Subscription::where('id', $request->id)->update([
            'title'=>$request->title,
            'price'=>$request->price
        ]);
        return response()->json([
            'status'=>'success'
        ]);
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
