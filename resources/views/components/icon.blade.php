@props(['name'])
<svg {{ $attributes->merge(['class' => 'icon']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
@switch($name)
    @case('arrow-right')
    @case('arrow')<path d="M4 12h15m-6-6 6 6-6 6"/>@break
    @case('arrow-up')<path d="M6 18 18 6M6 6h12v12"/>@break
    @case('close')<path d="m6 6 12 12M18 6 6 18"/>@break
    @case('search')<circle cx="10.5" cy="10.5" r="6.5"/><path d="m16 16 5 5"/>@break
    @case('github')<path d="M9 19c-4 1-4-2-6-2m12 5v-4a3.5 3.5 0 0 0-1-2.7c3.3-.4 6.8-1.6 6.8-7.3A5.7 5.7 0 0 0 19.3 4a5.3 5.3 0 0 0-.1-4S18 0 15 1.6a14 14 0 0 0-6 0C6 0 4.8 0 4.8 0a5.3 5.3 0 0 0-.1 4A5.7 5.7 0 0 0 3.2 8c0 5.7 3.5 6.9 6.8 7.3A3.5 3.5 0 0 0 9 18v4" transform="translate(0 1) scale(.95)"/>@break
    @case('check')<path d="m5 12 4 4L19 6"/>@break
    @case('code')<path d="m8 6-6 6 6 6m8-12 6 6-6 6M14 3l-4 18"/>@break
    @case('sliders')<path d="M4 6h16M4 12h16M4 18h16"/><path d="M8 3v6m8 0v6m-5 0v6"/>@break
    @case('choice')
    @case('cookie')<path d="M12 3a9 9 0 1 0 9 9 3.3 3.3 0 0 1-3.3-3.3 3.3 3.3 0 0 1-3.3-3.3A3.3 3.3 0 0 1 12 3Z"/><circle cx="8" cy="10" r=".7"/><circle cx="12" cy="16" r=".7"/><circle cx="7" cy="15" r=".5"/>@break
    @case('keyboard')<rect x="2" y="5" width="20" height="14" rx="1"/><path d="M6 9h1m3 0h1m3 0h1m3 0h1M6 13h1m3 0h1m3 0h1m3 0h1M8 16h8"/>@break
    @case('layers')<path d="m12 3 10 5-10 5L2 8l10-5ZM2 12l10 5 10-5M2 16l10 5 10-5"/>@break
    @case('clock')<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>@break
    @case('copy')<rect x="8" y="8" width="12" height="13" rx="1"/><path d="M15 8V3H3v13h5"/>@break
    @case('refresh')<path d="M20 7v5h-5M4 17v-5h5M5 7a8 8 0 0 1 13-2l2 3M4 16l2 3a8 8 0 0 0 13-2"/>@break
    @case('globe')<circle cx="12" cy="12" r="9"/><ellipse cx="12" cy="12" rx="4" ry="9"/><path d="M3 12h18"/>@break
    @case('align-left')<rect x="3" y="4" width="18" height="16"/><path d="M6 14h5v3H6z"/>@break
    @case('align-center')<rect x="3" y="4" width="18" height="16"/><path d="M6 14h12v3H6z"/>@break
    @case('align-right')<rect x="3" y="4" width="18" height="16"/><path d="M13 14h5v3h-5z"/>@break
@endswitch
</svg>
