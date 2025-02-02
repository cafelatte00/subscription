<x-app-layout>
    @inject('checkSubscriptionService', 'App\Services\CheckSubscriptionService')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            すべてのサブスク
        </h2>
    </x-slot>

    <div class="py-12">
        @if (session('status'))
            <div id="flash-message" class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div id="ajax-flash-message"></div>

        {{-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 app-background-image">

            <div id="index-flame">
            @foreach($subscriptions as $subscription)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <a href="{{ route('subscriptions.show', ['id' => $subscription->id]) }}">
                        <div class="p-6 text-gray-900">
                            User_id：{{ $subscription->user_id}}<br>
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
            </div>
        </div> --}}
    </div>
    @include('subscriptions.add_modal')
    @include('subscriptions.add_js')
    @include('common.flash_message_fadeout_js')
    <style>
        .app-background-image{
            /* background-image: linear-gradient(to right top, #ff7e9c, #ff9cab, #ffb9be, #ffd4d4, #fdefee); */
            background-image: linear-gradient(-225deg, #FFE29F 0%, #FFA99F 48%, #FF719A 100%);
        }
</style>

{{-- ここからテイルブロック --}}
<section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto app-background-image">
        <div class="flex flex-wrap w-full mb-20 flex-col items-center text-center">
            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-2 text-white">すべてのサブクス</h1>
        </div>
        <button  data-bs-toggle="modal" data-bs-target="#addModal" class="flex mx-auto mt-16 my-5 text-white bg-pink-500 border-0 py-2 px-8 focus:outline-none hover:bg-pink-600 rounded text-lg"><i class="las la-plus"></i>Button</button>
        {{-- <a href="" class="btn btn-info my-3" data-bs-toggle="modal" data-bs-target="#addModal"><i class="las la-plus"></i> 新規登録</a> --}}

        <div id="index-flame" class="flex flex-wrap -m-4">
            @foreach($subscriptions as $subscription)
                <div class="xl:w-1/3 md:w-1/2 p-4">
                    <a href="{{ route('subscriptions.show', ['id' => $subscription->id]) }}">
                        <div class="border border-gray-200 p-6 rounded-lg">
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
        {!! $subscriptions->links() !!}<br>

    </div>
</section>
{{-- ここまでテイルブロック --}}

</x-app-layout>
