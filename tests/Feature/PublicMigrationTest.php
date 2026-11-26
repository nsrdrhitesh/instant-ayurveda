<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_legacy_pages_redirect_to_canonical_routes(): void
    {
        $this->get('/about-dr-tejas-kadam.php')->assertRedirect('/doctor-tejas-kadam')->assertStatus(301);
        $this->get('/service-panchakarma.php')->assertRedirect('/services/panchakarma')->assertStatus(301);
        $this->get('/service-unknown.php')->assertNotFound();
    }

    public function test_contact_and_facility_show_verified_and_pending_locations(): void
    {
        foreach (['/contact', '/facility'] as $path) {
            $this->get($path)->assertOk()
                ->assertSee('Sarpanch Wasti, Gopalwadi Road')
                ->assertSee('InstantAyurved Nashik')
                ->assertSee('1, Thakare Mala, Savata Nagar')
                ->assertSee('https://maps.app.goo.gl/4KXPypRHRLFJBEZp7')
                ->assertDontSee('411001');
        }
    }

    public function test_production_documents_are_crawlable_and_staff_pages_are_noindex(): void
    {
        config(['vidya.staging_protection' => false]);
        $this->get('/treatment-videos')->assertOk()->assertHeaderMissing('X-Robots-Tag');
        $this->get('/login')->assertOk()->assertHeader('X-Robots-Tag', 'noindex, nofollow, noarchive');
        $this->get('/robots.txt')->assertOk()->assertSee('Sitemap: '.route('sitemap'));
        config(['vidya.staging_protection' => true]);
        $this->get('/robots.txt')->assertUnauthorized()->assertHeader('X-Robots-Tag', 'noindex, nofollow, noarchive');
    }
}
