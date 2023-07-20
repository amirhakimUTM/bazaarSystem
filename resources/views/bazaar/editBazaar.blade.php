<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Leftover Food Collection Center') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 bg-white shadow sm:rounded-lg">
{{-- 
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Profile Information') }}
                    </h2>
            
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("Update your account's profile information and email address.") }}
                    </p>
                </header> --}}

                <form class="mt-6 space-y-6" method="POST" action="{{ route('bazaar.update', $bazaar->bazaarName) }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" :value="__('Leftover Food Collection Center Name')" />
                        <x-text-input id="bazaarName" name="bazaarName" type="text" :value="old('bazaarName',$bazaar->bazaarName)" required autofocus
                            class="mt-1 block w-full" />
                        @if ($errors->has('bazaarName'))
                            <x-input-error :message="$errors->first('bazaarName')" />
                        @endif
                    </div>

                    <div>
                        <x-input-label for="volunteerLimit" :value="__('Volunteer Limit')" />
                        <x-text-input id="volunteerLimit" type="number" name="volunteerLimit" :value="old('volunteerLimit',$bazaar->volunteerLimit)"
                            required class="mt-1 block w-full" />
                        @if ($errors->has('volunteerLimit'))
                            <x-input-error :message="$errors->first('volunteerLimit')" />
                        @endif
                    </div>

                    <div>
                        <x-input-label for="searchAddress" :value="__('Search Address')" />
                        <x-text-input id="searchAddress" name="searchAddress" type="text" placeholder="Enter an address"
                            class="mt-1 block w-full" />
                        <small>Search for the address then pinpoint the location on the map.</small>
                    </div>

                    <div>
                        <x-input-label for="bazaarAddress" :value="__('Bazaar Address')" />
                        <div id="map" style="height: 300px; width: 100%"></div>
                        <x-text-input id="bazaarAddress" name="bazaarAddress" type="text" readonly :value="old('bazaarAddress',$bazaar->bazaarAddress)" required
                            class="mt-1 block w-full" />
                    </div>

                    <div>
                        <input type="hidden" name="bazaarLeader" value=null>
                    </div>

                    <div class="flex items-center gap-4 mb-6">
                        <x-primary-button>{{ __('Save Leftover Food Collection Center') }}</x-primary-button>
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
                    document.getElementById('bazaarAddress').value = address;
                } else {
                    document.getElementById('bazaarAddress').value = '';
                }
            });
        }
    </script>
</x-app-layout>
