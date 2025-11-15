<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\TicketPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::with(['category', 'photos'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.ticket', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.ticket_create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'address' => 'required|string|max:500',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'path_video' => 'nullable|url|max:500',
            'price' => 'required|integer|min:0',
            'is_popular' => 'required|boolean',
            'about' => 'required|string',
            'open_time_at' => 'required|date_format:H:i',
            'close_time_at' => 'required|date_format:H:i|after:open_time_at',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        DB::beginTransaction();

        try {
            // Handle thumbnail upload
            $thumbnailPath = $request->file('thumbnail')->store('tickets/thumbnails', 'public');

            // Create ticket
            $ticket = Ticket::create([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'category_id' => $validated['category_id'],
                'address' => $validated['address'],
                'thumbnail' => $thumbnailPath,
                'path_video' => $validated['path_video'] ?? null,
                'price' => $validated['price'],
                'is_popular' => filter_var($request->input('is_popular', false), FILTER_VALIDATE_BOOLEAN),
                'about' => $validated['about'],
                'open_time_at' => $validated['open_time_at'],
                'close_time_at' => $validated['close_time_at'],
            ]);

            // Handle photo uploads
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $photoPath = $photo->store('tickets/photos', 'public');
                    $ticket->photos()->create(['photo' => $photoPath]);
                }
            }

            DB::commit();

            return redirect()->route('admin.ticket')
                ->with('success', 'Ticket created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Delete uploaded files if transaction fails
            if (isset($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create ticket: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ticket = Ticket::with(['category', 'photos'])->findOrFail($id);
        return view('admin.ticket_show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $ticket = Ticket::with('photos')->findOrFail($id);
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.ticket_edit', compact('ticket', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'address' => 'required|string|max:500',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'path_video' => 'nullable|url|max:500',
            'price' => 'required|integer|min:0',
            'is_popular' => 'required|boolean',
            'about' => 'required|string',
            'open_time_at' => 'required|date_format:H:i',
            'close_time_at' => 'required|date_format:H:i|after:open_time_at',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $updateData = [
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'category_id' => $validated['category_id'],
                'address' => $validated['address'],
                'path_video' => $validated['path_video'] ?? null,
                'price' => $validated['price'],
                'is_popular' => filter_var($request->input('is_popular', false), FILTER_VALIDATE_BOOLEAN),
                'about' => $validated['about'],
                'open_time_at' => $validated['open_time_at'],
                'close_time_at' => $validated['close_time_at'],
            ];

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail
                if ($ticket->thumbnail && Storage::disk('public')->exists($ticket->thumbnail)) {
                    Storage::disk('public')->delete($ticket->thumbnail);
                }

                $updateData['thumbnail'] = $request->file('thumbnail')->store('tickets/thumbnails', 'public');
            }

            // Update ticket
            $ticket->update($updateData);

            // Handle new photo uploads
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $photoPath = $photo->store('tickets/photos', 'public');
                    $ticket->photos()->create(['photo' => $photoPath]);
                }
            }

            DB::commit();

            return redirect()->route('admin.ticket')
                ->with('success', 'Ticket updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update ticket: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ticket = Ticket::with('photos')->findOrFail($id);

        DB::beginTransaction();

        try {
            // Delete all photos
            foreach ($ticket->photos as $photo) {
                if (Storage::disk('public')->exists($photo->photo)) {
                    Storage::disk('public')->delete($photo->photo);
                }
            }

            // Delete thumbnail
            if ($ticket->thumbnail && Storage::disk('public')->exists($ticket->thumbnail)) {
                Storage::disk('public')->delete($ticket->thumbnail);
            }

            // Delete ticket (soft delete)
            $ticket->delete();

            DB::commit();

            return redirect()->route('admin.ticket')
                ->with('success', 'Ticket deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Failed to delete ticket: ' . $e->getMessage());
        }
    }

    /**
     * Remove a specific photo from the ticket
     */
    public function removePhoto($ticketId, $photoId)
    {
        try {
            $ticket = Ticket::findOrFail($ticketId);
            $photo = $ticket->photos()->findOrFail($photoId);

            // Delete the photo file
            if (Storage::disk('public')->exists($photo->photo)) {
                Storage::disk('public')->delete($photo->photo);
            }

            $photo->delete();

            return response()->json([
                'success' => true,
                'message' => 'Photo removed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove photo: ' . $e->getMessage()
            ], 500);
        }
    }
}
