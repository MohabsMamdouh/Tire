<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ Route::currentRouteName() == 'user.edit' ? __('Update User') : __('Create New User') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Update or Add User Information.') }}
        </p>
    </header>


    <form method="post" class="mt-6 space-y-6"
        action="{{ Route::currentRouteName() == 'user.edit' ? route('user.update', ['id' => $user->id]) : route('user.store') }}">
        @csrf

        {{-- Id --}}
        @if (isset($user))
            <x-text-input id="id" name="id" type="hidden" class="mt-1 block w-full"
                value="{{ $user->id }}" />
        @endif
        {{-- Name --}}
        <div>
            <x-input-label for="fname" :value="__('Name')" />
            @if (isset($user))
                <x-text-input id="fname" name="fname" type="text" class="mt-1 block w-full"
                    value="{{ $user->fname }}" required autofocus autocomplete="fname" />
            @else
                <x-text-input id="fname" name="fname" type="text" class="mt-1 block w-full" required autofocus
                    autocomplete="fname" />
            @endif
            {{-- <x-input-error class="mt-2" :messages="$errors->get('fname')" /> --}}
            @error('fname')
                <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Username --}}
        <div>
            <x-input-label for="username" :value="__('Username')" />
            @if (isset($user))
                <x-text-input id="username" name="username" type="text" class="mt-1 block w-full"
                    value="{{ $user->username }}" required autofocus autocomplete="username" />
            @else
                <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" required autofocus
                    autocomplete="username" />
            @endif
            {{-- <x-input-error class="mt-2" :messages="$errors->get('username')" /> --}}
            @error('username')
                <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            @if (isset($user))
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                    value="{{ $user->email }}" required autofocus autocomplete="email" />
            @else
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required autofocus
                    autocomplete="email" />
            @endif
            {{-- <x-input-error class="mt-2" :messages="$errors->get('email')" /> --}}
            @error('email')
                <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                    {{ $message }}
                </div>
            @enderror
        </div>

        @if (!isset($user))
            {{-- Password --}}
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                {{-- <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" /> --}}
                @error('password')
                    <div class="error text-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-300">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        @endif

        {{-- Phone --}}
        <div>
            <x-input-label for="phone" :value="__('Phone')" />
            @if (isset($user))
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                    value="{{ $user->phone }}" required autofocus autocomplete="phone" />
            @else
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" required autofocus
                    autocomplete="phone" />
            @endif
            {{-- <x-input-error class="mt-2" :messages="$errors->get('phone')" /> --}}
            @error('phone')
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
                        @if (isset($user->roles[0])) @if ($role->name == $user->roles[0]->name) selected @endif
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

        {{-- Image --}}
        {{-- <div>
        <x-input-label for="img" :value="__('Image')" />

        <label
            class="p-3 cursor-pointer my-2 border dark:border-gray-700 border-black-400 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full"
            for="customFile" x-data="{ files: null }">
            <input type="file" class="sr-only  border-gray-300" id="customFile"
                x-on:change="files = Object.values($event.target.files)">
            <span x-text="files ? files.map(file => file.name).join(', ') : 'Choose single file...'"></span>
        </label>
    </div> --}}




        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>


    </form>

</section>
