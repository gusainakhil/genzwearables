@extends('admin.layout')

@section('title', 'Colors')
@section('page-title', 'Colors')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Add New Color</h3>
        <form action="{{ route('admin.colors.store') }}" method="POST" class="mb-6">
            @csrf
            <div class="flex space-x-4">
                <div class="flex-1">
                    <input type="text" name="name" placeholder="Color name (e.g., Red, Blue)" 
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                </div>
                <div class="w-32">
                    <input type="text" name="hex_code" placeholder="#000000" 
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                </div>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i>Add Color
                </button>
            </div>
        </form>

        <h3 class="text-lg font-semibold mb-4">All Colors</h3>
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Color</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hex Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($colors as $color)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $color->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center">
                            @if($color->hex_code)
                                <span class="w-6 h-6 rounded-full border mr-2" style="background-color: {{ $color->hex_code }}"></span>
                            @endif
                            <span class="font-medium">{{ $color->name }}</span>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $color->hex_code ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <form action="{{ route('admin.colors.destroy', $color) }}" method="POST" class="inline" onsubmit="return confirm('Delete this color?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">No colors found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
