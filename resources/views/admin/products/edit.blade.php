@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col space-y-6">
        <!-- Header with back button -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Product</h1>
                <p class="mt-1 text-sm text-gray-500">Update the details for {{ $product->name }}</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Products
            </a>
        </div>

        @if($errors->any())
        <div class="rounded-md bg-red-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Main Form Card -->
        <div class="bg-white shadow-xl rounded-xl overflow-hidden">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="space-y-8 p-8">
                    <!-- Basic Information Section -->
                    <div class="space-y-6">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Basic Information</h2>
                            <p class="mt-1 text-sm text-gray-500">Essential details about your product</p>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <!-- Product Name -->
                            <div class="sm:col-span-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Product Name <span class="text-red-500">*</span></label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm py-3 px-4 border @error('name') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror" placeholder="e.g. Premium Leather Wallet" required>
                                </div>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div class="sm:col-span-2">
                                <label for="category_id" class="block text-sm font-medium text-gray-700">Category <span class="text-red-500">*</span></label>
                                <div class="mt-1">
                                    <select id="category_id" name="category_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm py-3 px-4 border @error('category_id') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror" required>
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('category_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="sm:col-span-6">
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <div class="mt-1">
                                    <textarea id="description" name="description" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm py-3 px-4 border @error('description') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror" placeholder="Detailed product description">{{ old('description', $product->description) }}</textarea>
                                </div>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Pricing & Inventory Section -->
                    <div class="space-y-6">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Pricing & Inventory</h2>
                            <p class="mt-1 text-sm text-gray-500">Financial and stock details</p>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <!-- Price -->
                            <div class="sm:col-span-2">
                                <label for="price" class="block text-sm font-medium text-gray-700">Price <span class="text-red-500">*</span></label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">₦</span>
                                    </div>
                                    <input type="number" step="0.01" min="0" name="price" id="price" value="{{ old('price', $product->price) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm py-3 px-4 pl-7 border @error('price') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror" placeholder="0.00" required>
                                </div>
                                @error('price')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Discount Price -->
                            <div class="sm:col-span-2">
                                <label for="discount_price" class="block text-sm font-medium text-gray-700">Discount Price</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm"> ₦</span>
                                    </div>
                                    <input type="number" step="0.01" min="0" name="discount_price" id="discount_price" value="{{ old('discount_price', $product->discount_price) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm py-3 px-4 pl-7 border @error('discount_price') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror" placeholder="0.00">
                                </div>
                                @error('discount_price')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Stock -->
                            <div class="sm:col-span-2">
                                <label for="stock" class="block text-sm font-medium text-gray-700">Stock Quantity <span class="text-red-500">*</span></label>
                                <div class="mt-1">
                                    <input type="number" min="0" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm py-3 px-4 border @error('stock') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror" placeholder="0" required>
                                </div>
                                @error('stock')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <div class="mt-2">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                        <span class="ms-3 text-sm font-medium text-gray-700">{{ old('is_active', $product->is_active) ? 'Active' : 'Inactive' }}</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Featured -->
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Featured</label>
                                <div class="mt-2">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="hidden" name="is_featured" value="0">
                                        <input type="checkbox" name="is_featured" value="1" class="sr-only peer" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                        <span class="ms-3 text-sm font-medium text-gray-700">{{ old('is_featured', $product->is_featured) ? 'Yes' : 'No' }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Image Upload Section -->
                    <div class="space-y-6">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Product Image</h2>
                            <p class="mt-1 text-sm text-gray-500">Update the product photo</p>
                        </div>
                        
                        <div class="sm:col-span-6">
                            <div class="flex flex-col sm:flex-row gap-6">
                                <!-- Current Image -->
                                <div class="w-full sm:w-1/3">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                                    @if($product->image_url)
                                        <div class="relative group">
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-48 object-contain rounded-lg border border-gray-200">
                                            <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-lg">
                                                <span class="text-white text-sm font-medium">Current Image</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="h-48 flex items-center justify-center bg-gray-100 rounded-lg border border-gray-200">
                                            <span class="text-gray-500 text-sm">No image uploaded</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- New Image Upload -->
                                <div class="w-full sm:w-2/3">
                                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Change Image</label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                    <span>Upload a file</span>
                                                    <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">
                                                PNG, JPG, GIF up to 2MB
                                            </p>
                                        </div>
                                    </div>
                                    @error('image')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gallery Images Section -->
<!--                     <div class="space-y-6">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Gallery Images</h2>
                            <p class="mt-1 text-sm text-gray-500">Additional product photos</p>
                        </div>
                        
                        <div class="sm:col-span-6">
                            <div class="flex flex-col sm:flex-row gap-6"> -->
                                <!-- Current Gallery Images -->
<!--                                 <div class="w-full sm:w-1/3">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Gallery</label>
                                    @if($product->gallery_images && count(json_decode($product->gallery_images)))
                                        <div class="grid grid-cols-2 gap-2">
                                            @foreach(json_decode($product->gallery_images) as $image)
                                                <div class="relative group">
                                                    <img src="{{ Storage::url($image) }}" alt="Gallery image" class="w-full h-24 object-cover rounded-lg border border-gray-200">
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="h-24 flex items-center justify-center bg-gray-100 rounded-lg border border-gray-200">
                                            <span class="text-gray-500 text-sm">No gallery images</span>
                                        </div>
                                    @endif
                                </div> -->
                                
                                <!-- New Gallery Images Upload -->
<!--                                 <div class="w-full sm:w-2/3">
                                    <label for="gallery_images" class="block text-sm font-medium text-gray-700 mb-2">Update Gallery</label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="gallery_images" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                    <span>Upload files</span>
                                                    <input id="gallery_images" name="gallery_images[]" type="file" class="sr-only" accept="image/*" multiple>
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">
                                                PNG, JPG, GIF up to 2MB each
                                            </p>
                                        </div>
                                    </div>
                                    @error('gallery_images')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    @error('gallery_images.*')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Sizes and Colors Section -->
                    <div class="space-y-6">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Variants</h2>
                            <p class="mt-1 text-sm text-gray-500">Available sizes and colors</p>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <!-- Sizes -->
                            <div class="sm:col-span-3">
                                <label for="sizes" class="block text-sm font-medium text-gray-700">Available Sizes</label>
                                <div class="mt-1">
                                    <select id="sizes" name="sizes[]" multiple class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm py-3 px-4 border @error('sizes') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">
                                        @php
                                            $currentSizes = old('sizes', $product->sizes ?? []);
                                            if (is_string($currentSizes)) {
                                                $currentSizes = json_decode($currentSizes, true) ?? [];
                                            }
                                        @endphp
                                        <option value="XS" {{ in_array('XS', $currentSizes) ? 'selected' : '' }}>XS</option>
                                        <option value="S" {{ in_array('S', $currentSizes) ? 'selected' : '' }}>S</option>
                                        <option value="M" {{ in_array('M', $currentSizes) ? 'selected' : '' }}>M</option>
                                        <option value="L" {{ in_array('L', $currentSizes) ? 'selected' : '' }}>L</option>
                                        <option value="XL" {{ in_array('XL', $currentSizes) ? 'selected' : '' }}>XL</option>
                                        <option value="XXL" {{ in_array('XXL', $currentSizes) ? 'selected' : '' }}>XXL</option>
                                    </select>
                                </div>
                                @error('sizes')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Colors -->
                            <div class="sm:col-span-3">
                                <label for="colors" class="block text-sm font-medium text-gray-700">Available Colors</label>
                                <div class="mt-1">
                                    <select id="colors" name="colors[]" multiple class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm py-3 px-4 border @error('colors') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">
                                        @php
                                            $currentColors = old('colors', $product->colors ?? []);
                                            if (is_string($currentColors)) {
                                                $currentColors = json_decode($currentColors, true) ?? [];
                                            }
                                        @endphp
                                        <option value="Red" {{ in_array('Red', $currentColors) ? 'selected' : '' }}>Red</option>
                                        <option value="Blue" {{ in_array('Blue', $currentColors) ? 'selected' : '' }}>Blue</option>
                                        <option value="Green" {{ in_array('Green', $currentColors) ? 'selected' : '' }}>Green</option>
                                        <option value="Black" {{ in_array('Black', $currentColors) ? 'selected' : '' }}>Black</option>
                                        <option value="White" {{ in_array('White', $currentColors) ? 'selected' : '' }}>White</option>
                                        <option value="Yellow" {{ in_array('Yellow', $currentColors) ? 'selected' : '' }}>Yellow</option>
                                    </select>
                                </div>
                                @error('colors')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="px-8 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize Select2 for multiple select elements
    $(document).ready(function() {
        $('#sizes, #colors').select2({
            placeholder: "Select options",
            allowClear: true,
            width: '100%'
        });

        // Toggle switch for status
        document.querySelector('input[name="is_active"]').addEventListener('change', function(e) {
            const statusText = e.target.closest('label').querySelector('span:last-child');
            statusText.textContent = e.target.checked ? 'Active' : 'Inactive';
        });

        // Toggle switch for featured
        document.querySelector('input[name="is_featured"]').addEventListener('change', function(e) {
            const featuredText = e.target.closest('label').querySelector('span:last-child');
            featuredText.textContent = e.target.checked ? 'Yes' : 'No';
        });

        // File upload preview
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    // You could display a preview here if desired
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush
