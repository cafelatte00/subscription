<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SubsCut</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.bg-gray-100{--tw-bg-opacity: 1;background-color:rgb(243 244 246 / var(--tw-bg-opacity))}.border-gray-200{--tw-border-opacity: 1;border-color:rgb(229 231 235 / var(--tw-border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{--tw-shadow: 0 1px 3px 0 rgb(0 0 0 / .1), 0 1px 2px -1px rgb(0 0 0 / .1);--tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000),var(--tw-ring-shadow, 0 0 #0000),var(--tw-shadow)}.text-center{text-align:center}.text-gray-200{--tw-text-opacity: 1;color:rgb(229 231 235 / var(--tw-text-opacity))}.text-gray-300{--tw-text-opacity: 1;color:rgb(209 213 219 / var(--tw-text-opacity))}.text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}.text-gray-600{--tw-text-opacity: 1;color:rgb(75 85 99 / var(--tw-text-opacity))}.text-gray-700{--tw-text-opacity: 1;color:rgb(55 65 81 / var(--tw-text-opacity))}.text-gray-900{--tw-text-opacity: 1;color:rgb(17 24 39 / var(--tw-text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--tw-bg-opacity: 1;background-color:rgb(31 41 55 / var(--tw-bg-opacity))}.dark\:bg-gray-900{--tw-bg-opacity: 1;background-color:rgb(17 24 39 / var(--tw-bg-opacity))}.dark\:border-gray-700{--tw-border-opacity: 1;border-color:rgb(55 65 81 / var(--tw-border-opacity))}.dark\:text-white{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity))}.dark\:text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.dark\:text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}}
        </style>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
        <link rel="stylesheet" href="{{ asset('css/style.css')}}">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="antialiased">
        <section class="relative flex items-top justify-center min-h-screen bg-salmon-pink sm:items-center py-4 sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/subscriptions') }}" class="login_link">すべてのサブスクへ</a>
                    @else
                        <div class="mt-6">
                            <a href="{{ route('login') }}" class="login_link mr-6">ログイン</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="button-pink-outline">新規アカウント作成</a>
                            @endif
                        </div>
                    @endauth
                </div>
            @endif

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="mt-8 overflow-hidden sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="p-6">
                            <div class="flex justify-center sm:mt-18 mb-6 sm:mb-20 sm:justify-start">
                                <img src="{{ url('images/logo_white350x150.png') }}">
                            </div>
                            <p class="text-3xl sm:text-5xl pb-5 text-white text-center sm:text-left">サブスクを</p>
                            <p class="text-3xl sm:text-5xl pb-5 text-white text-center sm:text-left">スカッとカット</p>
                            <p class="text-3xl sm:text-5xl pb-12 sm:pb-20 text-white text-center sm:text-left">サブスカット</p>
                            <div class="flex justify-center sm:justify-start">
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}">
                                        <button class="button-white-outline sm:justify-start">今すぐ始める</button>
                                    </a>
                                @endif
                            </div>
                            <div class="flex justify-center sm:justify-start mt-6">
                                @if (Route::has('login'))
                                    <!-- ゲストログイン -->
                                    <a href="{{ route('guestLogin') }}" class="login_link mr-6">ゲストログイン</a>
                                    <a href="{{ route('login') }}" class="sm:hidden login_link mr-6">ログイン</a>
                                @endif
                            </div>
                        </div>

                        <div class="p-6">
                            <img src="{{ url('images/welcome_mobile.png') }}">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="text-gray-600 body-font bg-light-pink">
            <div class="container px-5 py-24 mx-auto">
                <h2 class="text-center text-pink-600 text-3xl sm:text-5xl pb-10 sm:my-20">サブスカットの特徴</h2>

                <div class="flex flex-wrap -m-4">
                    <div class="p-4 md:w-1/3">
                        <div class="h-full pink-shadow rounded-lg overflow-hidden">
                            <img class="lg:h-48 md:h-36 w-full object-cover object-center" src="{{ url('images/mail.png') }}" alt="mail">
                            <div class="p-6 bg-white">
                                <h2 class="title-font text-lg font-medium text-gray-900 mb-3">課金日をメールでお知らせ</h2>
                                <p class="leading-relaxed mb-3">登録したサブスクの課金日が近くなったらメールでお知らせ。解約しようと思っていたのに、忘れて課金されるのを防ぎます。
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 md:w-1/3">
                        <div class="h-full  pink-shadow rounded-lg overflow-hidden">
                            <img class="lg:h-48 md:h-36 w-full object-cover object-center" src="{{ url('images/index.png') }}" alt="blog">
                            <div class="p-6 bg-white">
                                <h2 class="title-font text-lg font-medium text-gray-900 mb-3">一覧表示でパッと見やすい</h2>
                                <p class="leading-relaxed mb-3">何に・いつ・いくら課金されるかを一覧で確認できます。「そういえばアレいつ引き落とし日だっけ？」というモヤモヤがなくなります。</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 md:w-1/3">
                        <div class="h-full  pink-shadow rounded-lg overflow-hidden">
                            <img class="lg:h-48 md:h-36 w-full object-cover object-center" src="{{ url('images/graph.png') }}">
                            <div class="p-6 bg-white">
                                <h2 class="title-font text-lg font-medium text-gray-900 mb-3">グラフ表示で直感的</h2>
                                <p class="leading-relaxed mb-3">グラフ表示で直感的に使った金額を把握できます。「最近サブスクに結構お金を使っていたな」など、改善点が一目瞭然です。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-warm-pink">
            <div class="sm:flex sm:justify-center sm:items-center sm:gap-x-10">
                <div class="flex justify-center sm:mt-18 mb-6 sm:mb-20 sm:justify-start">
                    <img src="{{ url('images/pc_mobile.png') }}">
                </div>
                <div class="flex items-center sm:ml-5 pb-20">
                    <div class="m-auto">
                        <p class="text-xl sm:text-2xl pb-5 text-white text-center sm:text-left">サブスク解約忘れを防止</p>
                        <p class="text-xl sm:text-2xl pb-5 text-white text-center sm:text-left">モヤモヤ解消</p>
                        <p class="text-xl sm:text-2xl pb-5 text-white text-center sm:text-left">サブスク管理アプリ、サブスカット</p>
                    </div>
                </div>
            </div>
        </section>
        <footer class="bg-warm-pink text-white text-center">© {{ date('Y') }} SubsCut. All rights reserved.</footer>
    </body>
</html>
