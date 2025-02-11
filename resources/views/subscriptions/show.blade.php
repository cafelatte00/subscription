<x-app-layout>
    <div class="py-12">


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- フラッシュメッセージ --}}
            @if (session('status'))
                <div id="flash-message" class="alert alert-info">
                    {{ session('status') }}
                </div>
            @endif
            <div class="border-pink overflow-hidden pink-shadow sm:rounded-lg p-3 lg:p-14">
                {{-- クローズボタン --}}
                <div class="flex justify-end pb-4">
                    <a href="{{ route('subscriptions.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6 hover:text-gray-600">
                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                        </svg>
                    </a>
                </div>

                <div class="flex justify-between">
                    <div class="font-semibold text-3xl text-gray-800 leading-tight">
                        {{ $subscription->title }}
                    </div>
                    <div class="flex">
                        {{-- 編集ボタン --}}
                        <a href="{{ route('subscriptions.edit', ['id' => $subscription->id]) }}">
                            <button type="button" class="rounded-full border border-pink-500 bg-pink-100 p-3 text-center text-base font-medium shadow-sm transition-all hover:border-pink-700 hover:bg-pink-200 focus:ring focus:ring-gray-200 disabled:cursor-not-allowed disabled:border-pink-300 disabled:bg-pink-300">
                                <i class="las la-edit h-6 w-6"></i>
                            </button>
                        </a>
                        {{-- 削除ボタン --}}
                        <form method="post" action="{{ route('subscriptions.delete', ['id' => $subscription->id]) }}" id="delete_{{ $subscription->id }}">
                            @csrf
                            <button type="button" data-id="{{ $subscription->id }}" onclick="deleteSubscription(this)" class="rounded-full border border-pink-500 bg-pink-500 p-3 ml-2 text-center text-base font-medium text-white shadow-sm transition-all hover:border-pink-700 hover:bg-pink-700 focus:ring focus:ring-pink-200 disabled:cursor-not-allowed disabled:border-pink-300 disabled:bg-pink-300">
                                <i class="las la-trash h-6 w-6"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class=" text-gray-900">
                    料金：{{ $subscription->price }}円<br>
                    支払い頻度：{{ $frequency }}に1回<br>
                    初回支払日：{{ \Carbon\Carbon::parse($subscription->first_payment_day)->format('Y/m/d') }}<br>
                    {{-- 次回支払日：{{ is_null($subscription->next_payment_day) ? substr($subscription->first_payment_day, 0, 10) : substr($subscription->next_payment_day, 0, 10) }}<br> --}}
                    次回支払日：{{  \Carbon\Carbon::parse($subscription->next_payment_day)->format('Y/m/d') }}<br>
                    支払回数：{{ $subscription->number_of_payments }}回<br>
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
@include('common.flash_message_fadeout_js')
</x-app-layout>
