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
        <div id="ajax-flash-message">

        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- <a href="{{ route('subscriptions.create') }}" class="btn btn-info my-3" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="las la-plus"></i> 新規登録</a> --}}
            <a href="" class="btn btn-info my-3" data-bs-toggle="modal" data-bs-target="#addModal"><i class="las la-plus"></i> 新規登録</a>

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
            {!! $subscriptions->links() !!}<br>
        </div>
    </div>
    @include('subscriptions.add_modal')
    @include('subscriptions.add_js')
    @include('common.flash_message_fadeout_js')
</x-app-layout>
