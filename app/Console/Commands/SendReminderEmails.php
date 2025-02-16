<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Mail\ReminderMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendReminderEmails extends Command
{
    // コマンド名
    protected $signature = 'emails:send-reminders';
    // コマンドの説明
    protected $description = '支払日が近いユーザーにリマインドメールを送る';

    public function handle()
    {
        // 明日から１週間以内にnext_Payment_dayがあるサブスクを持つユーザーを取得
        $users = User::whereHas('subscriptions', function($query){
            $query->whereBetween('next_payment_day', [Carbon::tomorrow(), Carbon::now()->addWeek()]);
        })->get();

        foreach($users as $user){
            // 明日から異週間以内のnext_payment_dayがあるサブスクサブ全てを取得
            $subscriptions = $user->subscriptions()->whereBetween('next_payment_day', [Carbon::tomorrow(), Carbon::now()->addWeek()])->get();

            // ユーザーにメール送信
            Mail::to($user->email)->send(new ReminderMail($user, $subscriptions));
        }
        $this->info('リマインドメールを送信しました。');
    }
}
