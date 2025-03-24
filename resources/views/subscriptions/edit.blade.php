<x-app-layout>
    <div class="py-12 app-background-image">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(is_null($subscription->cancel_day))
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font relative">
                            <form method="post" action="{{ route('subscriptions.update', ['id' => $subscription->id]) }}">
                                @csrf
                                <div class="container px-5 py-4">
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                        <header>
                                            <h2 class="font-semibold text-xl text-gray-800 leading-tight py-10">
                                                {{ $subscription->title }}を編集
                                            </h2>
                                        </header>
                                        <div class="flex flex-wrap -m-2">
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="title" class="leading-7 text-sm text-gray-600">サブスク名<span class="rounded-full bg-pink-50 px-2 py-1 text-xs font-semibold text-pink-600"> 必須 </span></label>
                                                    <input type="text" id="title" name="title" value="{{ $subscription->title }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                            </div>
                                            <div class="p-2 w-5/6">
                                                <div class="relative">
                                                    <label for="price" class="leading-7 text-sm text-gray-600">料金<span class="rounded-full bg-pink-50 px-2 py-1 text-xs font-semibold text-pink-600"> 必須 </span></label>
                                                    <input type="number" id="price" name="price"  value="{{ $subscription->price }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                            </div>
                                            <div class="p-2 w-1/6" id="parent-box">
                                                <div id="currency">円</div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <h3 class="font-semibold mb-2">支払い設定</h3>
                                                <div class="relative">
                                                    <label for="first_payment_day" class="leading-7 text-sm text-gray-600">初回支払日<span class="rounded-full bg-pink-50 px-2 py-1 text-xs font-semibold text-pink-600"> 必須 </span>
                                                    </label>
                                                    <input type="date" id="first_payment_day" name="first_payment_day"  value="{{substr($subscription->first_payment_day, 0, 10)}}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    <x-input-error :messages="$errors->get('first_payment_day')" class="mt-2" />
                                                </div>
                                                <div class="relative">
                                                    <label for="frequency" class="leading-7 text-sm text-gray-600">支払い頻度<span class="rounded-full bg-pink-50 px-2 py-1 text-xs font-semibold text-pink-600"> 必須 </span></label>
                                                    <select id="frequency" name="frequency"class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                        <option value="1" @if($subscription->frequency === 1) selected @endif>月に1回</option>
                                                        <option value="2" @if($subscription->frequency === 2) selected @endif>2ヶ月に1回</option>
                                                        <option value="3" @if($subscription->frequency === 3) selected @endif>3ヶ月に1回</option>
                                                        <option value="6" @if($subscription->frequency === 6) selected @endif>6ヶ月に1回</option>
                                                        <option value="12" @if($subscription->frequency === 12) selected @endif>1年に1回</option>
                                                    </select>
                                                    <x-input-error :messages="$errors->get('frequency')" class="mt-2" />
                                                </div>
                                                <div class="relative">
                                                    <label for="url" class="leading-7 text-sm text-gray-600">URL</label>
                                                    <input type="url" id="url" name="url" value="{{ $subscription->url }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                                <x-input-error :messages="$errors->get('url')" class="mt-2" />
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="memo" class="leading-7 text-sm text-gray-600">メモ</label>
                                                    <textarea id="memo" name="memo" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">{{ $subscription->memo }}</textarea>
                                                </div>
                                                <x-input-error :messages="$errors->get('memo')" class="mt-2" />
                                            </div>
                                            <input type='hidden' value="{{ Auth::user()->id }}" name="user_id">
                                            <div class="p-2 w-full flex justify-end">
                                                <a href="{{ route('subscriptions.index') }}">
                                                    <button type="button" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-center text-sm font-medium text-gray-700 shadow-sm transition-all hover:bg-gray-100 focus:ring focus:ring-gray-100 disabled:cursor-not-allowed disabled:border-gray-100 disabled:bg-gray-50 disabled:text-gray-400">
                                                        戻る
                                                    </button>
                                                </a>
                                                <button class="ml-2 text-white bg-pink-500 border-0 py-2 px-8 focus:outline-none hover:bg-pink-600 rounded text-lg">
                                                    更新
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                        @if (is_null($subscription->cancel_day))

                            <form method="POST" action="{{ route('subscriptions.cancel', $subscription) }}">
                                @csrf
                                <header>
                                    <h2 class="font-semibold text-xl text-gray-800 leading-tight py-10">
                                        {{ $subscription->title }}を解約する
                                    </h2>
                                </header>
                                <p class="py-3">「解約する」を選択すると翌日から{{ $subscription->title }}のサブスクの課金記録は取られません。解約日以前の課金記録のみ残ります。</p>
                                <div class="p-2 w-full flex justify-end">
                                    <a href="{{ route('subscriptions.index') }}" method="POST">
                                        <button type="button" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-center text-sm font-medium text-gray-700 shadow-sm transition-all hover:bg-gray-100 focus:ring focus:ring-gray-100 disabled:cursor-not-allowed disabled:border-gray-100 disabled:bg-gray-50 disabled:text-gray-400">
                                            戻る
                                        </button>
                                    </a>
                                    <button class="ml-2 text-white bg-pink-500 border-0 py-2 px-8 focus:outline-none hover:bg-pink-600 rounded text-lg">
                                        解約
                                    </button>
                                </div>
                            </form>
                        @else
                            <header>
                                <h2 class="font-semibold text-xl text-gray-800 leading-tight py-10">
                                    {{ $subscription->title }}の解約状況
                                </h2>
                            </header>
                            <p class="pb-5">{{ $subscription->title }}は{{ $subscription->cancel_day }}に解約済です。</p>
                            <a href="{{ route('subscriptions.index') }}" method="POST">
                                <button type="button" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-center text-sm font-medium text-gray-700 shadow-sm transition-all hover:bg-gray-100 focus:ring focus:ring-gray-100 disabled:cursor-not-allowed disabled:border-gray-100 disabled:bg-gray-50 disabled:text-gray-400">
                                    戻る
                                </button>
                            </a>
                        @endif
                    </div>
                </div>
            </div>


        </div>
    </div>
</x-app-layout>
