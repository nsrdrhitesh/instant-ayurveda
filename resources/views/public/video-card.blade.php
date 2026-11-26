<article class="journal-card">
    <a href="https://youtu.be/{{ $video->youtube_id }}">
        <img loading="lazy" width="480" height="360" src="https://i.ytimg.com/vi/{{ $video->youtube_id }}/hqdefault.jpg" alt="">
        <h3>{{ $video->title }}</h3>
    </a>
    @if($video->description)
        <p>{{ $video->description }}</p>
    @endif
</article>
