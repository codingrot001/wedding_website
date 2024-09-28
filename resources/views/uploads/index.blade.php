<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Uploads') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container mx-auto">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-500 text-white rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                    <thead>
                        <tr class="w-full bg-gray-200 text-gray-700">
                            <th class="py-3 px-4 text-left">File Name</th>
                            <th class="py-3 px-4 text-left">File Path</th>
                            <th class="py-3 px-4 text-left">File Type</th>
                            <th class="py-3 px-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($uploads as $upload)
                            <tr class="border-b hover:bg-gray-100">
                                <td class="py-3 px-4">{{ $upload->file_name }}</td>
                                <td class="py-3 px-4">{{ $upload->file_path }}</td>
                                <td class="py-3 px-4">{{ $upload->file_type }}</td>
                                <td class="py-3 px-4">
                                    <form action="{{ route('admin.uploads.destroy', $upload->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
