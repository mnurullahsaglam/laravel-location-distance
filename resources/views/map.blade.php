<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Map') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div id="map" style="height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let map = L.map('map').setView([39.9334, 32.8597], 5);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
            })
                .addTo(map);

            let locations = @json($locations);

            locations.forEach(function (location) {
                let marker = L.circleMarker([location.latitude, location.longitude], {
                    color: location.marker_color,
                    radius: 10
                })
                    .addTo(map);

                marker.bindPopup(location.name);
            });
        });
    </script>
</x-app-layout>
