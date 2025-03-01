<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\CheckSubscriptionService;
use App\Models\Subscription;
use Carbon\Carbon;

class CheckSubscriptionServiceTest extends TestCase
{

    /**
     * 概要: CheckSubscriptionService::checkFrequency() メソッドが、Subscription オブジェクトの frequency プロパティに基づいて正しい支払い頻度を返すことを確認する。
     * 条件: frequency プロパティが 1 の Subscription モックを作成し、checkFrequency() メソッドを実行する。
     * 結果: メソッドの戻り値が '1ヶ月' であること。
     */
    public function test_支払い頻度を人が読みやすい形式で返す()
    {
        // Subscriptionクラスのモックを作成
        $subscription = $this->createMock(Subscription::class);

        // frequencyプロパティの値を設定
        $subscription->method('__get')
                        ->with('frequency')
                        ->willReturn(1);

        // サービスメソッドを呼び出し
        $result = CheckSubscriptionService::checkFrequency($subscription);

        // 期待する結果をアサート
        $this->assertEquals('1ヶ月', $result);
    }

    /**
     * 概要: CheckSubscriptionService::calculatePaymentDetails() メソッドが、正しい次回支払日と支払い回数の値を返すことを確認す
     * 条件: 初回支払日が本日、支払い頻度が 1(１ヶ月) の引数を用意し、calculatePaymentDetails() メソッドを実行する。
     * 結果: メソッドの戻り値が 次回支払日は初回支払日の１ヶ月後、支払い回数は1であること。
     */
    public function test_正しい次回支払日と支払い回数を返す()
    {
        $firstPaymentDay = Carbon::today();
        $frequency = 1;

        $paymentDetails = CheckSubscriptionService::calculatePaymentDetails($firstPaymentDay, $frequency);

        $this->assertEquals($firstPaymentDay->copy()->addMonthNoOverflow($frequency), $paymentDetails['nextPaymentDay']);

        $this->assertEquals(1, $paymentDetails['numberOfPayments']);
    }

        /**
     * 概要: CheckSubscriptionService::calculatePaymentDetails() メソッドが、正しい次回支払日と支払い回数の値を返すことを確認す
     * 条件: 初回支払日が本日、支払い頻度が 2(2ヶ月) の引数を用意し、calculatePaymentDetails() メソッドを実行する。
     * 結果: メソッドの戻り値が 次回支払日は初回支払日の１ヶ月後、支払い回数は1であること。
     */
    public function test_支払い頻度が2ヶ月の場合、正しい次回支払日と支払い回数を返す()
    {
        $firstPaymentDay = Carbon::today();
        $frequency = 2;

        $paymentDetails = CheckSubscriptionService::calculatePaymentDetails($firstPaymentDay, $frequency);

        $this->assertEquals($firstPaymentDay->copy()->addMonthNoOverflow($frequency), $paymentDetails['nextPaymentDay']);

        $this->assertEquals(1, $paymentDetails['numberOfPayments']);
    }

    /**
     * 概要: CheckSubscriptionService::calculatePaymentDetails() メソッドが、正しい次回支払日と支払い回数の値を返すことを確認す
     * 条件: 初回支払日が未来、支払い頻度が 1(１ヶ月) の引数を用意し、calculatePaymentDetails() メソッドを実行する。
     * 結果: メソッドの戻り値が 次回支払日は初回支払日と同じ、支払い回数は0であること。
     */
    public function test_初回支払日が未来の場合、正しい次回支払日と支払い回数を返す()
    {
        $firstPaymentDay = Carbon::parse('2025-07-01');
        $frequency = 1;

        $paymentDetails = CheckSubscriptionService::calculatePaymentDetails($firstPaymentDay, $frequency);

        $this->assertEquals(Carbon::parse('2025-07-01'), $paymentDetails['nextPaymentDay']);

        $this->assertEquals(0, $paymentDetails['numberOfPayments']);
    }

    /**
     * 概要: CheckSubscriptionService::calculatePaymentDetails() メソッドが、正しい次回支払日と支払い回数の値を返すことを確認す
     * 条件: 初回支払日が過去、支払い頻度が 1(１ヶ月) の引数を用意し、calculatePaymentDetails() メソッドを実行する。
     * 結果: メソッドの戻り値が 次回支払日は2025-04-01と同じ、支払い回数は3であること。
     * 注意：次回支払日の日付はテストするに日によって書き換えること。
     */
    public function test_初回支払日が過去の場合、正しい次回支払日と支払い回数を返す()
    {
        $firstPaymentDay = Carbon::parse('2025-01-01');
        $frequency = 1;

        $paymentDetails = CheckSubscriptionService::calculatePaymentDetails($firstPaymentDay, $frequency);

        $this->assertEquals(Carbon::parse('2025-04-01'), $paymentDetails['nextPaymentDay']);

        $this->assertEquals(3, $paymentDetails['numberOfPayments']);
    }
}
