@extends('admin.layout')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')

@section('content')
<div class="max-w-6xl">
    <!-- Product Details -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Product Details</h3>
        <form action="{{ route('admin.products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Product Name</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                    <select name="category_id" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Brand</label>
                    <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Base Price</label>
                    <input type="number" step="0.01" name="base_price" value="{{ old('base_price', $product->base_price) }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Gender</label>
                    <select name="gender" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                        <option value="">Select Gender</option>
                        <option value="men" {{ old('gender', $product->gender) == 'men' ? 'selected' : '' }}>Men</option>
                        <option value="women" {{ old('gender', $product->gender) == 'women' ? 'selected' : '' }}>Women</option>
                        <option value="kids" {{ old('gender', $product->gender) == 'kids' ? 'selected' : '' }}>Kids</option>
                        <option value="unisex" {{ old('gender', $product->gender) == 'unisex' ? 'selected' : '' }}>Unisex</option>
                    </select>
                </div>

                <div class="col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea name="description" rows="4" 
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">{{ old('description', $product->description) }}</textarea>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                        <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div>
                    <label class="flex items-center mt-8">
                        <input type="checkbox" name="is_custom" value="1" {{ old('is_custom', $product->is_custom) ? 'checked' : '' }} 
                            class="mr-2">
                        <span class="text-gray-700 text-sm font-bold">Is Custom Product</span>
                    </label>
                </div>
            </div>

            <div class="flex space-x-4 mt-6">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Update Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                    Back
                </a>
            </div>
        </form>
    </div>

    <!-- Product Images -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Product Images</h3>
        
        <form action="{{ route('admin.products.images.store', $product) }}" method="POST" enctype="multipart/form-data" class="mb-6">
            @csrf
            <div class="flex items-end space-x-4">
                <div class="flex-1">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Add Image</label>
                    <input type="file" name="image" accept="image/*" 
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Upload
                </button>
            </div>
        </form>

        <div class="grid grid-cols-4 gap-4">
            @foreach($product->images as $image)
                <div class="relative border rounded p-2">
                    <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $product->name }}" class="w-full h-32 object-cover rounded">
                    @if($image->is_primary)
                        <span class="absolute top-1 left-1 bg-green-500 text-white text-xs px-2 py-1 rounded">Primary</span>
                    @endif
                    <form action="{{ route('admin.products.images.destroy', $image) }}" method="POST" class="mt-2" onsubmit="return confirm('Delete this image?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 text-white px-3 py-1 text-sm rounded hover:bg-red-700">
                            Delete
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Product Variants -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Product Variants</h3>
        
        <form action="{{ route('admin.products.variants.store', $product) }}" method="POST" class="mb-6 bg-gray-50 p-4 rounded">
            @csrf
            <div class="grid grid-cols-5 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Size</label>
                    <select name="size_id" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                        <option value="">Select</option>
                        @foreach($sizes as $size)
                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Color</label>
                    <select name="color_id" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                        <option value="">Select</option>
                        @foreach($colors as $color)
                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">SKU</label>
                    <input type="text" name="sku" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Price</label>
                    <input type="number" step="0.01" name="price" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Stock</label>
                    <input type="number" name="stock_qty" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Add Variant
                    </button>
                </div>
            </div>
        </form>

        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Size</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Color</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">SKU</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($product->variants as $variant)
                <tr>
                    <td class="px-4 py-3">{{ $variant->size->name }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center">
                            @if($variant->color->hex_code)
                                <span class="w-4 h-4 rounded-full mr-2" style="background-color: {{ $variant->color->hex_code }}"></span>
                            @endif
                            {{ $variant->color->name }}
                        </span>
                    </td>
                    <td class="px-4 py-3">{{ $variant->sku }}</td>
                    <td class="px-4 py-3">₹{{ number_format($variant->price, 2) }}</td>
                    <td class="px-4 py-3">{{ $variant->stock_qty }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 text-xs rounded-full {{ $variant->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($variant->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <form action="{{ route('admin.products.variants.destroy', $variant) }}" method="POST" onsubmit="return confirm('Delete this variant?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
