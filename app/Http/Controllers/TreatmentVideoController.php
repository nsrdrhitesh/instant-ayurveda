<?php

namespace App\Http\Controllers;

use App\Models\TreatmentVideo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TreatmentVideoController extends Controller
{
    public function index()
    {
        return view('centre.videos', ['videos' => TreatmentVideo::orderBy('display_order')->orderBy('id')->get()]);
    }

    public function store(Request $request)
    {
        TreatmentVideo::create($this->validated($request));
        return back()->with('success', 'Video added.');
    }

    public function update(Request $request, TreatmentVideo $video)
    {
        $video->update($this->validated($request, $video));
        return back()->with('success', 'Video updated.');
    }

    public function destroy(TreatmentVideo $video)
    {
        $video->delete();
        return back()->with('success', 'Video removed.');
    }

    private function validated(Request $request, ?TreatmentVideo $video = null): array
    {
        $input = $request->validate(['youtube_url' => ['required', 'url:https', 'max:1000']]);
        $url = parse_url($input['youtube_url']);
        $path = explode('/', trim($url['path'] ?? '', '/'));
        parse_str($url['query'] ?? '', $query);
        $id = match (strtolower($url['host'] ?? '')) {
            'youtu.be' => $path[0],
            'youtube.com', 'www.youtube.com', 'm.youtube.com' => match ($path[0]) {
                'watch' => $query['v'] ?? null,
                'embed', 'shorts', 'live' => $path[1] ?? null,
                default => null,
            },
            default => null,
        };

        $request->merge([
            'youtube_id' => is_string($id) ? $id : null,
            'featured' => $request->boolean('featured'),
            'published' => $request->boolean('published'),
        ]);

        $unique = Rule::unique('treatment_videos', 'youtube_id');
        if ($video) {
            $unique->ignore($video);
        }

        return $request->validate([
            'youtube_id' => ['required', 'regex:/\\A[A-Za-z0-9_-]{11}\\z/', $unique],
            'title' => ['required', 'string', 'max:180'],
            'description' => ['nullable', 'string', 'max:3000'],
            'category' => ['nullable', 'string', 'max:100'],
            'featured' => ['boolean'],
            'published' => ['boolean'],
            'display_order' => ['required', 'integer', 'between:0,9999'],
        ], [
            'youtube_id.required' => 'Enter a supported YouTube video URL.',
            'youtube_id.regex' => 'The YouTube URL must contain a valid video ID.',
            'youtube_id.unique' => 'This video already appears in the catalogue.',
        ]);
    }
}
