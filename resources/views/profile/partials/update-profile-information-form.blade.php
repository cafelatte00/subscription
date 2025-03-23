<section>
    <header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            プロフィールを編集
        </h2>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}" >
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <label for="image">プロフィール画像</label>
            @if ($user->image)
                <div>
                    <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . $user->image) }}" alt="プロフィール画像" style="max-width: 150px;">
                </div>
            @endif
            <input type="file" name="image" id="image">
            <br/>
            <small>※新しいプロフィール画像をアップロードする場合は、こちらから選択してください。</small>
        </div>

        <div>
            <x-input-label for="name" :value="__('profile.Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('profile.Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('profile.Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('profile.Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('profile.A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('profile.Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('profile.Saved.') }}</p>
            @endif
        </div>
    </form>

    @if ($user->image)
        <form method="POST" action="{{ route('profile.destroyImage') }}">
            @csrf
            @method('DELETE')
            <button class="inline-flex items-center mt-2 px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" type="submit">画像を削除する</button>
        </form>
    @endif

</section>
