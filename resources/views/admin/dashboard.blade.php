<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-blue-500 text-white p-4 rounded-lg shadow">
                    <div class="font-bold text-lg">Total Uploads</div>
                    <div class="mt-2 text-3xl">{{ $totalUploads }}</div>
                </div>
                <div class="bg-green-500 text-white p-4 rounded-lg shadow">
                    <div class="font-bold text-lg">New Users</div>
                    <div class="mt-2 text-3xl">{{ $newUsers }}</div>
                </div>
                <div class="bg-yellow-500 text-white p-4 rounded-lg shadow">
                    <div class="font-bold text-lg">Total Views</div>
                    <div class="mt-2 text-3xl">{{ $totalViews }}</div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <canvas id="uploadChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('uploadChart').getContext('2d');
        const uploadChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Uploads Over Time',
                    data: {!! json_encode($chartData) !!},
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</x-app-layout>
