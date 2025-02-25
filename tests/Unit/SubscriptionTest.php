<?php

namespace Tests\Unit;

use Tests\TestCase;
// use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Subscription;
use App\Model\User;

class SubscriptionTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }


    /**
     * 概要: Subscriptionモデルのfillable属性に値をセットできるかを確認する
     * 条件: コンストラクタで各属性（user_id, title, priceなど）に値を渡してインスタンスを作成する
     * 結果: 各属性に期待した値が正しく設定されていることをassertEqualsで検証する
     */
    public function test_属性に値を設定できる()
    {
        $subscription = new Subscription([
            'user_id' => 1,
            'title' => 'Netflix',
            'price' => 1500,
            'frequency' => 1,
            'first_payment_day' => '2025-03-01',
            'url' => 'https://www.netflix.com',
            'memo' => '毎月１日に課金される'
        ]);

        $this->assertEquals(1, $subscription->user_id);
        $this->assertEquals('Netflix', $subscription->title);
        $this->assertEquals(1500, $subscription->price);
        $this->assertEquals(1, $subscription->frequency);
        $this->assertEquals('https://www.netflix.com', $subscription->url);
        $this->assertEquals('毎月１日に課金される', $subscription->memo);
    }

        /**
     * 概要: SubscriptionモデルのuserメソッドがBelongsTo型を返すことを確認する
     * 条件: Subscriptionモデルのインスタンスを作成し、user()メソッドを実行する
     * 結果: 戻り値が Illuminate\Database\Eloquent\Relations\BelongsTo クラスのインスタンスであること
     */
    public function test_userメソッドがBelongsToを返す()
    {
        $subscription = new Subscription();
        $this->assertInstanceOf(BelongsTo::class, $subscription->user());
    }
}
