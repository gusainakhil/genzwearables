@extends('admin.layout')

@section('title', 'Sizes')
@section('page-title', 'Sizes')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Add New Size</h3>
        <form action="{{ route('admin.sizes.store') }}" method="POST" class="mb-6">
            @csrf
            <div class="flex space-x-4">
                <div class="flex-1">
                    <input type="text" name="name" placeholder="Size name (e.g., S, M, L, XL)" 
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i>Add Size
                </button>
            </div>
        </form>

        <h3 class="text-lg font-semibold mb-4">All Sizes</h3>
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($sizes as $size)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $size->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $size->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <form action="{{ route('admin.sizes.destroy', $size) }}" method="POST" class="inline" onsubmit="return confirm('Delete this size?')">
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
                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">No sizes found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
