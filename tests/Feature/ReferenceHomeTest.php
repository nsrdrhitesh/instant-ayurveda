<?php

namespace Tests\Feature;

use App\Models\Inquiry;
use App\Models\User;
use App\Services\PublicSubmissions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReferenceHomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_inline_callback_accepts_phone_without_email(): void
    {
        $this->get('/')->assertOk()->assertSee('Request a Call Back')->assertSee('Why Choose InstantAyurved');
        $this->withCredentials()->withCookie(config('session.cookie'), session()->getId());
        $token = app(PublicSubmissions::class)->token(request());

        $this->postJson('/consultation', $token + [
            'full_name' => 'Callback Test',
            'mobile' => '9920390010',
            'country_code' => '+91',
            'interest' => 'Ayurvedic consultation',
            'session_preference' => 'No preference / Help me decide',
            'contact_method' => 'phone',
            'source' => 'homepage_callback',
            'consent' => 1,
        ])->assertCreated();

        $inquiry = Inquiry::sole();
        $this->assertNull($inquiry->email);
        $this->assertSame('+919920390010', $inquiry->mobile);
    }

    public function test_newsletter_requires_consent_deduplicates_and_limits_admin_access(): void
    {
        $this->from('/')->post('/newsletter', ['newsletter_email' => 'reader@example.com'])
            ->assertSessionHasErrors('newsletter_consent', null, 'newsletter');
        foreach (['Reader@example.com', 'reader@example.com'] as $email) {
            $this->post('/newsletter', ['newsletter_email' => $email, 'newsletter_consent' => 1])
                ->assertSessionHas('newsletter_success');
        }

        $this->assertDatabaseCount('newsletter_subscribers', 1);
        $this->get('/admin/newsletter')->assertRedirect('/login');
        $this->actingAs(User::factory()->create(['role' => 'editor', 'active' => true]));
        $this->get('/admin/newsletter')->assertForbidden();
        $this->actingAs(User::factory()->create(['role' => 'administrator', 'active' => true]));
        $this->get('/admin/newsletter')->assertOk()->assertSee('reader@example.com');
    }
}
