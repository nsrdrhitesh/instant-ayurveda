<?php

namespace Tests\Feature;

use App\Models\TreatmentVideo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TreatmentVideoTest extends TestCase
{
    use RefreshDatabase;

    public function test_imported_catalogue_publication_and_filtering(): void
    {
        $this->assertDatabaseCount('treatment_videos', 21);
        $response = $this->get('/')->assertOk()->assertDontSee('IgP-bdM_08A');
        $this->assertSame(3, substr_count($response->getContent(), 'https://youtu.be/'));
        $this->get('/treatment-videos?category=Nutrition')->assertOk()
            ->assertSee('ncyQPXGgoQM')
            ->assertDontSee('GQMbyucr13g');
        $this->get('/treatment-videos')->assertOk()->assertDontSee('IgP-bdM_08A');
    }

    public function test_administrator_can_manage_videos_and_publication(): void
    {
        $data = [
            'youtube_url' => 'https://www.youtube.com/shorts/AbCd123_-XY',
            'title' => 'New educational video',
            'display_order' => 0,
        ];
        $this->post('/admin/videos', $data)->assertRedirect('/login');
        $this->actingAs(User::factory()->create(['role' => 'editor', 'active' => true]));
        $this->post('/admin/videos', $data)->assertForbidden();

        $this->actingAs(User::factory()->create(['role' => 'administrator', 'active' => true]));
        $this->get('/admin/videos')->assertOk();
        $this->postJson('/admin/videos', array_replace($data, [
            'youtube_url' => 'https://example.com/watch?v=AbCd123_-XY',
        ]))->assertJsonValidationErrors('youtube_id');
        $this->post('/admin/videos', $data)->assertRedirect();
        $this->postJson('/admin/videos', $data)->assertJsonValidationErrors('youtube_id');

        $video = TreatmentVideo::where('youtube_id', 'AbCd123_-XY')->firstOrFail();
        $this->get('/treatment-videos')->assertDontSee($video->title);
        $this->put('/admin/videos/'.$video->id, $data + ['published' => 1])->assertRedirect();
        $this->get('/treatment-videos')->assertSee($video->title);
        $this->delete('/admin/videos/'.$video->id)->assertRedirect();
        $this->get('/treatment-videos')->assertDontSee($video->title);
    }
}
