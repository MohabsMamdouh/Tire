<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ Route::currentRouteName() == 'customer.edit' ? __('Update Customer') : __('Create New Customer') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Update or Add Customer Information.') }}
        </p>
    </header>


    <form method="post" class="mt-6 space-y-6"
        action="{{ Route::currentRouteName() == 'customer.edit' ? route('customer.update', ['id' => $customer->id]) : route('customer.store') }}">
        @csrf

        {{-- Id --}}
        @if (isset($customer))
            <x-text-input id="id" name="id" type="hidden" class="mt-1 block w-full"
                value="{{ $customer->id }}" />
        @endif
        {{-- Name --}}
        <div>
            <x-input-label for="customer_fname" :value="__('Name')" />
            @if (isset($customer))
                <x-text-input id="customer_fname" name="customer_fname" type="text" class="mt-1 block w-full"
                    value="{{ $customer->customer_fname }}" required autofocus autocomplete="customer_fname" />
            @else
                <x-text-input id="customer_fname" name="customer_fname" type="text" class="mt-1 block w-full"
                    required autofocus autocomplete="customer_fname" />
            @endif
            {{-- <x-input-error class="mt-2" :messages="$errors->get('fname')" /> --}}
            @error('customer_fname')
                <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            @if (isset($customer))
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                    value="{{ $customer->email }}" required autofocus autocomplete="email" />
            @else
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required autofocus
                    autocomplete="email" />
            @endif
            {{-- <x-input-error class="mt-2" :messages="$errors->get('fname')" /> --}}
            @error('email')
                <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Username --}}
        <div>
            <x-input-label for="customer_username" :value="__('Username')" />
            @if (isset($customer))
                <x-text-input id="customer_username" name="customer_username" type="text" class="mt-1 block w-full"
                    value="{{ $customer->customer_username }}" required autofocus autocomplete="customer_username" />
            @else
                <x-text-input id="customer_username" name="customer_username" type="text" class="mt-1 block w-full"
                    required autofocus autocomplete="customer_username" />
            @endif
            {{-- <x-input-error class="mt-2" :messages="$errors->get('username')" /> --}}
            @error('customer_username')
                <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="customer_address" :value="__('Address')" />
            @if (isset($customer))
                <x-text-input id="customer_address" name="customer_address" type="text" class="mt-1 block w-full"
                    value="{{ $customer->customer_address }}" required autofocus autocomplete="customer_address" />
            @else
                <x-text-input id="customer_address" name="customer_address" type="text" class="mt-1 block w-full"
                    required autofocus autocomplete="customer_address" />
            @endif
            {{-- <x-input-error class="mt-2" :messages="$errors->get('email')" /> --}}
            @error('customer_address')
                <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                    {{ $message }}
                </div>
            @enderror
        </div>

        @if (!isset($customer))
            {{-- Password --}}
            <div>
                <x-input-label for="customer_password" :value="__('Password')" />
                <x-text-input id="customer_password" name="password" type="password" class="mt-1 block w-full"
                    required />
                {{-- <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" /> --}}
                @error('customer_password')
                    <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        @endif

        {{-- Phone --}}
        <div>
            <x-input-label for="customer_phone" :value="__('Phone')" />
            @if (isset($customer))
                <x-text-input id="customer_phone" name="customer_phone" type="text" class="mt-1 block w-full"
                    value="{{ $customer->customer_phone }}" required autofocus autocomplete="phone" />
            @else
                <x-text-input id="customer_phone" name="customer_phone" type="text" class="mt-1 block w-full"
                    required autofocus autocomplete="customer_phone" />
            @endif
            {{-- <x-input-error class="mt-2" :messages="$errors->get('phone')" /> --}}
            @error('customer_phone')
                <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                    {{ $message }}
                </div>
            @enderror
        </div>


        {{-- Role --}}
        <div>
            <x-input-label for="roles" :value="__('Role')" />
            <select name="roles" id="roles"
                class="dark:border-gray-700 border-black-400 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">
                <option value="">-- {{ __('Chooce The Role') }} --</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}"
                        @if (isset($user->roles[0])) @if ($role->name == $customer->roles[0]->name) selected @endif
                        @endif>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            @error('roles')
                <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>


    </form>

</section>
