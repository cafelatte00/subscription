<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            すべてのサブスク
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <a href="{{ route('subscriptions.index') }}">x</a>
                    <div class="p-6 text-gray-900">
                        {{ $subscription->name }}<br>
                        料金：{{ $subscription->price }}円<br>
                        支払い頻度：{{ $subscription->frequency }}<br>
                        初回支払日：{{ $subscription->first_payment_day }}<br>
                        URL：{{ $subscription->url }}<br>
                        メモ：{{ $subscription->memo }}<br>
                    </div>
            </div>
        </div>
    </div>
</x-app-layout>
