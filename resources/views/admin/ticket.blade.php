@extends('layouts.app')

@section('title', 'Tickets - Dashboard Admin')

@section('content')
<div class="p-4 mx-auto max-w-screen-2xl md:p-6">
      <div class="grid grid-cols-12 gap-4 mb-10 md:gap-6">
            <div class="col-span-12 space-y-6 xl:col-span-7">
                  <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Ticket Management</h1>
                  <p class="text-gray-500 dark:text-gray-400">Manage your tickets here</p>
            </div>
            <div class="col-span-12 xl:col-span-5 flex items-center justify-end">
                  <a href="{{ route('admin.tickets.create') }}" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add New Ticket
                  </a>
            </div>
      </div>

      @if(session('success'))
      <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('success') }}
      </div>
      @endif

      @if(session('error'))
      <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('error') }}
      </div>
      @endif

      <!-- Tickets Table -->
      <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="max-w-full overflow-x-auto">
                  <table class="min-w-full">
                        <thead>
                              <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <th class="px-5 py-3 sm:px-6 text-left">
                                          <p class="font-medium text-gray-500 text-xs dark:text-gray-400">
                                                Ticket
                                          </p>
                                    </th>
                                    <th class="px-5 py-3 sm:px-6 text-left">
                                          <p class="font-medium text-gray-500 text-xs dark:text-gray-400">
                                                Category
                                          </p>
                                    </th>
                                    <th class="px-5 py-3 sm:px-6 text-left">
                                          <p class="font-medium text-gray-500 text-xs dark:text-gray-400">
                                                Price
                                          </p>
                                    </th>
                                    <th class="px-5 py-3 sm:px-6 text-left">
                                          <p class="font-medium text-gray-500 text-xs dark:text-gray-400">
                                                Schedule
                                          </p>
                                    </th>
                                    <th class="px-5 py-3 sm:px-6 text-center">
                                          <p class="font-medium text-gray-500 text-xs dark:text-gray-400">
                                                Popular
                                          </p>
                                    </th>
                                    <th class="px-5 py-3 sm:px-6 text-center">
                                          <p class="font-medium text-gray-500 text-xs dark:text-gray-400">
                                                Actions
                                          </p>
                                    </th>
                              </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                              @forelse($tickets as $ticket)
                              <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                    <td class="px-5 py-4 sm:px-6">
                                          <div class="flex items-center">
                                                <div class="flex-shrink-0 w-12 h-12">
                                                      @if($ticket->thumbnail)
                                                      <img src="{{ Storage::url($ticket->thumbnail) }}" alt="{{ $ticket->name }}" class="w-12 h-12 rounded-lg object-cover">
                                                      @else
                                                      <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center dark:bg-gray-700">
                                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                      </div>
                                                      @endif
                                                </div>
                                                <div class="ml-4">
                                                      <p class="font-medium text-gray-900 dark:text-white">{{ $ticket->name }}</p>
                                                      <p class="text-gray-500 text-xs dark:text-gray-400 mt-1">
                                                            <svg class="w-3 h-3 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            </svg>
                                                            {{ Str::limit($ticket->address, 30) }}
                                                      </p>
                                                      @if($ticket->photos->count() > 0)
                                                      <p class="text-gray-400 text-xs mt-1">
                                                            {{ $ticket->photos->count() }} photos
                                                      </p>
                                                      @endif
                                                </div>
                                          </div>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                          <span class="px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full dark:bg-blue-800/30 dark:text-blue-400">
                                                {{ $ticket->category->name ?? '-' }}
                                          </span>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                          <p class="font-semibold text-gray-900 dark:text-white">
                                                Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                          </p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                          <p class="text-xs text-gray-600 dark:text-gray-400">
                                                <svg class="w-3 h-3 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ date('H:i', strtotime($ticket->open_time_at)) }} - {{ date('H:i', strtotime($ticket->close_time_at)) }}
                                          </p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6 text-center">
                                          @if($ticket->is_popular)
                                          <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full dark:bg-green-800/30 dark:text-green-400">
                                                <svg class="w-3 h-3 inline-block" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                                Popular
                                          </span>
                                          @else
                                          <span class="px-2 py-1 text-xs font-semibold text-gray-600 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-400">
                                                Regular
                                          </span>
                                          @endif
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                          <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" title="View">
                                                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                      </svg>
                                                </a>
                                                <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300" title="Edit">
                                                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                      </svg>
                                                </a>
                                                <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this ticket? This action cannot be undone.')">
                                                      @csrf
                                                      @method('DELETE')
                                                      <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="Delete">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                      </button>
                                                </form>
                                          </div>
                                    </td>
                              </tr>
                              @empty
                              <tr>
                                    <td colspan="6" class="px-5 py-8 sm:px-6 text-center">
                                          <div class="flex flex-col items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                                </svg>
                                                <p class="text-gray-500 dark:text-gray-400 text-lg font-medium mb-2">No tickets found</p>
                                                <p class="text-gray-400 dark:text-gray-500 text-sm mb-4">Get started by creating your first ticket</p>
                                                <a href="{{ route('admin.tickets.create') }}" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                                                      Create Ticket
                                                </a>
                                          </div>
                                    </td>
                              </tr>
                              @endforelse
                        </tbody>
                  </table>
            </div>

            <!-- Pagination -->
            @if($tickets->hasPages())
            <div class="p-4 border-t border-gray-200 dark:border-gray-800">
                  {{ $tickets->links() }}
            </div>
            @endif
      </div>
</div>
@endsection