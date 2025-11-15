<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BookingTransaction;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookingTransactionController extends Controller
{
      /**
       * Display a listing of the resource.
       */
      public function index()
      {
            $bookings = BookingTransaction::with('ticket')
                  ->latest()
                  ->paginate(10);

            return view('admin.booking-transactions.index', compact('bookings'));
      }

      /**
       * Show the form for creating a new resource.
       */
      public function create()
      {
            $tickets = Ticket::all();
            return view('admin.booking-transactions.create', compact('tickets'));
      }

      /**
       * Store a newly created resource in storage.
       */
      public function store(Request $request)
      {
            $validated = $request->validate([
                  'name' => 'required|string|max:255',
                  'phone_number' => 'required|string|max:20',
                  'email' => 'required|email|max:255',
                  'proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                  'total_amount' => 'required|numeric|min:0',
                  'total_participant' => 'required|integer|min:1',
                  'is_paid' => 'required|boolean',
                  'started_at' => 'required|date',
                  'ticket_id' => 'required|exists:tickets,id',
            ]);

            // Generate unique transaction ID
            $validated['booking_trx_id'] = BookingTransaction::generateUniqueTrxId();

            // Handle file upload
            if ($request->hasFile('proof')) {
                  $validated['proof'] = $request->file('proof')->store('proofs', 'public');
            }

            BookingTransaction::create($validated);

            return redirect()
                  ->route('admin.booking-transactions.index')
                  ->with('success', 'Booking transaction created successfully.');
      }

      /**
       * Display the specified resource.
       */
      public function show(BookingTransaction $bookingTransaction)
      {
            $bookingTransaction->load('ticket');
            return view('admin.booking-transactions.show', compact('bookingTransaction'));
      }

      /**
       * Show the form for editing the specified resource.
       */
      public function edit(BookingTransaction $bookingTransaction)
      {
            $tickets = Ticket::all();
            return view('admin.booking-transactions.edit', compact('bookingTransaction', 'tickets'));
      }

      /**
       * Update the specified resource in storage.
       */
      public function update(Request $request, BookingTransaction $bookingTransaction)
      {
            $validated = $request->validate([
                  'name' => 'required|string|max:255',
                  'phone_number' => 'required|string|max:20',
                  'email' => 'required|email|max:255',
                  'proof' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                  'total_amount' => 'required|numeric|min:0',
                  'total_participant' => 'required|integer|min:1',
                  'is_paid' => 'required|boolean',
                  'started_at' => 'required|date',
                  'ticket_id' => 'required|exists:tickets,id',
            ]);

            // Handle file upload
            if ($request->hasFile('proof')) {
                  // Delete old proof
                  if ($bookingTransaction->proof) {
                        Storage::disk('public')->delete($bookingTransaction->proof);
                  }
                  $validated['proof'] = $request->file('proof')->store('proofs', 'public');
            }

            $bookingTransaction->update($validated);

            return redirect()
                  ->route('admin.booking-transactions.index')
                  ->with('success', 'Booking transaction updated successfully.');
      }

      /**
       * Remove the specified resource from storage.
       */
      public function destroy(BookingTransaction $bookingTransaction)
      {
            // Delete proof file
            if ($bookingTransaction->proof) {
                  Storage::disk('public')->delete($bookingTransaction->proof);
            }

            $bookingTransaction->delete();

            return redirect()
                  ->route('admin.booking-transactions.index')
                  ->with('success', 'Booking transaction deleted successfully.');
      }
}
