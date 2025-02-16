@php
    use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>サブスク支払日のリマインド</title>
    </head>
    <body>
        <p>{{ $user->name}}さん、こんにちは！</p>

        <p>以下のサブスクリプションの支払日が近づいています！</p>
        <br>
        @foreach ( $subscriptions as $subscription )
            <p><strong>サブスク名：{{ $subscription->title }}</strong></p>
            <p><strong>次回支払日：{{ Carbon::parse($subscription->next_payment_day)->format('Y/m/d') }}</strong></p>
            <br>
        @endforeach
        <p>詳細を確認するには、アプリにログインしてください。</p>
        <p>SubsCut 事務局</p>
    </body>
</html>
