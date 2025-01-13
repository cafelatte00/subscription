<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            すべてのサブスク
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach($subscriptions as $subscription)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                            {{ $subscription->name }}<br>
                            {{ $subscription->url }}<br>
                    </div>
                </div>
            @endforeach

            <a href="{{ route('subscriptions.create') }}" class="text-blue-500">新規登録</a>
        </div>
    </div>
</x-app-layout>
