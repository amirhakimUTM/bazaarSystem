<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Volunteering Page') }}
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
                display: inline-block;
                padding: 10px 20px;
                background-color: #6d9fce;
                font-size: 17px;
                border: none;
                border-radius: 5px;
                color: #bcf5e7;
                cursor: pointer;
                color: rgb(0, 0, 0);
            }
        </style>
    </x-slot>
    <div class="py-12">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 bg-white shadow sm:rounded-lg">
                <div class="flex justify-center">
                    <table class="table border rounded-lg">
                        <thead>
                            <tr>
                                <th>Bazaar Name</th>
                                <th>Bazaar Address</th>
                                <th>Bazaar Leader</th>
                                <th>Bazaar Leader's Tel No</th>
                                <th>Volunteers Vacancy</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bazaars as $bazaar)
                                @php
                                    $bazaarLeader = $bazaar
                                        ->users()
                                        ->where('role', 'bazaar_leader')
                                        ->first();
                                    $volunteerCount = $bazaar
                                        ->users()
                                        ->where('role', 'volunteer')
                                        ->count();
                                @endphp
                                @if ($bazaarLeader)
                                    <tr>
                                        <td>{{ $bazaar->bazaarName }}</td>
                                        <td>{{ $bazaar->bazaarAddress }}</td>
                                        <td>{{ $bazaarLeader->name }}</td>
                                        <td>{{ $bazaarLeader->telNo }}</td>
                                        <td>{{ $volunteerCount }}/{{ $bazaar->volunteerLimit }}</td>
                                        <td>
                                            <form action="{{ route('volunteer.volunteerToBazaar') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="bazaarName" value="{{ $bazaar->bazaarName }}">
                                                <button type="submit" class="btn btn-primary">Volunteer Here</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-center">
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
            </div>
            <div class="p-4 bg-white shadow sm:rounded-lg">
                <div class="flex justify-center">
                    @if (!empty($currentBazaarName) && !empty($currentDutyName))
                        <div style="text-align: center;">
                            Currently, you are volunteering at {{ $currentBazaarName }} with the duty
                            {{ $currentDutyName }}.
                            <br>
                            @if (strpos($currentDutyName, 'Distribut') !== false)
                                @if (!empty($dutyRemarks))
                                    <div style="text-align: center;">
                                        <b> Duty Remarks:</b> {{ $dutyRemarks }}
                                        <br>
                                    </div>
                                @endif
                                @if (!empty($dutyLocation))
                                    <div style="text-align: center; font-weight:">
                                        <b> Duty Location:</b> {{ $dutyLocation }}
                                    </div>
                                @endif
                            @else
                                @if (!empty($dutyRemarks))
                                    <div style="text-align: center;">
                                        <b> Duty Remarks:</b> {{ $dutyRemarks }}
                                    </div>
                                @endif
                            @endif
                        </div>
                    @elseif (!empty($currentBazaarName))
                        Currently, you are volunteering at {{ $currentBazaarName }}, but you have not been assigned any
                        duty yet.
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
