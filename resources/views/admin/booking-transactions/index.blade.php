@extends('layouts.app')

@section('title', 'Booking Transactions - Dashboard Admin')

@section('content')
<div class="container mx-auto px-4 py-8">
      <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Booking Transactions</h1>
            <a href="{{ route('admin.booking-transactions.create') }}"
                  class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                  + New Booking
            </a>
      </div>

      @if(session('success'))
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
      </div>
      @endif

      <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                        <tr>
                              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TRX ID</th>
                              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket</th>
                              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Participant</th>
                              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50">
                              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $booking->booking_trx_id }}
                              </td>
                              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $booking->name }}
                              </td>
                              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $booking->ticket->name ?? 'N/A' }}
                              </td>
                              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                              </td>
                              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $booking->total_participant }}
                              </td>
                              <td class="px-6 py-4 whitespace-nowrap">
                                    @if($booking->is_paid)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                          Paid
                                    </span>
                                    @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                          Unpaid
                                    </span>
                                    @endif
                              </td>
                              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $booking->started_at->format('d M Y') }}
                              </td>
                              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                          <a href="{{ route('admin.booking-transactions.show', $booking) }}"
                                                class="text-blue-600 hover:text-blue-900">View</a>
                                          <a href="{{ route('admin.booking-transactions.edit', $booking) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                          <form action="{{ route('admin.booking-transactions.destroy', $booking) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this booking?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                          </form>
                                    </div>
                              </td>
                        </tr>
                        @empty
                        <tr>
                              <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                    No booking transactions found.
                              </td>
                        </tr>
                        @endforelse
                  </tbody>
            </table>
      </div>

      <div class="mt-4">
            {{ $bookings->links() }}
      </div>
</div>
@endsection