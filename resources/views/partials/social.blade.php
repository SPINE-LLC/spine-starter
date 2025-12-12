@php
/**
 * Social Links
 */

$fb_url = get_theme_mod( 'organization_fb_url', '' );
$x_url  = get_theme_mod( 'organization_x_url', '' );
$li_url = get_theme_mod( 'organization_li_url', '' );
$yt_url = get_theme_mod( 'organization_yt_url', '' );
$yt_sub = get_theme_mod( 'organization_yt_sub', true );
$ig_url = get_theme_mod( 'organization_ig_url', '' );
$sc_url = get_theme_mod( 'organization_sc_url', '' );
@endphp

@if( $fb_url )
	<a class="fb-icn" href="{{ esc_url( $fb_url ) }}" target="_blank" rel="noreferrer noopener" aria-label="{{ esc_attr__( 'Visit us on Facebook (opens in a new tab)', 'sage' ) }}" title="{{ esc_attr__( 'Visit us on Facebook', 'sage' ) }}">
		<svg viewBox="0 0 13 24" width="13" height="24" role="img">
			<title>{{ esc_html__( 'Facebook Icon', 'sage' ) }}</title>
			<path fill="currentColor" d="M12 13.07l.55-4.28H8.34V6.07c0-1.24.34-2.07 2.14-2.07h2.26V.17A28.29 28.29 0 0 0 9.42 0C6.17 0 3.94 2 3.94 5.64v3.15H.26v4.26h3.68V24h4.4V13.07z"/>
		</svg>
	</a>
@endif
@if( $x_url )
	<a class="tw-icn" href="{{ esc_url( $x_url ) }}" target="_blank" rel="noreferrer noopener" aria-label="{{ esc_attr__( 'Visit us on Twitter (opens in a new tab)', 'sage' ) }}" title="{{ esc_attr__( 'Visit us on Twitter', 'sage' ) }}">
		<svg viewBox="0 0 24 24" width="24" height="24" role="img">
			<title>{{ esc_html__( 'Twitter Icon', 'sage' ) }}</title>
			<path fill="currentColor" d="M24 4.57a9.89 9.89 0 0 1-2.82.77 5 5 0 0 0 2.16-2.72 9.84 9.84 0 0 1-3.18 1.18 4.92 4.92 0 0 0-8.51 3.36 5.22 5.22 0 0 0 .13 1.13A14 14 0 0 1 1.64 3.16 4.79 4.79 0 0 0 1 5.64a4.9 4.9 0 0 0 2.16 4.09 5 5 0 0 1-2.23-.61v.06a4.92 4.92 0 0 0 4 4.82 5 5 0 0 1-1.3.17 5.5 5.5 0 0 1-.91-.08 4.94 4.94 0 0 0 4.6 3.42 9.92 9.92 0 0 1-6.1 2.1A9.18 9.18 0 0 1 0 19.54a14 14 0 0 0 7.56 2.21 13.9 13.9 0 0 0 14-14v-.63A9.94 9.94 0 0 0 24 4.59z"/>
		</svg>
	</a>
@endif
@if( $li_url )
	<a class="li-icn" href="{{ esc_url( $li_url ) }}" target="_blank" rel="noreferrer noopener" aria-label="{{ esc_attr__( 'Visit us on LinkedIn (opens in a new tab)', 'sage' ) }}" title="{{ esc_attr__( 'Visit us on LinkedIn', 'sage' ) }}">
		<svg viewBox="0 0 24 24" width="24" height="24" role="img">
			<title>{{ esc_html__( 'LinkedIn Icon', 'sage' ) }}</title>
      <g fill="currentColor">
        <path d="M8.49 8v16h5v-7.94c0-2.09.39-4.1 3-4.1S19 14.34 19 16.2V24h5v-8.8c0-4.31-.93-7.63-6-7.63a5.23 5.23 0 0 0-4.71 2.59h-.07V8z"/>
        <path d="M0.39 7.98H5.37V23.98H0.39z"/>
        <path d="M5.77 2.9a2.89 2.89 0 1 0-2.89 2.89A2.88 2.88 0 0 0 5.77 2.9z"/>
      </g>
		</svg>
	</a>
@endif
@if( $yt_url )
	<a class="yt-icn" href="{{ esc_url( $yt_url ) }}{{ $yt_sub ? '?sub_confirmation=1' : '' }}" target="_blank" rel="noreferrer noopener" aria-label="{{ esc_attr__( 'Visit us on YouTube (opens in a new tab)', 'sage' ) }}" title="{{ esc_attr__( 'Visit us on YouTube', 'sage' ) }}">
		<svg viewBox="0 0 24 24" width="24" height="24" role="img">
			<title>{{ esc_html__( 'YouTube Icon', 'sage' ) }}</title>
			<path fill="currentColor" d="M23.5 6.2a3 3 0 0 0-2.09-2.08c-1.87-.5-9.4-.5-9.4-.5s-7.51 0-9.39.5A3 3 0 0 0 .53 6.2 31.48 31.48 0 0 0 0 12a31.08 31.08 0 0 0 .53 5.78 3 3 0 0 0 2.09 2.09c1.86.5 9.39.5 9.39.5s7.51 0 9.4-.5a3 3 0 0 0 2.08-2.09A30.22 30.22 0 0 0 24 12a31.44 31.44 0 0 0-.5-5.8zM9.61 15.6V8.41L15.87 12z"/>
		</svg>
	</a>
