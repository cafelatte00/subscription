<x-app-layout>
    @inject('checkSubscriptionService', 'App\Services\CheckSubscriptionService')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            すべてのサブスク
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach($subscriptions as $subscription)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <a href="{{ route('subscriptions.show', ['id' => $subscription->id]) }}">
                        <div class="p-6 text-gray-900">
                            {{ $subscription->title }}<br>
                            料金：{{ $subscription->price }}円<br>
                            支払い頻度：{{ $checkSubscriptionService::checkFrequency($subscription) }}<br>
                            初回支払日：{{ substr($subscription->first_payment_day, 0, 10) }}<br>
                            URL：{{ $subscription->url }}<br>
                            メモ：{{ $subscription->memo }}<br>
                        </div>
                    </a>
                </div>
            @endforeach

            <a href="{{ route('subscriptions.create') }}" class="text-blue-500">新規登録</a>
        </div>
    </div>
</x-app-layout>
