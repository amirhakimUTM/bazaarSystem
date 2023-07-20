<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Duty') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 bg-white shadow sm:rounded-lg">

                <form class="mt-6 space-y-6" method="POST" action="{{ route('duty.update', $duty->id) }}">
                    @csrf
                    @method('PUT')

                    @php
                        $dutyName = $duty->dutyName;
                        $selectedBazaar = $duty->bazaarName;
                        $selectedDutyLocation = $duty->dutyLocation; 
                        $selectedDutyRemarks = $duty->dutyRemarks; 
                    @endphp

                    <div>
                        <x-input-label for="dutyType" :value="__('Duty Type')" />
                        <select name="dutyType" id="dutyType" class="form-input">
                            <option value="">Select Duty Type</option>
                            <option value="Collecting Leftover Food" @if ($dutyName == 'Collecting Leftover Food(' . $selectedBazaar . ')') selected @endif>
                                Collecting Leftover Food</option>
                            <option value="Repackaging Leftover Food" @if ($dutyName == 'Repackaging Leftover Food(' . $selectedBazaar . ')') selected @endif>
                                Repackaging Leftover Food</option>
                            <option value="Weighting Leftover Food" @if ($dutyName == 'Weighting Leftover Food(' . $selectedBazaar . ')') selected @endif>
                                Weighting Leftover Food</option>
                            <option value="Distribute Leftover Food" @if ($dutyName == 'Distribute Leftover Food(' . $selectedBazaar . ')') selected @endif>
                                Distribute Leftover Food</option>

                        </select>
                        @error('dutyType')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div>
                        <x-input-label for="bazaarName" :value="__('Assign Bazaar')" />
                        <select name="bazaarName" class="form-input" id="bazaarName">
                            <option value="">Select Bazaar</option>
                            @foreach ($bazaarNames as $bazaarName)
                                <option value="{{ $bazaarName }}" @if ($selectedBazaar == $bazaarName) selected @endif>
                                    {{ $bazaarName }}</option>
                            @endforeach
                        </select>
                        @error('bazaarName')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div id="searchAddressContainer" style="display: none;">
                        <x-input-label for="searchAddress" :value="__('Search Address')" />
                        <x-text-input id="searchAddress" name="searchAddress" type="text"
                            placeholder="Enter an address" class="mt-1 block w-full"  />
                        <small>Search for the address then pinpoint the location on the map.</small>
                    </div>

                    <div id="dutyLocationContainer" style="display: none;">
                        <x-input-label for="dutyLocation" :value="__('Duty Location')" />
                        <div id="map" style="height: 300px; width: 100%"></div>
                        <x-text-input id="dutyLocation" name="dutyLocation" type="text" readonly required
                            class="mt-1 block w-full"  />
                    </div>

                    <div>
                        <x-input-label for="dutyRemarks" :value="__('Duty Remarks')" />
                        <x-text-input id="dutyRemarks" name="dutyRemarks" type="text" :value="$selectedDutyRemarks" autofocus
                            class="mt-1 block w-full" />
                        @if ($errors->has('dutyRemarks'))
                            <x-input-error :message="$errors->first('dutyRemarks')" />
                        @endif
                    </div>

                    <div class="flex justify-left">
                        @if (session('error'))
                            <div class="alert alert-danger" style="color: red;">
                                {{ session('error') }}
                            </div>
                        @elseif (session('success'))
                            <div class="alert alert-success" style="color: green;">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Edit Duty') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDPbMuytqlLTjfYSqgt_zDqGKO1bXVU0bc&libraries=places&callback=initMap"
        async defer></script>
    <script>
        var map;
        var marker;
        var geocoder;
        var autocomplete;

        function initMap() {
            geocoder = new google.maps.Geocoder();
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const myLatLng = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };

                        map = new google.maps.Map(document.getElementById("map"), {
                            zoom: 15,
                            center: myLatLng,
                        });

                        marker = new google.maps.Marker({
                            position: myLatLng,
                            map: map,
                            title: "Your Location",
                            icon: "https://maps.google.com/mapfiles/ms/icons/red-dot.png",
                            draggable: true
                        });

                        google.maps.event.addListener(marker, 'dragend', function() {
                            geocodePosition(marker.getPosition());
                        });
                    },
                    function(error) {
                        // Handle geolocation error
                        console.log(error.message);
                    }
                );
            } else {
                // Browser doesn't support geolocation
                console.log("Geolocation is not supported by this browser.");
            }

            autocomplete = new google.maps.places.Autocomplete(document.getElementById('searchAddress'));
            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    window.alert('No details available for input: \'' + place.name + '\'');
                    return;
                }
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(15);
                }
                marker.setPosition(place.geometry.location);
                geocodePosition(marker.getPosition());
            });

            map.addListener('click', function(e) {
                marker.setPosition(e.latLng);
                geocodePosition(marker.getPosition());
            });
        }

        function geocodePosition(pos) {
            geocoder.geocode({
                latLng: pos
            }, function(responses) {
                if (responses && responses.length > 0) {
                    var address = responses[0].formatted_address;
                    document.getElementById('dutyLocation').value = address;
                } else {
                    document.getElementById('dutyLocation').value = '';
                }
            });
        }
    </script>
    <script>
        const dutyTypeSelect = document.getElementById('dutyType');
        const searchAddressContainer = document.getElementById('searchAddressContainer');
        const dutyLocationContainer = document.getElementById('dutyLocationContainer');

        // Function to show/hide fields based on the selected duty type
        function handleDutyTypeChange() {
            const selectedDutyType = dutyTypeSelect.value;

            // Show/hide searchAddressContainer and dutyLocationContainer based on duty type
            if (selectedDutyType === 'Distribute Leftover Food') {
                searchAddressContainer.style.display = 'block';
                dutyLocationContainer.style.display = 'block';
            } else {
                searchAddressContainer.style.display = 'none';
                dutyLocationContainer.style.display = 'none';
            }
        }

        // Attach the event listener to the dutyTypeSelect element
        dutyTypeSelect.addEventListener('change', handleDutyTypeChange);

        // Call the handleDutyTypeChange function initially to set the initial visibility
        handleDutyTypeChange();
    </script>


</x-app-layout>
