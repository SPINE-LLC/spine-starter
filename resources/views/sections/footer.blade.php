<footer id="colophon" class="content-info">
  @php(dynamic_sidebar('sidebar-footer'))

  @if (has_nav_menu('footer_navigation'))
    <nav class="nav-footer" aria-label="{{ wp_get_nav_menu_name('footer_navigation') }}">
      {!! \App\footer_nav() !!}
    </nav>
  @endif

  @if (has_nav_menu('privacy_navigation'))
    <nav class="nav-privacy" aria-label="{{ wp_get_nav_menu_name('privacy_navigation') }}">
      {!! \App\privacy_nav() !!}
    </nav>
  @endif

  <p class="copyright"><small>&copy; {{ wp_date('Y') }} {{ $siteName }}</small></p>
</footer>
