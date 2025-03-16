<x-app-layout>
    @inject('checkSubscriptionService', 'App\Services\CheckSubscriptionService')
    {{-- ここからテイルブロック --}}
    <section class="text-gray-600 body-font app-background-image">
        <div class="container md:px-5 py-10 mx-auto">
            {{-- フラッシュメッセージ --}}
            @if (session('status'))
                <div id="flash-message" class="alert alert-info">
                    {{ session('status') }}
                </div>
            @endif
            <div id="ajax-flash-message"></div>
            <div class="flex flex-wrap w-full md:mb-20 flex-col items-center text-center">
                <h1 class="sm:text-3xl text-2xl font-black title-font mb-2 text-white">すべてのサブクス</h1>
            </div>

            <div class="flex justify-end p-4">
                <button data-bs-toggle="modal" data-bs-target="#addModal" class="text-white bg-pink-500 border-0 py-2 px-8 focus:outline-none hover:bg-pink-600 rounded text-lg"><i class="las la-plus"></i>新規登録</button>
            </div>

            <div id="index-flame" class="">
                @foreach($subscriptions as $subscription)
                    <div class="p-4">
                        <a href="{{ route('subscriptions.show', ['id' => $subscription->id]) }}">
                            <div class="bg-white p-6 rounded-lg">
                            <h2 class="text-lg text-gray-900 font-medium title-font mb-2">{{ $subscription->title }}</h2>
                            <p class="leading-relaxed text-base">{{ $subscription->price }}円/{{ $checkSubscriptionService::checkFrequency($subscription) }}</p>
                            @if(is_null($subscription->cancel_day))
                                <p class="leading-relaxed text-base">支払日：{{ is_null($subscription->next_payment_day) ? substr($subscription->first_payment_day, 0, 10) : substr($subscription->next_payment_day, 0, 10) }}</p>
                            @else
                                <p class="leading-relaxed text-base">支払日：--/ --/--</p>
                            @endif
                            <p class="leading-relaxed text-base">ステータス：{{ is_null($subscription->cancel_day) ? "契約中" : "解約済"}}
                            </p>

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
