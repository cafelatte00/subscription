<?php

namespace App\Services;

use Carbon\Carbon;

class CheckSubscriptionService
{
    public static function checkFrequency($subscription)
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

    public static function calculatePaymentDetails(Carbon $firstPaymentDay, int $frequency)
    {
        $today = Carbon::today();   // 本日を取得
        $nextPaymentDay = null;  //次回支払日
        $numberOfPayments = 0;  // 支払い回数

                /*
        * 初回支払日が今日と比べて未来・同じ・過去かで次回支払日と支払い回数を計算
        */
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
