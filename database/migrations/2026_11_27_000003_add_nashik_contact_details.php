<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $nashik = fn () => DB::table('hospital_locations')
            ->where('name', 'InstantAyurved Nashik')->where('city', 'Nashik');

        $nashik()->where(fn ($query) => $query->whereNull('phone')->orWhere('phone', ''))
            ->update(['phone' => '+91 7887888184', 'updated_at' => now()]);
        $nashik()->where(fn ($query) => $query->whereNull('email')->orWhere('email', ''))
            ->update(['email' => 'ayurtejas26@gmail.com', 'updated_at' => now()]);
    }

    public function down(): void
    {
        // Preserve live contact details during rollback.
    }
};
