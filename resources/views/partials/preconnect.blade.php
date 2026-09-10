{{-- ============================================================================
    Preconnect — third-party resource origins.
    Warms up connections so render-blocking CDN/font requests skip DNS + TLS setup.
    Include in <head> before any external <link>/<script> tags.

    Usage:
        @include('partials.preconnect')                                        -- Bootstrap/Icons CDN
        @include('partials.preconnect', ['fonts' => true])                     -- + Google Fonts
        @include('partials.preconnect', ['recaptcha' => true])                 -- + Google reCAPTCHA
        @include('partials.preconnect', ['fonts' => true, 'recaptcha' => true])-- + both
    ============================================================================ --}}
{{-- Bootstrap 5 CSS/JS (no-CORS) + Bootstrap Icons WOFF2 font (CORS) from jsDelivr --}}
<link rel="preconnect" href="https://cdn.jsdelivr.net">
<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

@if (!empty($fonts))
    {{-- Google Fonts stylesheet (no-CORS) + font files (CORS) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
@endif

@if (!empty($recaptcha))
    {{-- Google reCAPTCHA script + iframe/assets --}}
    <link rel="preconnect" href="https://www.google.com">
    <link rel="preconnect" href="https://www.gstatic.com">
@endif