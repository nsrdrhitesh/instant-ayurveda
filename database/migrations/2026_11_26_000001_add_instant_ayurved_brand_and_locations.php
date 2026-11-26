<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('hospital_locations')) {
            Schema::create('hospital_locations', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('address');
                $table->string('city', 100);
                $table->string('state', 100)->default('Maharashtra');
                $table->string('postal_code', 20);
                $table->string('phone', 30);
                $table->string('email')->nullable();
                $table->string('map_url', 1000)->nullable();
                $table->string('latitude', 30)->nullable();
                $table->string('longitude', 30)->nullable();
                $table->text('opening_hours')->nullable();
                $table->boolean('featured')->default(false);
                $table->boolean('published')->default(true);
                $table->unsignedInteger('display_order')->default(0);
                $table->timestamps();
            });
        }

        $settings = [
            'brand_name' => 'InstantAyurved',
            'founder_name' => 'Dr. Tejas Kadam',
            'founder_intro' => 'M.S. (Shalya Tantra), Ayurvedic surgeon and physician offering authentic Ayurvedic medicine, surgery and Panchakarma care.',
            'story_html' => '<p>Dr. Tejas Kadam established InstantAyurved to provide individualised Ayurvedic care combining classical principles with careful clinical assessment.</p><p>His practice focuses on Ayurvedic medicine, surgery, Panchakarma, therapeutic yoga and nutrition.</p>',
            'hero_title' => 'Experience authentic Ayurvedic healing.',
            'hero_description' => 'Integrative Ayurvedic care, specialist treatment and personalised guidance from Dr. Tejas Kadam.',
            'phone' => '+91 7887888184',
            'whatsapp' => '+917887888184',
            'email' => 'ayurtejas26@gmail.com',
            'contact_verified' => '1',
            'whatsapp_verified' => '1',
            'address' => 'Sarpanch Wasti, Gopalwadi Road, Daund, Pune, Maharashtra 413801',
            'service_area' => 'Pune and Daund, Maharashtra',
            'opening_hours' => 'Monday to Saturday, 9:00 AM to 7:00 PM',
            'map_url' => 'https://www.google.com/maps/search/?api=1&query=Sarpanch+Wasti+Gopalwadi+Road+Daund+Pune',
            'instagram' => 'https://www.instagram.com/dr.tejas_kadam/',
            'facebook' => 'https://www.facebook.com/tejas.kadam.5680/',
            'youtube' => 'https://www.youtube.com/channel/UC_wl62B-7zmmwuYytxCoCYw',
            'default_description' => 'Dr. Tejas Kadam provides authentic Ayurvedic medicine, surgery, Panchakarma and yoga therapy in Pune.',
            'consent_copy' => 'I consent to InstantAyurved using these details to contact me about this consultation request.',
        ];
        foreach ($settings as $key => $value) {
            DB::table('site_settings')->updateOrInsert(
                ['key' => $key],
                ['value' => $value, 'created_at' => now(), 'updated_at' => now()]
            );
        }

        if (!DB::table('hospital_locations')->exists()) {
            DB::table('hospital_locations')->insert([
                [
                    'name' => 'InstantAyurved Daund',
                    'address' => 'Sarpanch Wasti, Gopalwadi Road',
                    'city' => 'Daund',
                    'state' => 'Maharashtra',
                    'postal_code' => '413801',
                    'phone' => '+91 7887888184',
                    'email' => 'ayurtejas26@gmail.com',
                    'map_url' => 'https://www.google.com/maps/search/?api=1&query=Sarpanch+Wasti+Gopalwadi+Road+Daund+Pune',
                    'latitude' => null,
                    'longitude' => null,
                    'opening_hours' => 'Monday to Saturday, 9:00 AM to 7:00 PM',
                    'featured' => true,
                    'published' => true,
                    'display_order' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'InstantAyurved Pune',
                    'address' => 'Pune',
                    'city' => 'Pune',
                    'state' => 'Maharashtra',
                    'postal_code' => '411001',
                    'phone' => '+91 7385498981',
                    'email' => 'ayurtejas26@gmail.com',
                    'map_url' => null,
                    'latitude' => null,
                    'longitude' => null,
                    'opening_hours' => 'By appointment',
                    'featured' => true,
                    'published' => true,
                    'display_order' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        $services = [
            ['Ayurvedic Medicine', 'ayurvedic-medicine', 'Personalised herbal formulations and integrative care for chronic and acute conditions.', 'Ayurvedic-Medicine.jpg'],
            ['Ayurvedic Surgery', 'ayurvedic-surgery', 'Specialised Ayurvedic surgical care, including Kshar Sutra and other minimally invasive procedures.', 'Ayurvedic-Surgery.jpg'],
            ['Panchakarma Therapies', 'panchakarma', 'Traditional detoxification and rejuvenation therapies planned around individual needs.', 'Panchakarma-Therapy.jpg'],
            ['Yoga Therapy', 'yoga-therapy', 'Therapeutic yoga and breathing practices supporting recovery and long-term wellbeing.', 'Yoga Therapy.jpg'],
            ['Ayurvedic Diet & Nutrition', 'ayurvedic-diet', 'Prakriti-based dietary guidance and seasonal nutrition for sustainable health.', 'Ayurvedic-Diet-Nutrition.jpg'],
        ];
        foreach ($services as $index => [$name, $slug, $summary, $image]) {
            $id = DB::table('services')->where('slug', $slug)->value('id');
            if ($id) {
                DB::table('services')->where('id', $id)->update([
                    'name' => $name,
                    'summary' => $summary,
                    'body_html' => '<p>'.$summary.'</p><h2>Personalised Ayurvedic care</h2><p>Consultation begins with a detailed assessment of symptoms, constitution and lifestyle. A treatment plan is recommended only after clinical evaluation.</p>',
                    'status' => 'published',
                    'featured' => true,
                    'display_order' => $index + 1,
                    'updated_at' => now(),
                ]);
            } else {
                $id = DB::table('services')->insertGetId([
                    'name' => $name,
                    'slug' => $slug,
                    'summary' => $summary,
                    'body_html' => '<p>'.$summary.'</p><h2>Personalised Ayurvedic care</h2><p>Consultation begins with a detailed assessment of symptoms, constitution and lifestyle. A treatment plan is recommended only after clinical evaluation.</p>',
                    'cta_label' => 'Book Consultation',
                    'status' => 'published',
                    'featured' => true,
                    'display_order' => $index + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            DB::table('public_pages')->updateOrInsert(
                ['reference' => 'service:'.$id],
                ['kind' => 'service', 'entity_id' => $id, 'title' => $name, 'path' => '/services/'.$slug, 'status' => 'published', 'updated_at' => now(), 'created_at' => now()]
            );
        }

        $instantSlugs = array_column($services, 1);
        DB::table('services')->whereNotIn('slug', $instantSlugs)->update([
            'status' => 'draft',
            'updated_at' => now(),
        ]);
        DB::table('public_pages')
            ->where('kind', 'service')
            ->whereNotIn('path', array_map(fn (string $slug) => '/services/'.$slug, $instantSlugs))
            ->update(['status' => 'archived', 'updated_at' => now()]);
    }

    public function down(): void
    {
        throw new RuntimeException('Forward-only production upgrade; restore a verified backup if rollback is required.');
    }
};
