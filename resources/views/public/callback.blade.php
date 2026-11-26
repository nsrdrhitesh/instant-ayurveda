<section class="reference-callback" aria-labelledby="callback-title">
    <h2 id="callback-title">{{ $experience['home_callback_title'] }}</h2>
    @if($errors->any())
        <div class="notice" role="alert">{{ $errors->first() }}</div>
    @endif
    <form action="{{ route('consultation.submit') }}" method="post" class="inquiry-form" data-private-form>
        @csrf
        <input type="hidden" name="source" value="homepage_callback">
        <input type="hidden" name="submission_key" value="{{ $formToken['submission_key'] }}">
        <input type="hidden" name="form_signature" value="{{ $formToken['form_signature'] }}">
        <input type="hidden" name="country_code" value="+91">
        <input type="hidden" name="interest" value="Ayurvedic consultation">
        <input type="hidden" name="session_preference" value="No preference / Help me decide">
        <input type="hidden" name="contact_method" value="phone">
        <div class="hp" aria-hidden="true"><label>Leave this empty<input name="website" tabindex="-1" autocomplete="off"></label></div>
        <div class="form-result" role="status" tabindex="-1" hidden></div>
        <label>Your name <input name="full_name" autocomplete="name" required minlength="2" maxlength="120"></label>
        <label>Phone number <input name="mobile" type="tel" autocomplete="tel" required maxlength="20"></label>
        <label>Service <select name="service_id">
            <option value="">Select a service</option>
            @foreach($services as $service)<option value="{{ $service->id }}">{{ $service->name }}</option>@endforeach
        </select></label>
        <label class="consent"><input type="checkbox" name="consent" value="1" required><span>{{ $website['consent_copy'] }} <a href="{{ route('privacy') }}">Privacy notice</a></span></label>
        <button class="btn" type="submit">Request a call back</button>
    </form>
    @if($experience['home_urgent_phone'])
        <p class="reference-emergency">Urgent enquiries <a href="tel:{{ preg_replace('/[^0-9+]/', '', $experience['home_urgent_phone']) }}">{{ $experience['home_urgent_phone'] }}</a></p>
    @endif
</section>
