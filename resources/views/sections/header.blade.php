<header id="masthead" class="banner">
  <a class="brand" href="{{ home_url('/') }}">
    @if (has_custom_logo())
      {!! wp_get_attachment_image(get_theme_mod('custom_logo'), ['',56]) !!}
    @else
      {!! $siteName !!}
    @endif
  </a>

  @if (has_nav_menu('primary_navigation'))
    <nav class="nav-primary" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
      {!! \App\primary_nav() !!}

      @if (has_nav_menu('primary_buttons'))
        {!! \App\primary_btns_nav() !!}
      @endif
    </nav>
  @endif
</header>
