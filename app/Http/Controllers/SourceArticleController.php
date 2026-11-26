<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Post;
use App\Services\Editorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SourceArticleController extends Controller
{
    public function store(Request $request, Editorial $editorial)
    {
        $articles = json_decode(file_get_contents(database_path('content/instant-ayurved-articles.json')), true, flags: JSON_THROW_ON_ERROR);
        $actor = $request->user()->id;
        $imported = DB::transaction(function () use ($articles, $editorial, $actor) {
            DB::table('staff_locks')->where('id', 1)->lockForUpdate()->first();
            $count = 0;

            foreach ($articles as $article) {
                $slug = Str::slug($article['title']);
                $sourceImage = $article['source_image'] ?? null;
                unset($article['source_image']);

                $existing = Post::withTrashed()->where('slug', $slug)->first();
                if ($existing) {
                    if (!$existing->trashed() && $existing->status === 'draft' && !$existing->media_id
                        && $sourceImage && $existing->title === $article['title']) {
                        $media = $this->importImage($sourceImage, $article['title'], $actor);
                        $existing->update(['media_id' => $media->id, 'version' => $existing->version + 1]);
                    }
                    continue;
                }
                if (DB::table('post_slugs')->where('slug', $slug)->exists()) {
                    continue;
                }

                $media = $sourceImage ? $this->importImage($sourceImage, $article['title'], $actor) : null;
                $editorial->save(null, $article + [
                    'slug' => $slug,
                    'status' => 'draft',
                    'author_id' => $actor,
                    'media_id' => $media?->id,
                    'seo_title' => Str::limit($article['title'], 70),
                    'seo_description' => Str::limit($article['excerpt'] ?: Str::squish(strip_tags($article['body_html'])), 155),
                ], $actor);
                $count++;
            }

            return $count;
        });

        return back()->with('success', "{$imported} source drafts imported. Review the content and assign the correct author before publishing.");
    }

    private function importImage(string $image, string $title, int $actor): Media
    {
        $path = public_path('images/instant-ayurved/img/blogs/'.$image);
        [$width, $height] = getimagesize($path);
        $filename = sha1_file($path).'.png';
        $bytes = file_get_contents($path);
        $stored = Storage::disk('local')->put('blog-media/'.$filename, $bytes);
        abort_unless($stored, 500, 'Source image could not be saved.');

        return Media::firstOrCreate(['filename' => $filename], [
            'user_id' => $actor,
            'mime' => 'image/png',
            'bytes' => strlen($bytes),
            'width' => $width,
            'height' => $height,
            'alt' => Str::limit($title, 255),
        ]);
    }
}
