@php
  $logo_id = get_theme_mod('custom_logo');
@endphp
<footer id="colophon" class="content-info">
  <div class="content">
    <div class="top">
      @if($logo_id)
        <div class="logo">
          <a href="{{ home_url('/') }}" rel="home"{{ is_front_page() ? ' aria-current="page"' : '' }}>
            {!! wp_get_attachment_image($logo_id, ['',260]) !!}
          </a>
        </div>
      @endif

      <div class="information">
        @if (has_nav_menu('footer_navigation'))
          <nav class="nav-footer" aria-label="{{ wp_get_nav_menu_name('footer_navigation') }}">
            {!! \App\footer_nav() !!}
          </nav>
        @endif
        @if( App\has_social_links() )
          <nav class="nav-social" aria-label="Social Media">
            @include('partials.social')
          </nav>
        @endif
      </div>
    </div>

    <div class="bottom">
      @if (has_nav_menu('privacy_navigation'))
        <nav class="nav-privacy" aria-label="{{ wp_get_nav_menu_name('privacy_navigation') }}">
          {!! \App\privacy_nav() !!}
        </nav>
      @endif

      <p class="copyright"><small>&copy; {{ wp_date('Y') }} {{ $siteName }}</small></p>
    </div>
  </div>

</footer>
