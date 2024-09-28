<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container mx-auto">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-500 text-white rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-500 text-white rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">General Settings</h3>
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="site_name" class="block text-sm font-medium text-gray-700">Site Name</label>
                        <input type="text" id="site_name" name="site_name" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" 
                               value="{{ $settings->site_name ?? 'Default Site Name' }}">
                    </div>

                    <div class="mb-4">
                        <label for="site_description" class="block text-sm font-medium text-gray-700">Site Description</label>
                        <textarea id="site_description" name="site_description" 
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">{{ $settings->site_description ?? 'Default Description' }}</textarea>
                    </div>

                    @for ($i = 1; $i <= 3; $i++)
                        <div class="mb-4">
                            <label for="background_image_{{ $i }}" class="block text-sm font-medium text-gray-700">Background Image {{ $i }}</label>
                            <input type="file" id="background_image_{{ $i }}" name="background_image_{{ $i }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                        </div>
                    @endfor

                    <button type="submit" class="mt-4 bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition duration-200">
                        Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
