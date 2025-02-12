<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;


class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subscriptions')->insert([
            [
                'user_id' => 1,
                'title' => 'レンティオ',
                'price' => 980,
                'frequency' => 1,
                'first_payment_day' => '2025-02-09',
                'next_payment_day' => '2025-03-09',
                'number_of_payments' => 1,
                'url' => 'https://www.rentio.jp/',
                'memo' => '家電サブスクサービス。ルンバをレンタル中',
                'created_at' => Now(),
                'updated_at' => Now(),
            ],
            [
                'user_id' => 1,
                'title' => 'Miro',
                'price' => 1500,
                'frequency' => 1,
                'first_payment_day' => '2025-02-15',
                'next_payment_day' => '2025-03-15',
                'number_of_payments' => 1,
                'url' => 'https://miro.com/',
                'memo' => 'デザインカンプ作成サービス。1270円',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
