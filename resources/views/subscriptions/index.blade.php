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
                                <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-pink-100 text-pink-500 mb-4">
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                </div>
                            <h2 class="text-lg text-gray-900 font-medium title-font mb-2">{{ $subscription->title }}</h2>
                            <p class="leading-relaxed text-base">{{ $subscription->price }}円/{{ $checkSubscriptionService::checkFrequency($subscription) }}</p>
                            <p class="leading-relaxed text-base">次回支払日　2025年○月○日</p>
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
