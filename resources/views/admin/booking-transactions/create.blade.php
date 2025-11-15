@extends('layouts.app')

@section('title', 'Booking Transactions - Dashboard Admin')

@section('content')
<div class="container mx-auto px-4 py-8">
      <div class="max-w-3xl mx-auto">
            <div class="flex items-center mb-6">
                  <a href="{{ route('admin.booking-transactions.index') }}"
                        class="text-gray-600 hover:text-gray-900 mr-4">
                        ← Back
                  </a>
                  <h1 class="text-3xl font-bold text-gray-800">Create New Booking</h1>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6">
                  <form action="{{ route('admin.booking-transactions.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Name -->
                        <div class="mb-4">
                              <label for="name" class="block text-gray-700 font-semibold mb-2">Name *</label>
                              <input type="text"
                                    name="name"
                                    id="name"
                                    value="{{ old('name') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                                    required>
                              @error('name')
                              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                              @enderror
                        </div>

                        <!-- Phone Number -->
                        <div class="mb-4">
                              <label for="phone_number" class="block text-gray-700 font-semibold mb-2">Phone Number *</label>
                              <input type="text"
                                    name="phone_number"
                                    id="phone_number"
                                    value="{{ old('phone_number') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone_number') border-red-500 @enderror"
                                    required>
                              @error('phone_number')
                              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                              @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                              <label for="email" class="block text-gray-700 font-semibold mb-2">Email *</label>
                              <input type="email"
                                    name="email"
                                    id="email"
                                    value="{{ old('email') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                                    required>
                              @error('email')
                              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                              @enderror
                        </div>

                        <!-- Ticket -->
                        <div class="mb-4">
                              <label for="ticket_id" class="block text-gray-700 font-semibold mb-2">Ticket *</label>
                              <select name="ticket_id"
                                    id="ticket_id"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('ticket_id') border-red-500 @enderror"
                                    required>
                                    <option value="">Select Ticket</option>
                                    @foreach($tickets as $ticket)
                                    <option value="{{ $ticket->id }}" {{ old('ticket_id') == $ticket->id ? 'selected' : '' }}>
                                          {{ $ticket->name }} - Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                    </option>
                                    @endforeach
                              </select>
                              @error('ticket_id')
                              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                              @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                              <!-- Total Amount -->
                              <div class="mb-4">
                                    <label for="total_amount" class="block text-gray-700 font-semibold mb-2">Total Amount *</label>
                                    <input type="number"
                                          name="total_amount"
                                          id="total_amount"
                                          value="{{ old('total_amount') }}"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('total_amount') border-red-500 @enderror"
                                          required>
                                    @error('total_amount')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                              </div>

                              <!-- Total Participant -->
                              <div class="mb-4">
                                    <label for="total_participant" class="block text-gray-700 font-semibold mb-2">Total Participant *</label>
                                    <input type="number"
                                          name="total_participant"
                                          id="total_participant"
                                          value="{{ old('total_participant') }}"
                                          min="1"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('total_participant') border-red-500 @enderror"
                                          required>
                                    @error('total_participant')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                              </div>
                        </div>

                        <!-- Started At -->
                        <div class="mb-4">
                              <label for="started_at" class="block text-gray-700 font-semibold mb-2">Start Date *</label>
                              <input type="date"
                                    name="started_at"
                                    id="started_at"
                                    value="{{ old('started_at') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('started_at') border-red-500 @enderror"
                                    required>
                              @error('started_at')
                              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                              @enderror
                        </div>

                        <!-- Payment Status -->
                        <div class="mb-4">
                              <label for="is_paid" class="block text-gray-700 font-semibold mb-2">Payment Status *</label>
                              <select name="is_paid"
                                    id="is_paid"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('is_paid') border-red-500 @enderror"
                                    required>
                                    <option value="0" {{ old('is_paid') == '0' ? 'selected' : '' }}>Unpaid</option>
                                    <option value="1" {{ old('is_paid') == '1' ? 'selected' : '' }}>Paid</option>
                              </select>
                              @error('is_paid')
                              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                              @enderror
                        </div>

                        <!-- Proof -->
                        <div class="mb-6">
                              <label for="proof" class="block text-gray-700 font-semibold mb-2">Payment Proof *</label>
                              <input type="file"
                                    name="proof"
                                    id="proof"
                                    accept="image/*"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('proof') border-red-500 @enderror"
                                    required>
                              <p class="text-sm text-gray-500 mt-1">Max 2MB (JPEG, PNG, JPG)</p>
                              @error('proof')
                              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                              @enderror
                        </div>

                        <div class="flex space-x-4">
                              <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                                    Create Booking
                              </button>
                              <a href="{{ route('admin.booking-transactions.index') }}"
                                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded-lg transition duration-200">
                                    Cancel
                              </a>
                        </div>
                  </form>
            </div>
      </div>
</div>
@endsection