<?php

namespace App\Services;

use Carbon\Carbon;

/**
 * サブスクリプションに関連するチェックや計算を行うサービスクラス
 */
class CheckSubscriptionService
{

    /**
     * サブスクの頻度を人間が読みやすい形式で取得します。
     *
     * @param Subscription $subscription サブスクリプションのインスタンス
     * @return string 頻度を表す文字列
     */
    public static function checkFrequency($subscription): string
    {
        $frequencies = [
            1 => '1ヶ月',
            2 => '2ヶ月',
            3 => '3ヶ月',
            6 => '6ヶ月',
            12 => '1年',
        ];
        return $frequencies[$subscription->frequency];
    }

    /**
     * 初回支払日と頻度から次回支払日と支払い回数を計算します。
     *
     * @param Carbon $firstPaymentDay 初回支払日
     * @param int $frequency 支払い頻度（月単位）
     * @return array 次回支払日と支払い回数を含む連想配列
     */
    public static function calculatePaymentDetails(Carbon $firstPaymentDay, int $frequency): array
    {
        $today = Carbon::today();   // 本日を取得
        $nextPaymentDay = null;  //次回支払日
        $numberOfPayments = 0;  // 支払い回数

        if($today == $firstPaymentDay){
            $nextPaymentDay = $firstPaymentDay->copy()->addMonthNoOverflow($frequency);
            $numberOfPayments = 1;
        }elseif( $today < $firstPaymentDay){
            $nextPaymentDay = $firstPaymentDay;
        }else{
            $numberOfPayments = 1;      // 支払い回数：初回支払日が過去なので初回の支払いを必ず１回している
            $calcPaymentDay = $firstPaymentDay->copy()->addMonthNoOverflow($frequency);   // 計算用の課金日(frequency1つ分ずつ進めて計算するため)
            $nextPaymentDay =  $calcPaymentDay; // この段階では初回支払日の次の支払日が次回支払日に設定

            while($today >= $calcPaymentDay){             // 計算用の支払日より今日が大きい間（未来になるまでの間）
                $numberOfPayments++;
                $calcPaymentDay = $calcPaymentDay->copy()->addMonthNoOverflow($frequency);
                $nextPaymentDay = $calcPaymentDay;
            }
        }
        return [
            'nextPaymentDay' => $nextPaymentDay,
            'numberOfPayments' => $numberOfPayments,
        ];
    }
}
