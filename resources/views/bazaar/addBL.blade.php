<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Bazaar Leader') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Fill the new bazaar leader information') }}
                    </h2>

                    {{-- <p class="mt-1 text-sm text-gray-600">
                        {{ __("Update your account's profile information and email address.") }}
                    </p> --}}
                </header>
                <form class="mt-6 space-y-6" method="POST" action="{{ route('bazaar.storeBL') }}">
                    {{ csrf_field() }}

                    <div>
                        <x-input-label for="name" :value="__('Bazaar Leader Name')" />
                        <x-text-input id="name" name="name" type="text" :value="old('name')" required autofocus
                            class="mt-1 block w-full" />
                        @if ($errors->has('name'))
                            <x-input-error :message="$errors->first('name')" />
                        @endif
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Bazaar Leader Email')" />
                        <x-text-input id="email" type="email" name="email" :value="old('email')" required
                            class="mt-1 block w-full" />
                        {{-- @if ($errors->has('email'))
                            <x-input-error :message="$errors->first('email')" />
                        @endif --}}
                    </div>

                    <div class="mt-4">
                        <x-input-label for="telNo" :value="__('Telephone Number')" />
                        <x-text-input id="telNo" class="block mt-1 w-full" type="text" name="telNo" :value="old('telNo')" required autocomplete="telNo" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />

                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" required autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="bazaarName" :value="__('Assign Bazaar')" />
                        <select name="bazaarName" class="form-input" id="bazaarName">
                            <option value="">Select Bazaar</option>
                            @foreach ($bazaars as $bazaar)
                                @if (!$bazaar->users->where('bazaarName', $bazaar->bazaarName)->count())
                                    <option value="{{ $bazaar->bazaarName }}">{{ $bazaar->bazaarName }}</option>
                                @endif
                            @endforeach

                        </select>
                        @error('bazaarName')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <div>
                        <input type="hidden" name="role" value="bazaar_leader">
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Add New Bazaar Leader') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
