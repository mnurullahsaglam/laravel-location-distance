<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Location') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto p-6 bg-white border-b border-gray-200">

                    <form method="POST" action="{{ route('locations.store') }}">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input
                                id="name"
                                class="block mt-1 w-full"
                                type="text"
                                name="name"
                                :value="old('name')"
                                minlength="3"
                                maxlength="255"
                                required
                            />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="flex space-x-4 mt-4">
                            <div class="w-1/3 relative">
                                <div class="flex items-center">
                                    <x-input-label for="latitude" :value="__('Latitude')" />
                                    <span class="group inline-block ml-1 text-blue-500 cursor-pointer">
                                        ?
                                        <span class="absolute hidden group-hover:block p-2 text-xs text-gray-800 bg-gray-200 rounded-md shadow-lg w-40">
                                            Range: -90 to 90
                                        </span>
                                    </span>
                                </div>
                                <x-text-input
                                    id="latitude"
                                    class="block mt-1 w-full"
                                    type="number"
                                    name="latitude"
                                    :value="old('latitude')"
                                    min="-90"
                                    max="90"
                                    step="0.000001"
                                    required
                                />
                                <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
                            </div>

                            <div class="w-1/3 relative">
                                <div class="flex items-center">
                                    <x-input-label for="longitude" :value="__('Longitude')" />
                                    <span class="group inline-block ml-1 text-blue-500 cursor-pointer">
                                        ?
                                        <span class="absolute hidden group-hover:block p-2 text-xs text-gray-800 bg-gray-200 rounded-md shadow-lg w-40">
                                            Range: -180 to 180
                                        </span>
                                    </span>
                                </div>
                                <x-text-input
                                    id="longitude"
                                    class="block mt-1 w-full"
                                    type="number"
                                    name="longitude"
                                    :value="old('longitude')"
                                    min="-180"
                                    max="180"
                                    step="0.000001"
                                    required
                                />
                                <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
                            </div>

                            <div class="w-1/3 relative">
                                <div class="flex items-center">
                                    <x-input-label for="marker_color" :value="__('Marker Color')" />
                                    <span class="group inline-block ml-1 text-blue-500 cursor-pointer">
                                        ?
                                        <span class="absolute hidden group-hover:block p-2 text-xs text-gray-800 bg-gray-200 rounded-md shadow-lg w-40">
                                            The color you want the marker on the map
                                        </span>
                                    </span>
                                </div>
                                <x-text-input
                                    id="marker_color"
                                    class="block mt-1 w-full"
                                    type="color"
                                    name="marker_color"
                                    :value="old('marker_color')"
                                    required
                                />
                                <x-input-error :messages="$errors->get('marker_color')" class="mt-2" />
                            </div>
                        </div>

                        <x-primary-button class="mt-4">
                            {{ __('Save') }}
                        </x-primary-button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
