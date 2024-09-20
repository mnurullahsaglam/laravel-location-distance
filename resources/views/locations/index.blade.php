<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Projects') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('locations.create') }}" class="underline">Add new location</a>

                    <table class="min-w-full divide-y divide-gray-200 border mt-4">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left">
                                <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Name') }}
                                </span>
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left">
                                <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Latitude') }}
                                </span>
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left">
                                <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Longitude') }}
                                </span>
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left">
                                <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Marker Color') }}
                                </span>
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left">
                                <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Actions') }}
                                </span>
                            </th>
                        </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                        @foreach($locations as $location)
                            <tr class="bg-white">
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    {{ $location->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    {{ $location->latitude }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    {{ $location->longitude }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    {{ $location->marker_color }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    <a href="{{ route('locations.edit', $location) }}" class="underline">Edit</a>
                                        |
                                        <form action="{{ route('locations.destroy', $location) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure?');"
                                              class="inline-block">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="text-red-500 underline">Delete</button>
                                        </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $locations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
