<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('treatment_videos', function (Blueprint $table) {
            $table->id();
            $table->string('youtube_id', 11)->unique();
            $table->string('title', 180);
            $table->text('description')->nullable();
            $table->string('category', 100)->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('published')->default(false);
            $table->unsignedInteger('display_order')->default(0);
            $table->timestamps();
            $table->index(['published', 'featured', 'display_order']);
        });

        $videos = [
            ['GQMbyucr13g', 'Cervical pain and Ayurveda', 'Joint and spine health'],
            ['D1yoRceSVo4', 'Sciatica and Ayurveda', 'Joint and spine health'],
            ['BI_eiWnqJxk', 'Frozen shoulder and Ayurveda', 'Joint and spine health'],
            ['vBjIfTl5K6g', 'Joint pain and Ayurveda', 'Joint and spine health'],
            ['8JsGEfkUtLg', 'Joint pain with Dr. Tejas Kadam', 'Joint and spine health'],
            ['ncyQPXGgoQM', 'Ayurvedic dietary principles', 'Nutrition'],
            ['Yq03gyYWpAY', 'Avascular necrosis and Ayurveda', 'Joint and spine health'],
            ['v0FFXF9cLCo', 'Paralysis case discussion', 'Neurological health'],
            ['XAVZuYvurPI', 'Paralysis and Ayurveda', 'Neurological health'],
            ['Inrc76C6l7Q', 'Ligament tears and Ayurveda', 'Joint and spine health'],
            ['-HTYW5CwMPA', 'Paralysis treatment discussion', 'Neurological health'],
            ['PoXTGbd2N50', 'Foot drop case discussion', 'Neurological health'],
            ['9o_GFTqNlQ0', 'Paralysis and Ayurvedic care', 'Neurological health'],
            ['008qIZLOjYk', 'Diabetes case discussion', 'General health'],
            ['A9wxkbXwwSc', 'Gudi Padwa and health', 'General health'],
            ['_i0W5_O2y8I', 'Sanskar with Dr. Tejas Kadam', 'General health'],
            ['YtUni6SDh4M', 'An Ayurvedic perspective on joint pain', 'Joint and spine health'],
            ['D2WRDCwkpks', 'The human body from an Ayurvedic perspective', 'General health'],
            ['2-qbHwDoW5I', 'Traditional Ayurvedic medicine discussion', 'General health'],
            ['IgP-bdM_08A', 'Patient experience with paralysis care', 'Neurological health'],
            ['ZLbL-Pj8jZs', 'Patient experience with joint pain and stiffness', 'Joint and spine health'],
        ];

        foreach ($videos as $index => [$id, $title, $category]) {
            DB::table('treatment_videos')->insert([
                'youtube_id' => $id,
                'title' => $title,
                'category' => $category,
                'featured' => $id === 'ncyQPXGgoQM',
                'published' => !in_array($id, ['IgP-bdM_08A', 'ZLbL-Pj8jZs'], true),
                'display_order' => $index,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('treatment_videos');
    }
};
