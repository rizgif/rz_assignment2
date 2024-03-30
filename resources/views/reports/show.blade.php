<!-- resources/views/reports/show.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report for Year ' . $year) }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Expenses Report</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Category
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Expense
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($categorySpending as $category)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $category->category }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        ${{ number_format($category->total_expense, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div id="chartContainer" style="height: 300px; width: 100%;"></div>


                    <!-- Add CanvasJS library -->
                    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                    <script>
                        window.onload = function() {
                            var chart = new CanvasJS.Chart("chartContainer", {
                                animationEnabled: true,
                                title: {
                                    text: "Expenses by Category"
                                },
                                data: [{
                                    type: "pie",
                                    startAngle: 240,
                                    yValueFormatString: "##0.00\"\"",
                                    indexLabel: "{label} {y}",
                                    dataPoints: @json($chartData)
                                }]
                            });
                            chart.render();
                        };
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
