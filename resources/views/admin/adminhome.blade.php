<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex justify-center items-center h-screen">
        <div class="py-12 w-1/2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6" style="min-height: 10rem; min-width:10rem;">
                        <span class="font-bold text-black" style="font-size: 1.5rem;">
                            {{ __('Total Leftover Food Collection Centers') }} : 
                        </span>
                        <span class="font-bold text-black" style="font-size: 1.8rem; font-weight:bold;">
                            {{ $totalBazaar }}
                        </span>
                    </div>

                    <div class="p-6 text-center">
                        <span class="text-xl font-bold">
                            <a href="{{ route('bazaar.bazaarList') }}" class="italic text-blue"
                                style="color: rgb(39, 157, 242);" onmouseover="this.style.color='rgb(33, 0, 248)'"
                                onmouseout="this.style.color='rgb(39, 157, 242)'">
                                {{ __('Manage Leftover Food Collection Center') }}
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-12 w-1/2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6" style="min-height: 10rem; min-width:10rem;">
                        <span class="font-bold text-black" style="font-size: 1.5rem;">
                            {{ __('Total Bazaar Leaders') }} : 
                        </span>
                        <span class="font-bold text-black" style="font-size: 1.8rem; font-weight:bold;">
                            {{ $BLCount }}
                        </span>
                    </div>

                    <div class="p-6 text-center">
                        <span class="text-xl font-bold">
                            <a href="{{ route('bazaar.indexBL') }}" class="italic text-blue"
                                style="color: rgb(39, 157, 242);" onmouseover="this.style.color='rgb(33, 0, 248)'"
                                onmouseout="this.style.color='rgb(39, 157, 242)'">
                                {{ __('Manage Bazaar Leaders') }}
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-12 w-1/2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6" style="min-height: 5rem; min-width:10rem;">
                        <span class="font-bold text-black" style="font-size: 1.5rem;">
                            {{ __('Volunteers Registered:') }}
                        </span>
                        <span class="font-bold text-black" style="font-size: 1.8rem; font-weight:bold;">
                            {{ $volunteerCount }}
                        </span>
                    </div>
                    <div class="p-4" >
                        <span class="font-bold text-black" style="font-size: 1.5rem;">
                            {{ __('Volunteers With No Duties:') }}
                        </span>
                        <span class="font-bold text-black" style="font-size: 1.8rem; font-weight:bold;">
                            {{ $notAssign }}
                        </span>
                    </div>

                    <div class="p-6 text-center">
                        <span class="text-xl font-bold">
                            <a href="{{ route('bazaar.indexV') }}" class="italic text-blue"
                                style="color: rgb(39, 157, 242);" onmouseover="this.style.color='rgb(33, 0, 248)'"
                                onmouseout="this.style.color='rgb(39, 157, 242)'">
                                {{ __('Manage Volunteers') }}
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-center items-center h-screen">
        <div class="py-12 w-1/2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center" style="min-height: 10rem; min-width:20rem;">
                        <span class="font-bold text-black" style="font-size: 1.5rem;">
                            {{ __('Total Duties') }} : 
                        </span>
                        <span class="font-bold text-black" style="font-size: 1.8rem; font-weight:bold;">
                            {{ $totalDuties }}
                        </span>
                    </div>
    
                    <div class="p-6 text-center">
                        <span class="text-xl font-bold">
                            <a href="{{ route('duty.list') }}" class="italic text-blue"
                                style="color: rgb(39, 157, 242);" onmouseover="this.style.color='rgb(33, 0, 248)'"
                                onmouseout="this.style.color='rgb(39, 157, 242)'">
                                {{ __('Manage Duty') }}
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-12 w-1/2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6" style="min-height: 10rem; min-width:10rem;">
                        <span class="font-bold text-black" style="font-size: 1.5rem;">
                            {{ __('Total Leftover Food Weight') }} : 
                        </span>
                        <span class="font-bold text-black" style="font-size: 1.8rem; font-weight:bold;">
                            {{ $totalWeight }} kg
                        </span>
                    </div>
    
                    <div class="p-6 text-center">
                        <span class="text-xl font-bold">
                            <a href="{{ route('foodweights.foodWeightListAdmin') }}" class="italic text-blue"
                                style="color: rgb(39, 157, 242);" onmouseover="this.style.color='rgb(33, 0, 248)'"
                                onmouseout="this.style.color='rgb(39, 157, 242)'">
                                {{ __('Manage Weight') }}
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
