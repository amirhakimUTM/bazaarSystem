<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Leftover Food Weight List') }}
        </h2>
        <style>
            table {
                margin-bottom: 20px;
                border: 1px solid black;
                border-collapse: collapse;
                border-spacing: 0;
            }

            thead tr th,
            td {
                text-align: center;
                padding: 8px;
                border: 1px solid black;
                border-collapse: collapse;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2
            }

            thead tr th {
                background-color: #5b9dd9;
                color: white;
            }

            thead {
                width: auto;
            }

            tbody {
                width: auto;
            }

            .filter {
                margin-bottom: 20px;
                z-index: 1;
                position: relative;
                margin-top: 10px;
                border: none;
            }

            .filter table {
                color: #2a7cbe;
                border-collapse: collapse;
                border: none;
            }

            .filter thead tr th,
            .filter td {
                padding: 5px;
                text-align: center;
                padding: 8px;
                border: none;
                border-collapse: collapse;
            }

            .filter label {
                display: block;
                margin-bottom: 5px;
            }

            .filter select,
            .filter button {
                padding: 5px 10px;
                border: 1px solid #ccc;
                border-radius: 3px;
            }

            /* button {
                background-color: #2a7cbe;
                color: white;
                border-radius: 4px;
            }

            button:hover {
                background-color: #bc8e62;
                color: white;
                border-radius: 4px;
            } */

            .filter select {
                background-color: #0563af;
                color: white;
                padding: 12px;
                width: 250px;
                border: none;
                font-size: 20px;
                box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
                /* -webkit-appearance: button;
                appearance: button; */
                outline: none;
            }

            .filter select option {
                padding: 30px;
            }


            .btn {
                display: inline-block;
                padding: 10px 20px;
                background-color: #5b9dd9;
                font-size: 17px;
                border: none;
                border-radius: 5px;
                color: #bcf5e7;
                cursor: pointer;
                color: rgb(255, 255, 255);
            }

            .btn:hover {
                background-color: #5b9dd9;
                font-weight: bold;
                color: rgb(14, 1, 1);
            }
        </style>
    </x-slot>
    <div class="py-12">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 bg-white shadow sm:rounded-lg">
                <div class="flex justify-center">
                    <div class="filter">
                        <table>
                            <tr>
                                <td>
                                    <label for="year">Year:</label>
                                </td>
                                <td>
                                    <select name="year" id="year" class="round" onchange="filterChanged()">
                                        <option value="">Select Year</option>
                                        @foreach ($years as $year)
                                            <option value="{{ $year }}"
                                                {{ $year == $selectedYear ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <label for="bazaarName">Bazaar Name:</label>
                                </td>
                                <td>
                                    @if ($userRole === 'bazaar_leader') <!-- Only show the bazaarName for bazaar_leader users -->
                                        <select name="bazaarName" id="bazaarName" class="round" onchange="filterChanged()">
                                            <option value="{{ $selectedBazaar }}">{{ $selectedBazaar }}</option>
                                        </select>
                                    @else
                                        <select name="bazaarName" id="bazaarName" class="round" onchange="filterChanged()">
                                            <option value="">Select Bazaar</option>
                                            @foreach ($bazaars as $bazaar)
                                                <option value="{{ $bazaar }}"
                                                    {{ $bazaar == $selectedBazaar ? 'selected' : '' }}>
                                                    {{ $bazaar }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                </div>
                <div class="flex justify-center">
                    <table>
                        <thead>
                            <tr>
                                <th>Day</th>
                                <th>Weight</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < 30; $i++)
                                @if ($i >= 0 && $i < 10)
                                    @php
                                        $range = 1;
                                    @endphp
                                @elseif ($i >= 10 && $i < 20)
                                    @php
                                        $range = 2;
                                    @endphp
                                @elseif ($i >= 20 && $i < 30)
                                    @php
                                        $range = 3;
                                    @endphp
                                @endif
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>
                                        @php
                                            $foodWeight = $foodWeights->firstWhere('day', $i + 1);
                                        @endphp
                                        @if ($foodWeight)
                                            <form action="{{ route('foodweights.update', $foodWeight) }}"
                                                method="post">
                                                @method('put')
                                                @csrf
                                                <input type="number" name="weight" value="{{ $foodWeight->weight }}" step="any">
                                                <button class="btn" type="submit">Update</button>
                                            </form>
                                        @else
                                            <form action="{{ route('foodweights.store') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="bazaarName" value="{{ $selectedBazaar }}">
                                                <input type="hidden" name="year" value="{{ $selectedYear }}">
                                                <input type="hidden" name="day" value="{{ $i + 1 }}">
                                                <input type="number" name="weight" placeholder="Enter weight (kg)" step="any">
                                                <button class="btn" type="submit">Add</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @if (($i + 1) % 10 == 0)
                        </tbody>
                    </table>
                    @if ($range < 3)
                        <div style="margin-right: 20px;"></div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>Weight</th>
                                </tr>
                            </thead>
                            <tbody>
                    @endif
                    @endif
                    @endfor
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterChanged() {
            var selectedYear = document.getElementById('year').value;
            var selectedBazaar = document.getElementById('bazaarName').value;
            var url = '{{ route('foodweights.foodWeightList') }}?year=' + selectedYear + '&bazaarName=' + selectedBazaar;
            window.location.href = url;
        }
    </script>


</x-app-layout>
