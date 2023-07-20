<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ Auth::user()->name }}'s Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if (!empty($currentBazaarName) && !empty($currentDutyName))
                    <div class="p-6 text-gray-900">
                        <div class="p-6" style="text-align: center;">
                            <span class="font-bold text-black" style="font-size: 1.5rem;">
                                {{ __('Currently you are volunteering at') }}
                            </span>
                            <span class="font-bold text-black" style="font-size: 1.5rem; font-weight:bold;">
                                {{ $currentBazaarName }} in {{ $bazaarLocation }}
                            </span>
                        </div>

                        <div class="p-6" style="text-align: center;">
                            <span class="font-bold text-black" style="font-size: 1.5rem;">
                                Your Duty is <b>{{ $currentDutyName }}</b>
                            </span>
                            <br>
                            @if (strpos($currentDutyName, 'Distribute') !== false)
                                @if (!empty($dutyRemarks))
                                    <span class="font-bold text-black" style="font-size: 1.2rem;">
                                        Duty Remarks: <b>{{ $dutyRemarks }}</b>
                                    </span>
                                    <br>
                                @endif
                                @if (!empty($dutyLocation))
                                    <span class="font-bold text-black" style="font-size: 1.2rem;">
                                        Duty Location: <b>{{ $dutyLocation }}</b>
                                    </span>
                                @endif
                            @else
                                @if (!empty($dutyRemarks))
                                    <span class="font-bold text-black" style="font-size: 1.2rem;">
                                        Duty Remarks: <b>{{ $dutyRemarks }}</b>
                                    </span>
                                @endif
                            @endif
                        </div>
                    </div>
                @elseif (!empty($currentBazaarName))
                    <div class="p-6 text-gray-900">
                        <div class="p-6 text-gray-900">
                            <div class="p-6" style="text-align: center;">
                                <span class="font-bold text-black" style="font-size: 1.5rem;">
                                    Currently, you are volunteering at <b>{{ $currentBazaarName }}</b> in
                                    <b>{{ $bazaarLocation }}</b>, but you have not been
                                    assigned any
                                    duty yet.
                                </span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="p-6 text-gray-900">
                        <div class="p-6 text-gray-900">
                            <div class="p-6" style="text-align: center;">
                                <span class="font-bold text-black" style="font-size: 1.5rem;">
                                    Currently, you are not volunteering at any bazaar.
                                </span>
                            </div>
                        </div>
                        <div class="p-6 text-center">
                            <span class="text-xl font-bold">
                                <a href="{{ route('volunteer.chooseVolunteer') }}" class="italic text-blue"
                                    style="color: rgb(39, 157, 242);" onmouseover="this.style.color='rgb(33, 0, 248)'"
                                    onmouseout="this.style.color='rgb(39, 157, 242)'">
                                    {{ __('Volunteer Now') }}
                                </a>
                            </span>
                        </div>
                @endif
            </div>
        </div>
</x-app-layout>
