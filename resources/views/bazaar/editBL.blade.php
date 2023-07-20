<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Bazaar Leader') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('bazaar.updateBL', $user->name) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ __('Name') }}:
                            </label>
                            <input type="text" value="{{ $user->name }}" readonly
                                class="form-input bg-gray-100" disabled>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ __('Email') }}:
                            </label>
                            <input type="email" value="{{ $user->email }}" readonly
                                class="form-input bg-gray-100" disabled>
                        </div>

                        <div class="mb-4">
                            <label for="telNo" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ __('Telephone Number') }}:
                            </label>
                            <input type="text" value="{{ $user->telNo }}" readonly
                                class="form-input bg-gray-100" disabled>
                        </div>

                        <div class="mb-4">
                            <label for="bazaarName" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ __('Bazaar Name') }}:
                            </label>
                            <select name="bazaarName" id="bazaarName" class="form-select">
                                <option value="" disabled selected>Select Bazaar</option>
                                @foreach ($bazaars as $bazaar)
                                    <option value="{{ $bazaar->bazaarName }}"
                                        {{ $bazaar->bazaarName === $user->bazaarName ? 'selected' : '' }}>
                                        {{ $bazaar->bazaarName }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bazaarName')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center mt-6">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Update Bazaar Leader') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
