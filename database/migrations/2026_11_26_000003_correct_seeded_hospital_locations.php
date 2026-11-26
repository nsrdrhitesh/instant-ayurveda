<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('hospital_locations')
            ->where('name', 'InstantAyurved Pune')
            ->where('address', 'Pune')
            ->where('city', 'Pune')
            ->where('postal_code', '411001')
            ->where('phone', '+91 7385498981')
            ->where('email', 'ayurtejas26@gmail.com')
            ->where('opening_hours', 'By appointment')
            ->whereNull('map_url')->whereNull('latitude')->whereNull('longitude')
            ->whereColumn('created_at', 'updated_at')
            ->update([
                'name' => 'InstantAyurved Nashik',
                'address' => '',
                'city' => 'Nashik',
                'postal_code' => '',
                'phone' => '',
                'email' => null,
                'opening_hours' => null,
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        // Preserve confirmed location edits and avoid restoring unverified data.
    }
};
