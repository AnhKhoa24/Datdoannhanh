<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Bạn quên mật khẩu? Hãy điền vào đây email đăng kí tài khoản của bạn, chúng tôi sẽ gửi cho bạn form nhập mật khẩu') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Nhận link nhập lại mật khẩu') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