@endif
@if( $ig_url )
	<a class="ig-icn" href="{{ esc_url( $ig_url ) }}" target="_blank" rel="noreferrer noopener" aria-label="{{ esc_attr__( 'Visit us on Instagram (opens in a new tab)', 'sage' ) }}" title="{{ esc_attr__( 'Visit us on Instagram', 'sage' ) }}">
		<svg viewBox="0 0 24 24" width="24" height="24" role="img">
			<title>{{ esc_html__( 'Instagram Icon', 'sage' ) }}</title>
			<path fill="currentColor" d="M12 0C8.74 0 8.33 0 7.05.07a8.82 8.82 0 0 0-2.91.56A6.07 6.07 0 0 0 .63 4.14a8.82 8.82 0 0 0-.56 2.91C0 8.33 0 8.74 0 12s0 3.67.07 5a8.76 8.76 0 0 0 .56 2.91A6 6 0 0 0 2 22a5.91 5.91 0 0 0 2.13 1.38 8.82 8.82 0 0 0 2.91.56C8.33 24 8.74 24 12 24s3.67 0 4.95-.07a8.76 8.76 0 0 0 2.91-.56A6 6 0 0 0 22 22a5.91 5.91 0 0 0 1.38-2.13 8.82 8.82 0 0 0 .55-2.87c.07-1.33.07-1.74.07-5s0-3.67-.07-4.95a8.76 8.76 0 0 0-.56-2.91A6.07 6.07 0 0 0 19.86.63 8.76 8.76 0 0 0 17 .07C15.67 0 15.26 0 12 0zm0 2.16c3.2 0 3.59 0 4.85.07a6.61 6.61 0 0 1 2.23.42 3.61 3.61 0 0 1 1.38.89 3.61 3.61 0 0 1 .89 1.38 6.42 6.42 0 0 1 .42 2.23c.05 1.27.07 1.65.07 4.85s0 3.59-.08 4.85a6.61 6.61 0 0 1-.42 2.23 3.75 3.75 0 0 1-.9 1.38 3.61 3.61 0 0 1-1.38.89 6.37 6.37 0 0 1-2.23.42c-1.27.05-1.65.07-4.86.07s-3.59 0-4.86-.08a6.61 6.61 0 0 1-2.23-.42 3.6 3.6 0 0 1-1.38-.9 3.63 3.63 0 0 1-.9-1.38 6.61 6.61 0 0 1-.42-2.23c-.05-1.26-.06-1.65-.06-4.84s0-3.59.06-4.87a6.61 6.61 0 0 1 .42-2.23 3.56 3.56 0 0 1 .9-1.38 3.56 3.56 0 0 1 1.38-.9 6.8 6.8 0 0 1 2.22-.42c1.27 0 1.65-.06 4.85-.06zm0 3.68A6.16 6.16 0 1 0 18.16 12 6.16 6.16 0 0 0 12 5.84zM12 16a4 4 0 1 1 4-4 4 4 0 0 1-4 4zm7.85-10.4a1.44 1.44 0 1 1-1.44-1.44 1.45 1.45 0 0 1 1.44 1.44z"/>
		</svg>
	</a>
@endif
@if( $sc_url )
	<a class="sc-icn" href="{{ esc_url( $sc_url ) }}" target="_blank" rel="noreferrer noopener" aria-label="{{ esc_attr__( 'Visit us on Snapchat (opens in a new tab)', 'sage' ) }}" title="{{ esc_attr__( 'Visit us on Snapchat', 'sage' ) }}">
		<svg viewBox="0 0 24 24" width="24" height="24" role="img">
			<title>{{ esc_html__( 'Snapchat Icon', 'sage' ) }}</title>
			<path fill="currentColor" d="M12.21.79a6.4 6.4 0 0 1 5.93 3.82c.52 1.2.4 3.22.29 4.85V10.03a.73.73 0 0 0 .4.09 2.77 2.77 0 0 0 1-.3.94.94 0 0 1 .46-.1 1.4 1.4 0 0 1 .51.09 1 1 0 0 1 .73.83c0 .45-.39.84-1.21 1.17l-.34.12c-.45.14-1.14.36-1.34.81a1.05 1.05 0 0 0 .12.87c.06.14 1.52 3.48 4.79 4a.51.51 0 0 1 .42.51.59.59 0 0 1-.05.22c-.24.57-1.27 1-3.14 1.27a3.06 3.06 0 0 0-.17.57 3.2 3.2 0 0 1-.13.56.53.53 0 0 1-.56.4 3.36 3.36 0 0 1-.53-.07 5.75 5.75 0 0 0-1.28-.07 4.73 4.73 0 0 0-.91.08 4.41 4.41 0 0 0-1.72.88 5.48 5.48 0 0 1-3.3 1.29H11.85a5.32 5.32 0 0 1-3.27-1.28A4.54 4.54 0 0 0 6.87 21a7.56 7.56 0 0 0-.93 0 6.21 6.21 0 0 0-1.27.15 3.07 3.07 0 0 1-.54.07.55.55 0 0 1-.58-.42c-.07-.19-.09-.39-.14-.57a2.45 2.45 0 0 0-.17-.57C1.33 19.39.29 19 .06 18.39a.46.46 0 0 1-.06-.23.51.51 0 0 1 .42-.51c3.26-.54 4.73-3.88 4.79-4a1 1 0 0 0 .12-.86c-.2-.44-.89-.66-1.34-.81a2.69 2.69 0 0 1-.34-.12c-1.11-.44-1.26-.93-1.2-1.28a1.2 1.2 0 0 1 1.17-.79.89.89 0 0 1 .38.03 2.81 2.81 0 0 0 1.11.3.87.87 0 0 0 .48-.12v-.57c-.1-1.62-.23-3.65.3-4.84A6.3 6.3 0 0 1 11.73.81h.42z"/>
		</svg>
	</a>
@endif
