<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
Artisan::command('test-ticket', function () {
    $category = App\Models\Category::first();
    if (!$category) {
        $this->info('No category found');
        return;
    }
    
    $ticket = App\Models\Ticket::create([
        'name' => 'Test Ticket',
        'slug' => 'test-ticket',
        'address' => 'Test Address',
        'thumbnail' => null,
        'path_video' => null,
        'price' => 100000,
        'is_popular' => false,
        'about' => 'Test ticket for verification',
        'open_time_at' => '09:00',
        'close_time_at' => '17:00',
        'category_id' => $category->id,
        'approval_status' => 'pending',
        'approval_notes' => null,
    ]);
    
    $this->info('Ticket created successfully with ID: ' . $ticket->id);
})->describe('Test ticket creation');
Artisan::command('test-popular-field', function () {
    $category = App\Models\Category::first();
    if (!$category) {
        $this->info('No category found');
        return;
    }
    
    // Test 1: Create ticket with is_popular = true
    $ticket1 = App\Models\Ticket::create([
        'name' => 'Test Ticket Popular',
        'slug' => 'test-ticket-popular',
        'address' => 'Test Address',
        'thumbnail' => null,
        'path_video' => null,
        'price' => 100000,
        'is_popular' => true, // Set to true
        'about' => 'Test ticket for popular field verification',
        'open_time_at' => '09:00',
        'close_time_at' => '17:00',
        'category_id' => $category->id,
        'approval_status' => 'pending',
        'approval_notes' => null,
    ]);
    
    // Test 2: Create ticket with is_popular = false
    $ticket2 = App\Models\Ticket::create([
        'name' => 'Test Ticket Not Popular',
        'slug' => 'test-ticket-not-popular',
        'address' => 'Test Address 2',
        'thumbnail' => null,
        'path_video' => null,
        'price' => 150000,
        'is_popular' => false, // Set to false
        'about' => 'Test ticket for popular field verification 2',
        'open_time_at' => '09:00',
        'close_time_at' => '17:00',
        'category_id' => $category->id,
        'approval_status' => 'pending',
        'approval_notes' => null,
    ]);
    
    $this->info('Ticket 1 (popular) created with ID: ' . $ticket1->id . ', is_popular value: ' . ($ticket1->is_popular ? 'true' : 'false'));
    $this->info('Ticket 2 (not popular) created with ID: ' . $ticket2->id . ', is_popular value: ' . ($ticket2->is_popular ? 'true' : 'false'));
})->describe('Test is_popular field handling');
Artisan::command('test-form-is-popular', function () {
    // Simulasi data dari form yang mungkin tidak dalam bentuk boolean
    $requestData = [
        'name' => 'Test Ticket Form',
        'category_id' => 1,
        'address' => 'Test Address from form',
        'price' => '200000', // string bukan integer
        'about' => 'Test ticket created from form simulation',
        'open_time_at' => '10:00',
        'close_time_at' => '18:00',
        'is_popular' => 'on', // Dari checkbox form, ini bisa berupa string 'on'
    ];
    
    // Membuat instance request
    $request = new \Illuminate\Http\Request($requestData);
    
    // Membuat ticket seperti di controller
    $ticketData = $request->except(['photos']);
    
    // Konversi is_popular menjadi boolean seperti yang sekarang di controller
    $ticketData['is_popular'] = $request->has('is_popular') && $request->is_popular !== null ? true : false;
    $ticketData['slug'] = \Illuminate\Support\Str::slug($request->name);
    $ticketData['approval_status'] = 'pending';
    
    $category = App\Models\Category::first();
    $ticketData['category_id'] = $category->id;
    
    $ticket = App\Models\Ticket::create($ticketData);
    
    $this->info('Form simulation - Ticket created with ID: ' . $ticket->id);
    $this->info('is_popular value: ' . ($ticket->is_popular ? 'true' : 'false') . ' (type: ' . gettype($ticket->is_popular) . ')');
    $this->info('price value: ' . $ticket->price . ' (type: ' . gettype($ticket->price) . ')');
})->describe('Test form submission handling for is_popular field');
Artisan::command('test-ticket-no-approval', function () {
    $category = App\Models\Category::first();
    if (!$category) {
        $this->info('No category found');
        return;
    }
    
    $ticket = App\Models\Ticket::create([
        'name' => 'Test Ticket Without Approval',
        'slug' => 'test-ticket-without-approval',
        'address' => 'Test Address Without Approval',
        'thumbnail' => null,
        'path_video' => null,
        'price' => 125000,
        'is_popular' => true,
        'about' => 'Test ticket without approval fields',
        'open_time_at' => '08:00',
        'close_time_at' => '19:00',
        'category_id' => $category->id,
    ]);
    
    $this->info('Ticket created successfully without approval fields. ID: ' . $ticket->id);
    $this->info('is_popular value: ' . ($ticket->is_popular ? 'true' : 'false'));
    
    // Verifikasi bahwa field approval tidak ada dalam model
    if (!isset($ticket->approval_status) && !isset($ticket->approval_notes)) {
        $this->info('Verification: approval fields are not present in the ticket model');
    } else {
        $this->error('Warning: approval fields still exist in the ticket model');
    }
})->describe('Test ticket creation without approval fields');
