<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Delete Super Admin') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Delete Super Admin.') }}
        </p>
    </header>

    <form method="post" class="mt-6 space-y-6" action="{{ route('access.deleteSuperAdmin') }}">
        @csrf

        {{-- Users --}}
        <div>
            <x-input-label for="users" :value="__('Users')" />
            <select name="users" id="users"
                class="dark:border-gray-700 border-black-400 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">
                <option value="">-- {{ __('Chooce a super admin') }} --</option>
                @foreach ($superAdmins as $user)
                    <option value="{{ $user->id }}">
                        {{ $user->fname }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Revoke') }}</x-primary-button>
        </div>


    </form>

</section>
