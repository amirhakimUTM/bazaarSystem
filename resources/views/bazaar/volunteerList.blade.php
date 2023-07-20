<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Volunteer List') }}
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
                /* margin-bottom: 5px; */
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                z-index: 1;
                position: relative;
                margin-top: 0;
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
                @if ($userRole !== 'bazaar_leader')
                    <!-- Only show the filter for non-bazaar_leader users -->
                    <div class="flex justify-center mb-6">
                        <select id="bazaarFilter">
                            <option value="">All</option>
                            @foreach ($bazaars as $bazaar)
                                <option value="{{ $bazaar->bazaarName }}">{{ $bazaar->bazaarName }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div class="flex justify-center">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Telephone Number</th>
                                <th>Address</th>
                                <th>Date of Birth</th>
                                <th>Volunteered Bazaar</th>
                                <th>Assign Duty</th>
                                @if ($userRole === 'admin')
                                    <!-- Check the user's role -->
                                    <th>Delete</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->telNo }}</td>
                                    <td>{{ $user->address }}</td>
                                    <td>{{ $user->dateOfBirth }}</td>
                                    <td>{{ $user->bazaarName }}</td>
                                    <td>
                                        <select class="duty-select" data-user-id="{{ $user->id }}">
                                            <option value="">Select Duty</option>
                                            @if ($user->bazaarName)
                                                @php
                                                    $duties = \App\Models\Duty::where('bazaarName', $user->bazaarName)->get();
                                                @endphp
                                                @foreach ($duties as $duty)
                                                    <option value="{{ $duty->dutyName }}"
                                                        {{ $duty->dutyName == $user->dutyName ? 'selected' : '' }}>
                                                        {{ $duty->dutyName }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </td>
                                    @if ($userRole === 'admin')
                                        <!-- Check the user's role -->
                                        <td>
                                            <form action="{{ route('bazaar.deleteVolunteer', $user->name) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add event listener to the filter dropdown
        const bazaarFilterSelect = document.getElementById('bazaarFilter');
        bazaarFilterSelect.addEventListener('change', filterTable);

        function filterTable() {
            const filterValue = bazaarFilterSelect.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const bazaarName = row.querySelector('td:nth-child(6)').textContent.toLowerCase();
                if (filterValue === '' || bazaarName === filterValue) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        $(document).ready(function() {
            // Store the initial dutyName value for each user
            var initialDutyNames = {};

            // Iterate over each duty-select element
            $('.duty-select').each(function() {
                var userId = $(this).data('user-id');
                var initialDutyName = $(this).val();

                // Store the initial dutyName value in the initialDutyNames object
                initialDutyNames[userId] = initialDutyName;
            });

            // Event listener for duty-select change
            $('.duty-select').on('change', function() {
                var userId = $(this).data('user-id');
                var dutyName = $(this).val();

                // Make an AJAX request to update the dutyName for the user
                saveAssignedDuty(userId, dutyName);
            });

            function saveAssignedDuty(userId, dutyName) {
                axios.post('/bazaar/assignDuty', {
                        userId: userId,
                        dutyName: dutyName
                    })
                    .then(response => {
                        console.log(response.data);
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        });
    </script>

</x-app-layout>
