<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('hospital_locations')
            ->where('name', 'InstantAyurved Nashik')
            ->where('city', 'Nashik')
            ->where(fn ($query) => $query->whereNull('opening_hours')->orWhere('opening_hours', ''))
            ->update(['opening_hours' => 'Monday to Saturday, 9:00 AM to 7:00 PM', 'updated_at' => now()]);
    }

    public function down(): void
    {
        DB::table('hospital_locations')
            ->where('name', 'InstantAyurved Nashik')
            ->where('city', 'Nashik')
            ->where('opening_hours', 'Monday to Saturday, 9:00 AM to 7:00 PM')
            ->update(['opening_hours' => null, 'updated_at' => now()]);
    }
};
