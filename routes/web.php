<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController,AdminController,UserController,PostController,TaxonomyController,MediaController,CommentController,ScriptController,BlogController};
Route::get('/',[\App\Http\Controllers\CentreController::class,'home'])->name('home');
Route::get('/services',[\App\Http\Controllers\CentreController::class,'services'])->name('services');
Route::get('/services/{slug}',[\App\Http\Controllers\CentreController::class,'service'])->name('service');
Route::get('/our-story',[\App\Http\Controllers\CentreController::class,'story'])->name('our-story');
Route::get('/client-stories',[\App\Http\Controllers\CentreController::class,'stories'])->name('client-stories');
Route::get('/reviews',[\App\Http\Controllers\CentreController::class,'reviews'])->name('reviews');
Route::post('/reviews',[\App\Http\Controllers\ReviewController::class,'submit'])->middleware('throttle:reviews')->name('reviews.submit');
Route::get('/contact',[\App\Http\Controllers\CentreController::class,'contact'])->name('contact');
Route::post('/consultation',[\App\Http\Controllers\InquiryController::class,'store'])->middleware('throttle:inquiries')->name('consultation.submit');
Route::post('/newsletter',[\App\Http\Controllers\NewsletterController::class,'store'])->middleware('throttle:5,1')->name('newsletter.store');
Route::get('/privacy',[\App\Http\Controllers\CentreController::class,'privacy'])->name('privacy');
Route::get('/about',[\App\Http\Controllers\CentreController::class,'about'])->name('about');
Route::get('/doctor-tejas-kadam',[\App\Http\Controllers\CentreController::class,'doctor'])->name('doctor');
Route::get('/facility',[\App\Http\Controllers\CentreController::class,'facility'])->name('facility');
Route::get('/treatment-videos',[\App\Http\Controllers\CentreController::class,'treatments'])->name('treatment-videos');
Route::get('/terms',[\App\Http\Controllers\CentreController::class,'terms'])->name('terms');
Route::any('/register',fn()=>abort(404))->name('register');
Route::middleware('guest')->group(function(){Route::get('/login',[AuthController::class,'show'])->name('login');Route::post('/login',[AuthController::class,'login'])->middleware('throttle:login');});
Route::post('/logout',[AuthController::class,'logout'])->middleware('auth')->name('logout');
Route::middleware(['auth','staff'])->prefix('admin')->group(function(){
 Route::get('/',AdminController::class)->name('admin');
 Route::post('/services/reorder',[\App\Http\Controllers\ServiceController::class,'reorder'])->name('services-admin.reorder');
 Route::post('/services/{service}/restore',[\App\Http\Controllers\ServiceController::class,'restore'])->name('services-admin.restore');
 Route::get('/services/{service}/preview',[\App\Http\Controllers\ServiceController::class,'preview'])->name('services-admin.preview');
 Route::resource('services',\App\Http\Controllers\ServiceController::class)->names('services-admin');
 Route::get('/faqs/draft-helper',[\App\Http\Controllers\FaqController::class,'generate'])->name('faqs.generate');
 Route::post('/faqs/draft-helper',[\App\Http\Controllers\FaqController::class,'acceptDrafts'])->name('faqs.accept');
 Route::post('/faqs/{faq}/restore',[\App\Http\Controllers\FaqController::class,'restore'])->name('faqs.restore');
 Route::resource('faqs',\App\Http\Controllers\FaqController::class);
 Route::resource('inquiries',\App\Http\Controllers\InquiryController::class)->only(['index','show','update','destroy']);
 Route::middleware('admin')->group(function(){
 Route::resource('videos',\App\Http\Controllers\TreatmentVideoController::class)->only(['index','store','update','destroy'])->names('videos-admin');
 Route::get('/locations',[\App\Http\Controllers\LocationController::class,'index'])->name('locations.index');
 Route::post('/locations',[\App\Http\Controllers\LocationController::class,'store'])->name('locations.store');
 Route::put('/locations/{location}',[\App\Http\Controllers\LocationController::class,'update'])->name('locations.update');
 Route::delete('/locations/{location}',[\App\Http\Controllers\LocationController::class,'destroy'])->name('locations.destroy');
 Route::post('/inquiries/{inquiry}/restore',[\App\Http\Controllers\InquiryController::class,'restore'])->name('inquiries.restore');
 Route::post('/inquiries/{inquiry}/redact',[\App\Http\Controllers\InquiryController::class,'redact'])->name('inquiries.redact');
 Route::post('/stories/{story}/restore',[\App\Http\Controllers\StoryController::class,'restore'])->name('stories.restore');
 Route::resource('stories',\App\Http\Controllers\StoryController::class);
 Route::post('/reviews/{review}/restore',[\App\Http\Controllers\ReviewController::class,'restore'])->name('reviews-admin.restore');
 Route::resource('reviews',\App\Http\Controllers\ReviewController::class)->names('reviews-admin');
 Route::post('/experience/import-articles',[\App\Http\Controllers\SourceArticleController::class,'store'])->name('experience.import-articles');
 Route::get('/newsletter',[\App\Http\Controllers\NewsletterController::class,'index'])->name('newsletter.index');
 Route::get('/experience',[\App\Http\Controllers\ExperienceController::class,'edit'])->name('experience.edit');
 Route::put('/experience',[\App\Http\Controllers\ExperienceController::class,'update'])->name('experience.update');
 Route::get('/website',[\App\Http\Controllers\WebsiteController::class,'edit'])->name('website.edit');
 Route::put('/website',[\App\Http\Controllers\WebsiteController::class,'update'])->name('website.update');
 });

 Route::middleware('admin')->group(function(){Route::post('/users/{user}/restore',[UserController::class,'restore'])->name('users.restore');Route::resource('users',UserController::class);Route::post('/blogs/{blog}/scripts',[ScriptController::class,'save'])->name('scripts.save');Route::post('/scripts/disable',[ScriptController::class,'disable'])->name('scripts.disable');});
 Route::post('/blogs/bulk',[PostController::class,'bulk'])->name('blogs.bulk');
 Route::post('/blogs/{blog}/restore',[PostController::class,'restore'])->name('blogs.restore');
 Route::post('/blogs/{blog}/autosave',[PostController::class,'autosave'])->middleware('throttle:60,1')->name('blogs.autosave');
 Route::post('/blogs/{blog}/revision/{revision}',[PostController::class,'revision'])->name('blogs.revision');
 Route::get('/blogs/{blog}/preview',[BlogController::class,'preview'])->name('blogs.preview');Route::resource('blogs',PostController::class);
 Route::get('/taxonomy/{kind}',[TaxonomyController::class,'index'])->where('kind','categories|tags')->name('taxonomy.index');
 Route::post('/taxonomy/{kind}/{id?}',[TaxonomyController::class,'save'])->where('kind','categories|tags')->name('taxonomy.save');
 Route::delete('/taxonomy/{kind}/{id}',[TaxonomyController::class,'destroy'])->where('kind','categories|tags')->name('taxonomy.destroy');
 Route::post('/media',[MediaController::class,'store'])->middleware('throttle:uploads')->name('media.store');
 Route::post('/content-preview',function(\Illuminate\Http\Request $r){$d=$r->validate(['body_html'=>['nullable','string','max:500000']]);return response()->json(['html'=>app(\App\Services\ArticleContent::class)->sanitize($d['body_html']??'')]);})->middleware('throttle:60,1');
 Route::get('/comments',[CommentController::class,'index'])->name('comments.index');Route::post('/comments/moderate',[CommentController::class,'moderate'])->name('comments.moderate');
});
Route::get('/media/{filename}',[MediaController::class,'show'])->name('media.show');
Route::get('/blog',[BlogController::class,'index'])->name('blog.index');
Route::get('/blog/archive/{kind}/{slug}',[BlogController::class,'index'])->where('kind','category|tag')->name('blog.archive');
Route::get('/blog/{slug}',[BlogController::class,'show'])->name('blog.show');
Route::post('/blog/{slug}/comments',[CommentController::class,'store'])->middleware('throttle:comments')->name('blog.comment');
Route::get('/sitemap.xml',[BlogController::class,'sitemap'])->name('sitemap');

Route::get('/robots.txt', function () {
    return response("User-agent: *\nDisallow: /admin/\nSitemap: ".route('sitemap')."\n")
        ->header('Content-Type', 'text/plain; charset=UTF-8');
})->name('robots');

foreach ([
    '/index.php' => 'home',
    '/about.php' => 'about',
    '/about-dr-tejas-kadam.php' => 'doctor',
    '/about-our-facility.php' => 'facility',
    '/services.php' => 'services',
    '/treatments.php' => 'treatment-videos',
    '/blog.php' => 'blog.index',
    '/gallery.php' => 'facility',
    '/testimonials.php' => 'reviews',
    '/contact.php' => 'contact',
    '/terms-conditions.php' => 'terms',
    '/privacy-policy.php' => 'privacy',
] as $legacyPath => $destination) {
    Route::get($legacyPath, fn () => redirect()->route($destination, [], 301));
}

Route::get('/service-{slug}.php', fn (string $slug) => redirect()->route('service', ['slug' => $slug], 301))
    ->where('slug', 'ayurvedic-medicine|ayurvedic-surgery|ayurvedic-diet|yoga-therapy|panchakarma');