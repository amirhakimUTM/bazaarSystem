<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Leftover Food Collection Center') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <form class="form-horizontal" method="POST" action="{{ route('bazaar.store') }}">
                    {{ csrf_field() }}
    
                    <table class="table">
                        <tr>
                            <td>
                                <label for="bazaarName" class="control-label">Leftover Food Collection Center Name</label>
                            </td>
                            <td>
                                <input id="bazaarName" type="text" class="form-control" name="bazaarName"
                                    value="{{ old('bazaarName') }}" required autofocus>
    
                                @if ($errors->has('bazaarName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bazaarName') }}</strong>
                                    </span>
                                @endif
                            </td>
                        </tr>
    
                        <tr>
                            <td>
                                <label for="volunteerLimit" class="control-label">Volunteer Limit</label>
                            </td>
                            <td>
                                <input id="volunteerLimit" type="number" class="form-control" name="volunteerLimit"
                                    value="{{ old('volunteerLimit') }}" required>
    
                                @if ($errors->has('volunteerLimit'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('volunteerLimit') }}</strong>
                                    </span>
                                @endif
                            </td>
                        </tr>
    
                        <tr>
                            <td>
                                <label for="searchAddress" class="control-label">Search Address</label>
                            </td>
                            <td>
                                <input id="searchAddress" type="text" class="form-control" placeholder="Enter an address">
                                <small>Search for the address then pinpoint the location on the map.</small>
                            </td>
                        </tr>
    
                        <tr>
                            <td>
                                <label for="bazaarAddress" class="control-label">Bazaar Address</label>
                            </td>
                            <td>
                                <div id="map" style="height: 300px;  width:700px"></div>
                                <input id="bazaarAddress" type="text" class="form-control" name="bazaarAddress" readonly
                                    required>
                            </td>
                        </tr>
    
                        <tr>
                            <td>
                                <input type="hidden" name="bazaarLeader" value=null>
                            </td>
                            <td>
                                <button id="submit-btn" type="submit" class="btn">Create Leftover Food Collection Center</button>
                            </td>
                        </tr>
                    </table>
                </form> 
            </div>

            {{-- <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                
            </div> --}}
        </div>
    </div>
</x-app-layout>
