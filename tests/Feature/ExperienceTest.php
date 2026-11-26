<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\WebsiteSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExperienceTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_generates_metadata_and_location_schema_with_overrides(): void
    {
        app(WebsiteSettings::class)->save(['service_area' => 'Daund']);
        $this->get('/')->assertOk()
            ->assertSee('offers Ayurvedic consultations with Dr. Tejas Kadam in Daund.')
            ->assertSee('"@type":"MedicalClinic"', false)
            ->assertSee('"name":"InstantAyurved Nashik","parentOrganization"', false);

        $this->actingAs(User::factory()->create(['role' => 'editor', 'active' => true]));
        $this->get('/admin/experience')->assertForbidden();

        $this->actingAs(User::factory()->create(['role' => 'administrator', 'active' => true]));
        $this->get('/admin/experience')->assertOk();
        $this->put('/admin/experience', [
            'search_title' => 'Custom search title',
            'search_answer' => 'Custom answer for visitors',
            'home_services_heading' => 'Explore clinical services',
        ])->assertRedirect();

        $this->get('/')->assertOk()
            ->assertSee('<title>Custom search title</title>', false)
            ->assertSee('name="description" content="Custom answer for visitors"', false)
            ->assertSee('Explore clinical services');
    }

    public function test_source_article_import_is_repeatable_and_draft_only(): void
    {
        \Illuminate\Support\Facades\Storage::fake('local');
        $this->post('/admin/experience/import-articles')->assertRedirect('/login');
        $user = User::factory()->create(['role' => 'administrator', 'active' => true]);
        $this->actingAs($user);

        for ($attempt = 0; $attempt < 2; $attempt++) {
            $this->post('/admin/experience/import-articles')->assertRedirect();
            $this->assertDatabaseCount('posts', 31);
        }

        $this->assertDatabaseHas('posts', [
            'slug' => 'the-science-behind-panchakarma-ancient-detox-for-modern-times',
            'status' => 'draft',
            'author_id' => $user->id,
        ]);
        $this->assertDatabaseCount('media', 9);
        $article = \App\Models\Post::where('slug', 'the-science-behind-panchakarma-ancient-detox-for-modern-times')->firstOrFail();
        $this->assertNotNull($article->media);
        $this->assertNotEmpty($article->seo_description);
        $this->get('/blog')->assertDontSee('The Science Behind Panchakarma');
    }
}
