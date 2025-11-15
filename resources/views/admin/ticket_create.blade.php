@extends('layouts.app')

@section('title', 'Create Ticket - Dashboard Admin')

@section('content')
<div class="p-4 mx-auto max-w-screen-2xl md:p-6">
      <div class="grid grid-cols-12 gap-4 mb-10 md:gap-6">
            <div class="col-span-12 space-y-6 xl:col-span-7">
                  <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Create New Ticket</h1>
                  <p class="text-gray-500 dark:text-gray-400">Add a new ticket to the system</p>
            </div>
      </div>

      @if(session('success'))
      <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('success') }}
      </div>
      @endif

      @if(session('error'))
      <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('error') }}
      </div>
      @endif

      <!-- Create Ticket Form -->
      <div class="mb-10 p-6 bg-white rounded-xl border border-gray-200 dark:border-gray-800 dark:bg-white/[0.03]">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Add New Ticket</h2>
            <form action="{{ route('admin.tickets.store') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                              <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name *</label>
                              <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                              @error('name')
                              <span class="text-red-500 text-sm">{{ $message }}</span>
                              @enderror
                        </div>

                        <div>
                              <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category *</label>
                              <select name="category_id" id="category_id" class="w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                          {{ $category->name }}
                                    </option>
                                    @endforeach
                              </select>
                              @error('category_id')
                              <span class="text-red-500 text-sm">{{ $message }}</span>
                              @enderror
                        </div>

                        <div class="md:col-span-2">
                              <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address *</label>
                              <input type="text" name="address" id="address" value="{{ old('address') }}" class="w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                              @error('address')
                              <span class="text-red-500 text-sm">{{ $message }}</span>
                              @enderror
                        </div>

                        <div>
                              <label for="thumbnail" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Thumbnail *</label>
                              <input type="file" name="thumbnail" id="thumbnail" class="w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" accept="image/*" required>
                              @error('thumbnail')
                              <span class="text-red-500 text-sm">{{ $message }}</span>
                              @enderror
                        </div>

                        <div>
                              <label for="path_video" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Video Path (URL)</label>
                              <input type="url" name="path_video" id="path_video" value="{{ old('path_video') }}" placeholder="https://example.com/video.mp4" class="w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                              @error('path_video')
                              <span class="text-red-500 text-sm">{{ $message }}</span>
                              @enderror
                        </div>

                        <div>
                              <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price (Rp) *</label>
                              <input type="number" name="price" id="price" value="{{ old('price', 0) }}" min="0" class="w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                              @error('price')
                              <span class="text-red-500 text-sm">{{ $message }}</span>
                              @enderror
                        </div>

                        <div>
                              <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Is Popular? *</label>
                              <div class="flex items-center space-x-4 mt-3">
                                    <label class="inline-flex items-center">
                                          <input type="radio" name="is_popular" value="1" {{ old('is_popular') == '1' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600" required>
                                          <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Yes</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                          <input type="radio" name="is_popular" value="0" {{ old('is_popular', '0') == '0' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600" required>
                                          <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">No</span>
                                    </label>
                              </div>
                              @error('is_popular')
                              <span class="text-red-500 text-sm">{{ $message }}</span>
                              @enderror
                        </div>

                        <div class="md:col-span-2">
                              <label for="about" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">About *</label>
                              <textarea name="about" id="about" rows="4" class="w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>{{ old('about') }}</textarea>
                              @error('about')
                              <span class="text-red-500 text-sm">{{ $message }}</span>
                              @enderror
                        </div>

                        <div>
                              <label for="open_time_at" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Open Time *</label>
                              <input type="time" name="open_time_at" id="open_time_at" value="{{ old('open_time_at', '08:00') }}" class="w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                              @error('open_time_at')
                              <span class="text-red-500 text-sm">{{ $message }}</span>
                              @enderror
                        </div>

                        <div>
                              <label for="close_time_at" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Close Time *</label>
                              <input type="time" name="close_time_at" id="close_time_at" value="{{ old('close_time_at', '18:00') }}" class="w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                              @error('close_time_at')
                              <span class="text-red-500 text-sm">{{ $message }}</span>
                              @enderror
                        </div>

                        <div class="md:col-span-2">
                              <label for="photos" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Additional Photos</label>
                              <input type="file" name="photos[]" id="photos" multiple class="w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" accept="image/*">
                              <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">You can select multiple photos (max 10, each max 2MB)</p>
                              @error('photos')
                              <span class="text-red-500 text-sm">{{ $message }}</span>
                              @enderror
                              @error('photos.*')
                              <span class="text-red-500 text-sm">{{ $message }}</span>
                              @enderror
                        </div>
                  </div>

                  <div class="mt-6 flex gap-3">
                        <a href="{{ route('admin.ticket') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg dark:bg-gray-600 dark:text-white dark:hover:bg-gray-700">
                              Cancel
                        </a>
                        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                              <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                              </svg>
                              Create Ticket
                        </button>
                  </div>
            </form>
      </div>
</div>
@endsection