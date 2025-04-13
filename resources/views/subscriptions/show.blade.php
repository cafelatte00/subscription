<x-app-layout>
    @inject('checkSubscriptionService', 'App\Services\CheckSubscriptionService')
    <section class="text-gray-600 body-font  app-background-image">
        {{-- <div class="container md:px-16 py-12 mx-auto"> --}}
        <div class="container pt-14 md:pt-20 pb-10 mx-auto lg:px-[10rem]">

            {{-- フラッシュメッセージ --}}
            @if (session('status'))
                <div id="flash-message" class="alert alert-info">
                    {{ session('status') }}
                </div>
            @endif
            <div class="bg-white p-4 border-pink overflow-hidden pink-shadow sm:rounded-lg lg:p-14">
                {{-- クローズボタン --}}
                <div class="flex justify-end pb-12 ">
                    <a href="{{ route('subscriptions.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6 hover:text-gray-600">
                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                        </svg>
                    </a>
                </div>

                <div class="flex justify-between">
                    <h2 class="title-font sm:text-4xl text-xl font-bold text-pink-500 mb-3">
                    {{ $subscription->title }}
                    </h2>
                    <div class="flex">
                        {{-- 編集ボタン --}}
                        @if(is_null($subscription->cancel_day))
                            <a href="{{ route('subscriptions.edit', ['id' => $subscription->id]) }}">
                                <button type="button" class="rounded-full border border-pink-500 bg-pink-100 p-3 text-center text-base font-medium shadow-sm transition-all hover:border-pink-700 hover:bg-pink-200 focus:ring focus:ring-gray-200 disabled:cursor-not-allowed disabled:border-pink-300 disabled:bg-pink-300">
                                    <i class="las la-edit h-6 w-6"></i>
                                </button>
                            </a>
                        @endif
                        {{-- 削除ボタン --}}
                        <form method="post" action="{{ route('subscriptions.delete', ['id' => $subscription->id]) }}" id="delete_{{ $subscription->id }}">
                            @csrf
                            <button type="button" data-id="{{ $subscription->id }}" onclick="deleteSubscription(this)" class="rounded-full border border-pink-500 bg-pink-500 p-3 ml-2 text-center text-base font-medium text-white shadow-sm transition-all hover:border-pink-600 hover:bg-pink-600 focus:ring focus:ring-pink-200 disabled:cursor-not-allowed disabled:border-pink-300 disabled:bg-pink-300">
                                <i class="las la-trash h-6 w-6"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class=" text-gray-900 leading-relaxed text-base">
                    <p class="font-black text-gray-400 ">料金</p>
                    <p class="leading-relaxed text-2xl sm:text-4xl mb-4">
                        {{ $subscription->price }}円 <span class="text-2xl font-black text-gray-400">/ {{ $checkSubscriptionService::checkFrequency($subscription) }}</span>
                    </p>

                    {{-- <div class="md:flex md:justify-items-start sm:gap-x-20"> --}}
                    <div class="md:flex md:justify-between  sm:gap-x-5">

                        <div>
                            <p class="leading-relaxed text-lg">
                                <span class="font-black text-gray-400">支払い頻度：</span>
                                {{ $frequency }}に1回
                            </p>
                            <p class="leading-relaxed text-lg">
                                <span class="font-black text-gray-400">支払回数：</span>
                                {{ $subscription->number_of_payments }}回
                            </p>
                        </div>
                        <div>
                            <p class="leading-relaxed text-lg">
                                <span class="font-black text-gray-400">初回支払日：</span>
                                {{ \Carbon\Carbon::parse($subscription->first_payment_day)->format('Y/m/d') }}
                            </p>
                            <p class="leading-relaxed text-lg">
                                <span class="font-black text-gray-400">次回支払日：</span>{{ is_null($subscription->cancel_day) ? \Carbon\Carbon::parse($subscription->next_payment_day)->format('Y/m/d') : "--/ --/--" }}
                            </p>
                        </div>
                        <div>
                            <p class="leading-relaxed text-lg">
                                <span class="font-black text-gray-400">ステータス：</span>
                                @if (is_null($subscription->cancel_day))
                                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-pink-500 text-white">
                                        契約中
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-teal-500 text-white">
                                        解約済
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <p class="leading-relaxed text-lg mt-3">
                        <span class="font-black text-gray-400">URL：</span>
                        <a href="{{ $subscription->url }}" class="text-blue-600 underline" target="_blank" rel="noopener noreferrer">
                            {{ $subscription->url }}
                        </a>
                    </p>
                    <p class="leading-relaxed text-lg">
                        <span class="font-black text-gray-400">メモ：</span>
                        {{ $subscription->memo }}
                    </p>
                </div>
            </div>
        </div>
    </section>

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
