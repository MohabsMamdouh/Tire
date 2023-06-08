<x-guest-layout>
    <form method="POST" action="{{ route('customer.register.store') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="customer_fname" :value="__('Name')" />
            <x-text-input id="customer_fname" class="block mt-1 w-full text-black" type="text" name="customer_fname"
                :value="old('customer_fname')" required autofocus />
            <x-input-error :messages="$errors->get('customer_fname')" class="mt-2" />
            @error('customer_phone')
                <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full text-black" type="email" name="email" :value="old('email')"
                required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            @error('email')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="sm:inline">{{ $message }}</span>
                </div>
            @enderror
        </div>

        <!-- Address -->
        <div class="mt-4">
            <x-input-label for="customer_address" :value="__('Address')" />
            <x-text-input id="customer_address" class="block mt-1 w-full text-black" type="text" name="customer_address"
                :value="old('customer_address')" required autofocus />
            <x-input-error :messages="$errors->get('customer_address')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="customer_phone" :value="__('Phone')" />
            <x-text-input id="customer_phone" class="block mt-1 w-full text-black" type="text" name="customer_phone"
                :value="old('customer_phone')" required autofocus />
            <x-input-error :messages="$errors->get('customer_phone')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full text-black" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full text-black" type="password"
                name="password_confirmation" required />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('customer.Login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
