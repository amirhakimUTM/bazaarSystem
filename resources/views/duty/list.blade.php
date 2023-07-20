<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Duty List') }}
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
                background-color: #5b9dd9;
                font-weight: bold;
                color: rgb(14, 1, 1);
            }
        </style>
    </x-slot>
    <div class="py-12">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 bg-white shadow sm:rounded-lg">
                <div class="flex justify-center mb-6">
                    <select id="bazaarFilter">
                        <option value="">All</option>
                        @foreach ($bazaars as $bazaar)
                            <option value="{{ $bazaar->bazaarName }}">{{ $bazaar->bazaarName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-center">
                    <table>
                        <thead>
                            <tr>
                                <th>Duty Name</th>
                                <th>Bazaar Name</th>
                                <th>Duty Remarks (If Any)</th>
                                <th>Duty Location (If Needed)</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($duties as $duty)
                                <tr>
                                    <td>{{ $duty->dutyName }}</td>
                                    <td>{{ $duty->bazaarName }}</td>
                                    <td>{{ $duty->dutyRemarks }}</td>
                                    <td>{{ $duty->dutyLocation }}</td>
                                    <td>
                                        <a href="{{ route('duty.edit', $duty->id) }}" class="btn">Edit</a>
                                        <form action="{{ route('duty.destroy', $duty->id) }}" method="POST"
                                            style="display: inline-block;">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-center">
                    <a href="{{ route('duty.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Add New Duty
                    </a>
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
                const bazaarName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                if (filterValue === '' || bazaarName === filterValue) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>

</x-app-layout>
