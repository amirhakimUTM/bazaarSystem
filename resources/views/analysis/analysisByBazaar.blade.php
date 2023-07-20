<x-app2-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Analysis By Bazaar') }}
        </h2>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    </x-slot>

    <style>
        .w-1/2-custom {
            width: 50%;
        }

        .chart-canvas {
            height: 400px;
            width: 100%;
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

        .filter button {
            background-color: #2a7cbe;
            color: white;
            border-radius: 4px;
        }

        .filter button:hover {
            background-color: #bc8e62;
            color: white;
            border-radius: 4px;
        }

        .filter select {
            background-color: #0563af;
            color: white;
            padding: 5px;
            text-align: center;
            width: 250px;
            border: none;
            font-size: 13px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
            -webkit-appearance: button;
            appearance: button;
            outline: none;
            margin-bottom: 5px;
        }

        .filter select option {
            padding: 30px;
        }

        ul.ks-cboxtags {
            list-style: none;
            padding: 10px;
        }

        ul.ks-cboxtags li {
            display: inline;
        }

        ul.ks-cboxtags li label {
            display: inline-block;
            background-color: rgba(255, 255, 255, .9);
            border: 2px solid rgba(139, 139, 139, .3);
            color: #adadad;
            font-size: 13px;
            border-radius: 25px;
            white-space: nowrap;
            margin: 3px 0px;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            -webkit-tap-highlight-color: transparent;
            transition: all .2s;
        }

        ul.ks-cboxtags li label {
            padding: 8px 12px;
            cursor: pointer;
        }

        ul.ks-cboxtags li label::before {
            display: inline-block;
            font-style: normal;
            font-variant: normal;
            text-rendering: auto;
            -webkit-font-smoothing: antialiased;
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            font-size: 12px;
            padding: 2px 6px 2px 2px;
            content: "\f067";
            transition: transform .3s ease-in-out;
        }

        ul.ks-cboxtags li input[type="checkbox"]:checked+label::before {
            content: "\f00c";
            transform: rotate(-360deg);
            transition: transform .3s ease-in-out;
        }

        ul.ks-cboxtags li input[type="checkbox"]:checked+label {
            border: 2px solid #0563af;
            background-color: #5b9dd9;
            color: #fff;
            transition: all .2s;
        }

        ul.ks-cboxtags li input[type="checkbox"] {
            display: absolute;
        }

        ul.ks-cboxtags li input[type="checkbox"] {
            position: absolute;
            opacity: 0;
        }

        ul.ks-cboxtags li input[type="checkbox"]:focus+label {
            border: 2px solid #e9a1ff;
        }
    </style>

    <div class="flex justify-center items-center">
        <div class="py-12">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 space-y-6">
                {{-- <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg"> --}}
                {{-- <div class="flex justify-center"> --}}
                <div class="filter">
                    <form action="{{ route('analysis.analysisByBazaar') }}" method="GET" id="filter-form">
                        <div class="form-group">
                            <ul class="ks-cboxtags">
                                @foreach ($bazaars as $bazaar)
                                    <li>
                                        <input type="checkbox" id="{{ $bazaar }}" name="bazaarName[]"
                                            value="{{ $bazaar }}"
                                            {{ in_array($bazaar, $selectedBazaar) ? 'checked' : '' }}>
                                        <label for="{{ $bazaar }}">{{ $bazaar }}</label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="form-group">
                            {{-- <label for="year">Year:</label> --}}
                            <select name="year" id="year" class="form-control">
                                @foreach ($years as $yearOption)
                                    <option value="{{ $yearOption }}"
                                        {{ $selectedYear == $yearOption ? 'selected' : '' }}>
                                        {{ $yearOption }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Charts</button>
                        </div>
                    </form>
                </div>
                {{-- </div> --}}
                {{-- </div> --}}
            </div>
        </div>
    </div>

    <div class="flex justify-center items-center">
        <div class="py-12 w-1/2-custom">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center" style="min-height: 5rem; min-width:10rem;">
                        <span class="text-xl font-bold">
                            <canvas id="lineChart1" class="chart-canvas"></canvas>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-12 w-1/2-custom">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center" style="min-height: 10rem; min-width:10rem;">
                        <span class="text-xl font-bold">
                            <canvas id="barChart1" class="chart-canvas"></canvas>
                        </span>
                    </div>
                </div>
            </div>
        </div>


    </div>

    {{-- <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="flex justify-center">
                        <div class="linechart-container">
                            <canvas id="lineChart1" style="width: 120%; height: 400px;"></canvas>
                        </div>
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="flex justify-center">
                        <div class="bar-chart-container">
                            <canvas id="barChart1" style="width: 120%; height: 400px;"></canvas>
                        </div>
                    </div>
                </div> --}}

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var lineChartCtx = document.getElementById('lineChart1').getContext('2d');
            var barChartCtx = document.getElementById('barChart1').getContext('2d');

            // Get the last 30 days of data
            var last30DaysData = {!! json_encode(
                $foodWeights->groupBy('day')->take(30)->values(),
            ) !!};

            // Generate an array of random colors
            var randomColors = generateRandomColors({{ count($selectedBazaar) }});

            var lineChartDatasets = [
                @foreach ($selectedBazaar as $index => $bazaar)
                    {
                        label: '{{ $bazaar }}',
                        data: {!! json_encode(
                            $foodWeights->where('bazaarName', $bazaar)->pluck('weight')->take(30),
                        ) !!},
                        backgroundColor: randomColors[{{ $index }}],
                        borderColor: randomColors[{{ $index }}],
                        borderWidth: 2,
                        type: 'line',
                        yAxisID: 'y',
                    },
                @endforeach
            ];

            var barChartDatasets = [{
                label: 'Total Weight',
                data: {!! json_encode($bazaarWeights->values()) !!},
                backgroundColor: randomColors,
                borderWidth: 1,
                // yAxisID: 'y1',
            }];

            var chartData = {
                labels: {!! json_encode(range(1, 30)) !!},
                datasets: lineChartDatasets
            };

            var chartOptions = {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Day'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Food Weight (kg)'
                        }
                    },
                },
                plugins: {
                    legend: {
                        labels: {
                            display: false // Change the legend label color if needed
                        }
                    },
                    title: {
                        display: true,
                        text: 'Food Weight Analysis',
                        color: 'rgba(0, 0, 0, 1)' // Change the title color if needed
                    },
                    tooltip: {
                        borderWidth: 1, // Change the tooltip border width
                        titleColor: 'rgba(39, 131, 245, 0.8)', // Change the tooltip title color
                        bodyColor: 'rgba(255, 255, 255, 0.8)', // Change the tooltip body color
                        footerColor: 'rgba(0, 0, 0, 1)' // Change the tooltip footer color
                    },
                    // Add other plugin options if needed
                },
                interaction: {
                    intersect: false,
                },
                maintainAspectRatio: true,
                responsive: true,
                layout: {
                    padding: 10 // Adjust the padding if needed
                },
                elements: {
                    line: {
                        tension: 0.01 // Adjust the tension value if needed
                    },
                    point: {
                        radius: 1, // Set the point radius to 0 to hide the points
                        hitRadius: 5, // Adjust the hit radius if needed
                        hoverRadius: 5 // Adjust the hover radius if needed
                    }
                }
            };

            var lineChart = new Chart(lineChartCtx, {
                type: 'line',
                data: chartData,
                options: chartOptions
            });

            var barChartData = {
                labels: {!! json_encode($selectedBazaar) !!},
                datasets: barChartDatasets
            };

            var barChartOptions = {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Bazaars'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Total Weight (kg)'
                        }
                    },
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Total Food Weight',
                        color: 'rgba(0, 0, 0, 1)' // Change the title color if needed
                    },
                    tooltip: {
                        borderWidth: 1, // Change the tooltip border width
                        titleColor: 'rgba(39, 131, 245, 0.8)', // Change the tooltip title color
                        bodyColor: 'rgba(255, 255, 255, 0.8)', // Change the tooltip body color
                        footerColor: 'rgba(0, 0, 0, 1)' // Change the tooltip footer color
                    },
                    // Add other plugin options if needed
                },
                maintainAspectRatio: true,
                responsive: true,
                layout: {
                    padding: 10 // Adjust the padding if needed
                },
            };


            var barChart = new Chart(barChartCtx, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            });

            function generateRandomColors(count) {
                var colors = [];
                for (var i = 0; i < count; i++) {
                    var color = 'rgba(' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) +
                        ', ' + Math.floor(Math.random() * 256) + ', 0.5)';
                    colors.push(color);
                }
                return colors;
            }
        });
    </script>
</x-app-layout>
