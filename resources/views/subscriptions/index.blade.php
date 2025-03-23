<x-app-layout>
    @inject('checkSubscriptionService', 'App\Services\CheckSubscriptionService')
    {{-- ここからテイルブロック --}}
    <section class="text-gray-600 body-font app-background-image">
        <div class="container py-10 mx-auto lg:px-[10rem]">
            {{-- フラッシュメッセージ --}}
            @if (session('status'))
                <div id="flash-message" class="alert alert-info">
                    {{ session('status') }}
                </div>
            @endif
            <div id="ajax-flash-message"></div>
            <div class="flex flex-wrap w-full md:mb-10 flex-col items-center text-center">
                <h1 class="sm:text-3xl text-2xl font-black mb-2 text-white">すべてのサブクス</h1>
            </div>

            <div class="flex justify-end p-4">
                <button data-bs-toggle="modal" data-bs-target="#addModal" class="button-white"><i class="las la-plus"></i>新規登録</button>
            </div>

            <div id="index-flame" class="">
                @foreach($subscriptions as $subscription)
                    <div class="p-4">
                        <a href="{{ route('subscriptions.show', ['id' => $subscription->id]) }}">
                            <div class="bg-white p-6 rounded-lg">
                                <h2 class="text-2xl sm:text-4xl font-bold text-pink-500 mb-3">{{ $subscription->title }}</h2>

                                <div class="md:flex md:justify-between md:justify-items-start sm:gap-x-5">
                                    <div>
                                        <p class="font-black text-gray-400 ">料金</p>
                                        <p class="leading-relaxed text-2xl sm:text-4xl">
                                            {{ $subscription->price }}円 <span class="text-2xl font-black text-gray-400">/ {{ $checkSubscriptionService::checkFrequency($subscription) }}</span>
                                        </p>
                                    </div>
                                    <div>
                                        @if(is_null($subscription->cancel_day))
                                        <p class="leading-relaxed  text-lg">
                                            <span class="font-black text-gray-400">支払日：</span>
                                            {{ is_null($subscription->next_payment_day) ? substr($subscription->first_payment_day, 0, 10) : substr($subscription->next_payment_day, 0, 10) }}</p>
                                        @else
                                            <p class="leading-relaxed text-lg">
                                                <span class="font-black text-gray-400">支払日：</span>
                                                --/--/--
                                            </p>
                                        @endif
                                        <p class="leading-relaxed text-lg">
                                            <span class="font-black text-gray-400">支払回数：</span>
                                            {{ $subscription->number_of_payments }}回
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
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div>{!! $subscriptions->links() !!}</div>
        </div>
    </section>
    {{-- ここまでテイルブロック --}}
    @include('subscriptions.add_modal')
    @include('subscriptions.add_js')
    @include('common.flash_message_fadeout_js')
</x-app-layout>
