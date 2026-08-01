{{--
    Reusable theme toggle button.

    Posts to the `theme.toggle` route. The current theme is read from
    `window.__unigrowthTheme` (injected by the ApplyUserTheme middleware),
    and the button icon + hidden form value are swapped accordingly.

    Usage:
        @include('partials.theme-toggle', [
            'btnClasses'  => 'btn btn-sm text-white border-0',
            'style'       => 'background: rgba(255,255,255,0.1); border-radius: 8px;',
            'formClasses' => '',
        ])
--}}
@php
    $btnClasses  = $btnClasses ?? 'btn btn-sm';
    $formClasses = $formClasses ?? '';
    $style       = $style ?? '';
@endphp

<form method="POST" action="{{ route('theme.toggle') }}" class="theme-toggle-form m-0 {{ $formClasses }}">
    @csrf
    <input type="hidden" name="theme" value="dark" class="theme-toggle-value">
    <button type="submit" class="theme-toggle-btn {{ $btnClasses }}" title="Toggle light / dark mode" style="{{ $style }}">
        <i class="bi bi-moon-stars"></i>
    </button>
</form>

@once
<style>
    .theme-toggle-btn { cursor: pointer; }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var theme = window.__unigrowthTheme || 'light';
        document.querySelectorAll('.theme-toggle-form').forEach(function (form) {
            var input = form.querySelector('.theme-toggle-value');
            var icon = form.querySelector('i');
            if (theme === 'dark') {
                input.value = 'light';
                icon.className = 'bi bi-sun';
            } else {
                input.value = 'dark';
                icon.className = 'bi bi-moon-stars';
            }
        });
    });
</script>
@endonce

