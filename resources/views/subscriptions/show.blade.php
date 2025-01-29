<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $subscription->title }}
        </h2>
    </x-slot>

    <div class="py-12">

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <a href="{{ route('subscriptions.index') }}"><i class="las la-times"></i></a>
                <a href="{{ route('subscriptions.edit', ['id' => $subscription->id]) }}" class="btn btn-outline-dark"><i class="las la-edit"></i></a>
                <form method="post" action="{{ route('subscriptions.delete', ['id' => $subscription->id]) }}" id="delete_{{ $subscription->id }}">
                    @csrf
                    <a href="#" data-id="{{ $subscription->id }}" onclick="deleteSubscription(this)" class="btn btn-outline-danger"><i class="las la-trash"></i></a>
                </form>
                    <div class="p-6 text-gray-900">
                        料金：{{ $subscription->price }}円<br>
                        支払い頻度：{{ $frequency }}<br>
                        初回支払日：{{ substr($subscription->first_payment_day, 0, 10); }}<br>
                        URL：{{ $subscription->url }}<br>
                        メモ：{{ $subscription->memo }}<br>
                    </div>
            </div>
        </div>
    </div>

{{-- 削除確認メッセージ --}}
<script>
    function deleteSubscription(e){
        'use strict'
        if(confirm('本当に削除してよろしいですか？')){
            document.getElementById('delete_' + e.dataset.id).submit()
        }
    }
</script>

</x-app-layout>
