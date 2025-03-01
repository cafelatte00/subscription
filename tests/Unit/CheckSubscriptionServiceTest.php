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
}
