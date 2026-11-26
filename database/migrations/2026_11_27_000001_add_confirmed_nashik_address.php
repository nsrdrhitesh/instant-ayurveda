<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('hospital_locations')->where('name', 'InstantAyurved Nashik')
            ->where('city', 'Nashik')->where('address', '')->whereNull('map_url')
            ->update([
                'address' => '1, Thakare Mala, Savata Nagar',
                'postal_code' => '422004',
                'map_url' => 'https://maps.app.goo.gl/4KXPypRHRLFJBEZp7',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('hospital_locations')->where('name', 'InstantAyurved Nashik')
            ->where('address', '1, Thakare Mala, Savata Nagar')->where('postal_code', '422004')
            ->where('map_url', 'https://maps.app.goo.gl/4KXPypRHRLFJBEZp7')
            ->update(['address' => '', 'postal_code' => '', 'map_url' => null, 'updated_at' => now()]);
    }
};
