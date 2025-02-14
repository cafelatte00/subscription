<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;
use Carbon\Carbon;

class UpdateSubscription extends Command
{
    /**
     * The name and signature of the console command.
     * コマンド名
     * @var string
     */
    protected $signature = 'subscriptions:update-subscriptions';

    /**
     * The console command description.
     * コマンドの説明
     * @var string
     */
    protected $description = '毎日0:00にnext_payment_dayが本日の日付のsubscriptionを更新し、number_of_paymentsを+1する';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * コンソールコマンドの実行
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today();
        $subscriptions = Subscription::whereDate('next_payment_day', $today)->get();
        foreach($subscriptions as $subscription){
            $subscription->next_payment_day = Carbon::parse($subscription->next_payment_day)->addMonthNoOverflow($subscription->frequency);
            $subscription->increment('number_of_payments');
            $subscription->save();
            $this->info("Subscription ID {$subscription->id}を更新しました。");
        }
        $this->info('処理が終了しました。');
        return Command::SUCCESS;    // 省略可能
    }
}
