@extends('admin.layout')

@section('title', 'Create Product')
@section('page-title', 'Create Product')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Product Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                </div>

                <div class="col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Short Description</label>
                    <input type="text" name="short_description" value="{{ old('short_description') }}" maxlength="255"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                    <select name="category_id" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Brand</label>
                    <input type="text" name="brand" value="{{ old('brand') }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Base Price</label>
                    <input type="number" step="0.01" name="base_price" value="{{ old('base_price') }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Gender</label>
                    <select name="gender" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                        <option value="">Select Gender</option>
                        <option value="men" {{ old('gender') == 'men' ? 'selected' : '' }}>Men</option>
                        <option value="women" {{ old('gender') == 'women' ? 'selected' : '' }}>Women</option>
                        <option value="kids" {{ old('gender') == 'kids' ? 'selected' : '' }}>Kids</option>
                        <option value="unisex" {{ old('gender') == 'unisex' ? 'selected' : '' }}>Unisex</option>
                    </select>
                </div>

                <div class="col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <div id="description-editor" class="bg-white border border-gray-300 rounded min-h-[200px] mb-4"></div>
                    <textarea name="description" id="description-input" class="hidden">{!! old('description') !!}</textarea>
                </div>

                <div class="mt-14">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div>
                    <label class="flex items-center mt-8">
                        <input type="checkbox" name="is_custom" value="1" {{ old('is_custom') ? 'checked' : '' }} 
                            class="mr-2">
                        <span class="text-gray-700 text-sm font-bold">Is Custom Product</span>
                    </label>
                </div>
            </div>

            <div class="flex space-x-4 mt-6">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Create Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css">
    <style>
        #description-editor { min-height: 260px; margin-bottom: 1rem; }
        #description-editor.ql-container { min-height: 200px; }
        #description-editor .ql-editor { min-height: 160px; }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('description-input');
            const quill = new Quill('#description-editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ header: [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ color: [] }, { background: [] }],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['blockquote', 'code-block'],
                        ['link', 'image'],
                        ['clean']
                    ]
                }
            });

            if (input.value) {
                quill.root.innerHTML = input.value;
            }

            quill.on('text-change', function () {
                input.value = quill.root.innerHTML;
            });
        });
    </script>
@endpush
