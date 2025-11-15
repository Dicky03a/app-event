@extends('layouts.app')

@section('title', 'Booking Transactions - Dashboard Admin')

@section('content')
<div class="container mx-auto px-4 py-8">
      <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                  <div class="flex items-center">
                        <a href="{{ route('admin.booking-transactions.index') }}"
                              class="text-gray-600 hover:text-gray-900 mr-4">
                              ← Back
                        </a>
                        <h1 class="text-3xl font-bold text-gray-800">Booking Details</h1>
                  </div>
                  <div class="flex space-x-2">
                        <a href="{{ route('admin.booking-transactions.edit', $bookingTransaction) }}"
                              class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                              Edit
                        </a>
                        <form action="{{ route('admin.booking-transactions.destroy', $bookingTransaction) }}"
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this booking?');">
                              @csrf
                              @method('DELETE')
                              <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                                    Delete
                              </button>
                        </form>
                  </div>
            </div>

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                  <!-- Header -->
                  <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                        <div class="flex justify-between items-center">
                              <div>
                                    <h2 class="text-white text-2xl font-bold">{{ $bookingTransaction->booking_trx_id }}</h2>
                                    <p class="text-blue-100 text-sm">Transaction ID</p>
                              </div>
                              <div>
                                    @if($bookingTransaction->is_paid)
                                    <span class="px-4 py-2 bg-green-500 text-white text-sm font-semibold rounded-full">
                                          PAID
                                    </span>
                                    @else
                                    <span class="px-4 py-2 bg-red-500 text-white text-sm font-semibold rounded-full">
                                          UNPAID
                                    </span>
                                    @endif
                              </div>
                        </div>
                  </div>

                  <!-- Content -->
                  <div class="p-6">
                        <!-- Customer Information -->
                        <div class="mb-6">
                              <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Customer Information</h3>
                              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                          <p class="text-sm text-gray-600">Name</p>
                                          <p class="text-lg font-semibold text-gray-900">{{ $bookingTransaction->name }}</p>
                                    </div>
                                    <div>
                                          <p class="text-sm text-gray-600">Email</p>
                                          <p class="text-lg font-semibold text-gray-900">{{ $bookingTransaction->email }}</p>
                                    </div>
                                    <div>
                                          <p class="text-sm text-gray-600">Phone Number</p>
                                          <p class="text-lg font-semibold text-gray-900">{{ $bookingTransaction->phone_number }}</p>
                                    </div>
                              </div>
                        </div>

                        <!-- Ticket Information -->
                        <div class="mb-6">
                              <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Ticket Information</h3>
                              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                          <p class="text-sm text-gray-600">Ticket</p>
                                          <p class="text-lg font-semibold text-gray-900">{{ $bookingTransaction->ticket->name ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                          <p class="text-sm text-gray-600">Start Date</p>
                                          <p class="text-lg font-semibold text-gray-900">{{ $bookingTransaction->started_at->format('d F Y') }}</p>
                                    </div>
                                    <div>
                                          <p class="text-sm text-gray-600">Total Participants</p>
                                          <p class="text-lg font-semibold text-gray-900">{{ $bookingTransaction->total_participant }} {{ Str::plural('person', $bookingTransaction->total_participant) }}</p>
                                    </div>
                              </div>
                        </div>

                        <!-- Payment Information -->
                        <div class="mb-6">
                              <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Payment Information</h3>
                              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                          <p class="text-sm text-gray-600">Total Amount</p>
                                          <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($bookingTransaction->total_amount, 0, ',', '.') }}</p>
                                    </div>
                                    <div>
                                          <p class="text-sm text-gray-600">Payment Status</p>
                                          <p class="text-lg font-semibold text-gray-900">
                                                @if($bookingTransaction->is_paid)
                                                <span class="text-green-600">Paid</span>
                                                @else
                                                <span class="text-red-600">Unpaid</span>
                                                @endif
                                          </p>
                                    </div>
                              </div>
                        </div>

                        <!-- Payment Proof -->
                        <div class="mb-6">
                              <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Payment Proof</h3>
                              @if($bookingTransaction->proof)
                              <div class="flex justify-center">
                                    <img src="{{ Storage::url($bookingTransaction->proof) }}"
                                          alt="Payment Proof"
                                          class="max-w-md rounded-lg shadow-lg border">
                              </div>
                              @else
                              <p class="text-gray-500">No payment proof uploaded</p>
                              @endif
                        </div>

                        <!-- Metadata -->
                        <div class="mt-6 pt-6 border-t">
                              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                                    <div>
                                          <p>Created: {{ $bookingTransaction->created_at->format('d F Y, H:i') }}</p>
                                    </div>
                                    <div>
                                          <p>Last Updated: {{ $bookingTransaction->updated_at->format('d F Y, H:i') }}</p>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</div>
@endsection