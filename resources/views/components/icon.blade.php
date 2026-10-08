{{--
Icon geometry from lucide-static@1.52.0 (https://lucide.dev), rendered without JavaScript.
Banner position icons use custom project geometry.

ISC License

Copyright (c) 2026 Lucide Icons and Contributors

Permission to use, copy, modify, and/or distribute this software for any
purpose with or without fee is hereby granted, provided that the above
copyright notice and this permission notice appear in all copies.

THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF
MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR
ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES
WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN
ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF
OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.

---

The following Lucide icons are derived from the Feather project:

airplay, alert-circle, alert-octagon, alert-triangle, aperture, arrow-down-circle, arrow-down-left, arrow-down-right, arrow-down, arrow-left-circle, arrow-left, arrow-right-circle, arrow-right, arrow-up-circle, arrow-up-left, arrow-up-right, arrow-up, at-sign, calendar, cast, check, chevron-down, chevron-left, chevron-right, chevron-up, chevrons-down, chevrons-left, chevrons-right, chevrons-up, circle, clipboard, clock, code, columns, command, compass, corner-down-left, corner-down-right, corner-left-down, corner-left-up, corner-right-down, corner-right-up, corner-up-left, corner-up-right, crosshair, database, divide-circle, divide-square, dollar-sign, download, external-link, feather, frown, hash, headphones, help-circle, info, italic, key, layout, life-buoy, link-2, link, loader, lock, log-in, log-out, maximize, meh, minimize, minimize-2, minus-circle, minus-square, minus, monitor, moon, more-horizontal, more-vertical, move, music, navigation-2, navigation, octagon, pause-circle, percent, plus-circle, plus-square, plus, power, radio, rss, search, server, share, shopping-bag, sidebar, smartphone, smile, square, table-2, tablet, target, terminal, trash-2, trash, triangle, tv, type, upload, x-circle, x-octagon, x-square, x, zoom-in, zoom-out

The MIT License (MIT) (for the icons listed above)

Copyright (c) 2013-present Cole Bemis

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
--}}
@props(['name'])
<svg {{ $attributes->merge(['class' => 'icon lucide']) }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
@switch($name)
    @case('arrow-right')
    @case('arrow')
        <path d="M5 12h14" />
        <path d="m12 5 7 7-7 7" />
        @break
    @case('arrow-left')
        <path d="m12 19-7-7 7-7" />
        <path d="M19 12H5" />
        @break
    @case('arrow-up-right')
    @case('arrow-up')
        <path d="M7 7h10v10" />
        <path d="M7 17 17 7" />
        @break
    @case('arrow-down-left')
        <path d="M17 7 7 17" />
        <path d="M17 17H7V7" />
        @break
    @case('arrow-down-right')
        <path d="m7 7 10 10" />
        <path d="M17 7v10H7" />
        @break
    @case('chevron-down')
        <path d="m6 9 6 6 6-6" />
        @break
    @case('chevron-up')
        <path d="m18 15-6-6-6 6" />
        @break
    @case('x')
    @case('close')
        <path d="M18 6 6 18" />
        <path d="m6 6 12 12" />
        @break
    @case('search')
        <path d="m21 21-4.34-4.34" />
        <circle cx="11" cy="11" r="8" />
        @break
    @case('git-fork')
    @case('github')
        <circle cx="12" cy="18" r="3" />
        <circle cx="6" cy="6" r="3" />
        <circle cx="18" cy="6" r="3" />
        <path d="M18 9v2c0 .6-.4 1-1 1H7c-.6 0-1-.4-1-1V9" />
        <path d="M12 12v3" />
        @break
    @case('check')
        <path d="M20 6 9 17l-5-5" />
        @break
    @case('code-xml')
    @case('code')
        <path d="m18 16 4-4-4-4" />
        <path d="m6 8-4 4 4 4" />
        <path d="m14.5 4-5 16" />
        @break
    @case('sliders-horizontal')
    @case('sliders')
        <path d="M10 5H3" />
        <path d="M12 19H3" />
        <path d="M14 3v4" />
        <path d="M16 17v4" />
        <path d="M21 12h-9" />
        <path d="M21 19h-5" />
        <path d="M21 5h-7" />
        <path d="M8 10v4" />
        <path d="M8 12H3" />
        @break
    @case('cookie')
    @case('choice')
        <path d="M11 17h.01" />
        <path d="M11.496 2c.324-.016.558.292.529.615a4 4 0 004.235 4.368.713.713 0 01.758.757 4 4 0 004.366 4.237c.323-.03.63.204.614.527a10 10 0 01-2.915 6.566A1 1 0 114.93 4.918 10 10 0 0111.496 2" />
        <path d="M12 12h.01" />
        <path d="M16 16h.01" />
        <path d="M16 3h.01" />
        <path d="M21 4h.01" />
        <path d="M21 8h.01" />
        <path d="M7 14h.01" />
        <path d="M9 8h.01" />
        @break
    @case('keyboard')
        <path d="M10 8h.01" />
        <path d="M12 12h.01" />
        <path d="M14 8h.01" />
        <path d="M16 12h.01" />
        <path d="M18 8h.01" />
        <path d="M6 8h.01" />
        <path d="M7 16h10" />
        <path d="M8 12h.01" />
        <rect width="20" height="16" x="2" y="4" rx="2" />
        @break
    @case('layers')
        <path d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z" />
        <path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12" />
        <path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17" />
        @break
    @case('clock')
        <circle cx="12" cy="12" r="10" />
        <path d="M12 6v6l4 2" />
        @break
    @case('copy')
        <rect width="14" height="14" x="8" y="8" rx="2" ry="2" />
        <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2" />
        @break
    @case('rotate-ccw')
    @case('refresh')
        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
        <path d="M3 3v5h5" />
        @break
    @case('globe')
        <circle cx="12" cy="12" r="10" />
        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20" />
        <path d="M2 12h20" />
        @break
    @case('align-horizontal-justify-start')
    @case('align-left')
        <rect width="6" height="14" x="6" y="5" rx="2" />
        <rect width="6" height="10" x="16" y="7" rx="2" />
        <path d="M2 2v20" />
        @break
    @case('align-horizontal-justify-center')
    @case('align-center')
        <rect width="6" height="14" x="2" y="5" rx="2" />
        <rect width="6" height="10" x="16" y="7" rx="2" />
        <path d="M12 2v20" />
        @break
    @case('align-horizontal-justify-end')
    @case('align-right')
        <rect width="6" height="14" x="2" y="5" rx="2" />
        <rect width="6" height="10" x="12" y="7" rx="2" />
        <path d="M22 2v20" />
        @break
    @case('banner-left')
        <rect width="20" height="18" x="2" y="3" rx="2" stroke-opacity=".4" />
        <path d="M2 8h20" stroke-opacity=".4" />
        <rect width="7" height="6" x="5" y="12" rx="1" fill="currentColor" fill-opacity=".2" />
        @break
    @case('banner-center')
        <rect width="20" height="18" x="2" y="3" rx="2" stroke-opacity=".4" />
        <path d="M2 8h20" stroke-opacity=".4" />
        <rect width="14" height="6" x="5" y="12" rx="1" fill="currentColor" fill-opacity=".2" />
        @break
    @case('banner-right')
        <rect width="20" height="18" x="2" y="3" rx="2" stroke-opacity=".4" />
        <path d="M2 8h20" stroke-opacity=".4" />
        <rect width="7" height="6" x="12" y="12" rx="1" fill="currentColor" fill-opacity=".2" />
        @break
    @case('plus')
        <path d="M5 12h14" />
        <path d="M12 5v14" />
        @break
    @case('minus')
        <path d="M5 12h14" />
        @break
@endswitch
</svg>
