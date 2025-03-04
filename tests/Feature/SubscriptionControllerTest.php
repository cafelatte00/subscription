<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SubscriptionControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        // PHPUnitで各テストメソッドが実行される前に毎回呼び出される初期化メソッド。これにより、各テストが独立して実行され、他のテストの影響を受けないよう環境を整える
        // 親クラスで定義されている初期化処理を確実に実行
        parent::setUp();
        // テストユーザーの作成
        $this->user = User::factory()->create();
        // 認証ユーザーとする
        $this->actingAs($this->user);
    }

    /**
     * 概要: indexメソッドが正しくビューを返し、ユーザーのサブスクを表示することを確認する
     * 条件: 認証されたユーザーが存在し、サブスクがデータベースに存在する
     * 結果: ステータスコード200が返され、ビューにサブスクが表示される
     */
    public function test_subscriptions_indexでビューサブスクが表示される()
    {
        // テスト用のサブスクを作成
        $subscription = Subscription::factory()->create();

        // indexメソッドにGETリクエストを送信
        $response = $this->get(route('subscriptions.index'));

        // ステータスコード200を確認
        $response->assertStatus(200);

        // ビューにサブスクのタイトルが表示されていることを確認
        $response->assertSee($subscription->title);
    }

    /**
     * 概要: addSubscriptionメソッドが新しいサブスクを作成し、JSONレスポンスを返すことを確認する
     * 条件: 有効なサブスクデータをPOSTリクエストとして送信する
     * 結果: ステータスコード201が返され、データベースに新しいサブスクが存在する
     */
    public function test_addSubscriptionメソッドが新しいサブスクを新規作成し、JSONレスポンスを返すことを確認する()
    {
        // サブスクデータ
        $data = [
            'user_id' => $this->user->id,
            'title' => 'Test Subscription',
            'price' => 1,
            'frequency' => 1,
            'first_payment_day' => '2025-03-01',
            'url' => 'http://test.com',
            'memo' => 'Test memo',
        ];

        // addSubscriptionメソッドにPOSTリクエストを送信
        $response = $this->postJson(route('subscriptions.add.subscription'), $data);

        // ステータスコード201を確認
        $response->assertStatus(200);

        // データベースに新しいサブスクが存在することを確認
        $this->assertDatabaseHas('subscriptions', ['title' => 'Test Subscription']);
    }

    /**
     * 概要: showメソッドが特定のサブスクの詳細を表示することを確認する
     * 条件: 存在するサブスクのIDを指定してGETリクエストを送信する
     * 結果: ステータスコード200が返され、ビューにサブスクの詳細が表示される
     */
    public function test_showメソッドがサブスクの詳細を表示する(){
        // テスト用サブスクを作成
        $subscription =Subscription::factory()->create(['user_id' => $this->user->id]);

        // showメソッドにGETリクエストを送信
        $response = $this->get(route('subscriptions.show', $subscription->id));
        // ステータスコード200を確認
        $response ->assertStatus(200);
        // タイトルを確認
        $response->assertSee($subscription->title);
    }

    /**
     * 概要: editメソッドがサブスクの編集画面を表示することを確認する
     * 条件: 存在するサブスクのIDを指定してGETリクエストを送信する
     * 結果: ステータスコード200が返され、ビューにサブスクの編集フォームが表示される
     */
    public function test_editメソッドがサブスクの編集画面を表示する()
    {
        // テスト用のサブスクを作成
        $subscription = Subscription::factory()->create(['user_id' => $this->user->id]);

        // editメソッドにGETリクエストを送信
        $response = $this->get(route('subscriptions.edit', $subscription->id));

        // ステータスコード200を確認
        $response->assertStatus(200);

        // ビューにサブスクのタイトルが表示されていることを確認
        $response->assertSee($subscription->title);
    }

    /**
     * 概要: updateメソッドがサブスクの情報を更新することを確認する
     * 条件: 存在するサブスクのIDと新しいデータを指定してPUTリクエストを送信する
     * 結果: データベースのサブスク情報が更新される
     */
    public function test_updateメソッドがサブスクの情報を更新する()
    {
        // テスト用のサブスクを作成
        $subscription = Subscription::factory()->create();
        // dd($subscription->user_id, $this->user->id);
        // dd($subscription->id);
        // 更新データ
        $updateData = [
            'title' => 'Updated Subscription',
            'price' => 900,
            'frequency' => 1,
            'first_payment_day' => '2025-04-01',
            'url' => 'http://updated.com',
            'memo' => 'Updated memo',
        ];

        // updateメソッドにPOSTリクエストを送信
        $response = $this->post(route('subscriptions.update', $subscription->id), $updateData);

        // データベースのサブスク情報が更新されていることを確認
        $this->assertDatabaseHas('subscriptions', [
            'id' => $subscription->id,
            'title' => 'Updated Subscription',
        ]);
    }

    /**
     * 概要: deleteメソッドがサブスクを削除することを確認する
     * 条件: 存在するサブスクのIDを指定してDELETEリクエストを送信する
     * 結果: データベースからサブスクが削除される
     */
    public function test_deleteメを削除する()
    {
        $this->withoutExceptionHandling();

        // テスト用のサブスクを作成
        $subscription = Subscription::factory()->create(['user_id' => $this->user->id]);

        // deleteメソッドにDELETEリクエストを送信
        $response = $this->post(route('subscriptions.delete', $subscription->id));

        // データベースからサブスクが削除されていることを確認
        $this->assertDatabaseMissing('subscriptions', [
            'id' => $subscription->id,
        ]);
    }
}
