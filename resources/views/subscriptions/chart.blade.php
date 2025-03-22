<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="border-pink overflow-hidden pink-shadow sm:rounded-lg p-3 lg:p-14">

                <div class="flex justify-end pb-4">
                    <a href="{{ route('subscriptions.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6 hover:text-gray-600">
                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                        </svg>
                    </a>
                </div>


                <div class="container">
                    <h2>サブスクリプション料金チャート</h2>
                    <canvas id="subscriptionChart"></canvas>
                </div>

                <script>
                document.addEventListener("DOMContentLoaded", function () {
                    fetch("{{ url('/subscriptions/chart-data') }}")
                        .then(response => response.json())
                        .then(data => {
                            const ctx = document.getElementById("subscriptionChart").getContext("2d");
                            new Chart(ctx, {
                                type: "bar",
                                data: {
                                    labels: data.labels,
                                    datasets: [{
                                        label: "サブスク料金 (円)",
                                        data: data.data,
                                        backgroundColor: "rgba(54, 162, 235, 0.6)"
                                    }]
                                }
                            });
                        });
                });
                </script>



            </div>
        </div>
    </div>

</x-app-layout>
