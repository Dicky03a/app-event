@extends('layouts.app')

@section('title', 'Ticket Details - Dashboard Admin')

@section('content')
<div class="p-4 mx-auto max-w-screen-2xl md:p-6">
      <div class="grid grid-cols-12 gap-4 mb-10 md:gap-6">
            <div class="col-span-12 space-y-6 xl:col-span-7">
                  <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Ticket Details</h1>
                  <p class="text-gray-500 dark:text-gray-400">View details of the ticket</p>
            </div>
      </div>

      @if(session('success'))
      <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
      </div>
      @endif

      <!-- Ticket Details -->
      <div class="mb-10 p-6 bg-white rounded-xl border border-gray-200 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex justify-between items-center mb-6">
                  <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ $ticket->name }}</h2>
                  <a href="{{ route('admin.tickets.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg text-center dark:bg-gray-600 dark:text-white dark:hover:bg-gray-700">
                        Back to Tickets
                  </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <!-- Thumbnail -->
                  <div class="md:col-span-2">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Thumbnail</h3>
                        @if($ticket->thumbnail)
                        <img src="{{ Storage::url($ticket->thumbnail) }}" alt="{{ $ticket->name }}" class="w-full max-w-md h-64 object-cover rounded-lg">
                        @else
                        <div class="w-full max-w-md h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                            <span class="text-gray-500">No thumbnail available</span>
                        </div>
                        @endif
                  </div>
                  
                  <div>
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Basic Information</h3>
                        
                        <div class="space-y-4">
                              <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $ticket->name }}</p>
                              </div>
                              
                              <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $ticket->category->name ?? 'No category' }}</p>
                              </div>
                              
                              <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $ticket->address }}</p>
                              </div>
                              
                              <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
                              </div>
                              
                              <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Is Popular</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $ticket->is_popular ? 'Yes' : 'No' }}</p>
                              </div>
                        </div>
                  </div>
                  
                  <div>
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Additional Information</h3>
                        
                        <div class="space-y-4">
                              <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Open Time</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($ticket->open_time_at)->format('h:i A') }}</p>
                              </div>
                              
                              <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Close Time</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($ticket->close_time_at)->format('h:i A') }}</p>
                              </div>
                              
                              <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Video Path</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $ticket->path_video ?: 'Not available' }}</p>
                              </div>
                              
                              <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">About</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $ticket->about }}</p>
                              </div>
                        </div>
                  </div>
            </div>
            
            <!-- Photo Gallery -->
            @if($ticket->photos->count() > 0)
            <div class="mt-8">
                  <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Photo Gallery</h3>
                  <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                      @foreach($ticket->photos as $photo)
                      <div>
                          <img src="{{ Storage::url($photo->photo) }}" alt="Ticket photo" class="w-full h-32 object-cover rounded-lg">
                      </div>
                      @endforeach
                  </div>
            </div>
            @endif
      </div>
      
      <!-- Action Buttons -->
      <div class="flex gap-3">
            <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="px-5 py-2.5 text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 rounded-lg dark:bg-yellow-500 dark:hover:bg-yellow-600">
                  Edit Ticket
            </a>
            <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg dark:bg-red-500 dark:hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this ticket?')">
                    Delete Ticket
                </button>
            </form>
      </div>
</div>
@endsection