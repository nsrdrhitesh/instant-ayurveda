<form method="post" action="{{ route('newsletter.store') }}" class="reference-newsletter" id="newsletter">
    @csrf
    <h3>{{ $website['newsletter_title'] ?? 'Subscribe to Newsletter' }}</h3>
    @if(session('newsletter_success'))<p role="status">{{ session('newsletter_success') }}</p>@endif
    @foreach($errors->newsletter->all() as $error)<p role="alert">{{ $error }}</p>@endforeach
    <label>Email address <input type="email" autocomplete="email" name="newsletter_email" maxlength="254" required></label>
    <label class="consent"><input type="checkbox" name="newsletter_consent" value="1" required> I agree to receive newsletter emails.</label>
    <button type="submit" class="btn btn-small">Subscribe</button>
</form>
