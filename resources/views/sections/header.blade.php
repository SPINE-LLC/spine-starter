<header id="masthead" class="banner">
  <a id="main-brand" class="brand" href="{{ home_url('/') }}">
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

@php
  $logo_id = get_theme_mod('custom_logo');
  $logo_alt_id = get_theme_mod('custom_logo'); // Assuming same logo, adjust if different
@endphp

<div id="compact-menu" class="compact-menu is-sticky">
  <div id="compact-brand" class="brand h4">
    <a href="{{ home_url('/') }}" rel="home"{{ is_front_page() ? ' aria-current="page"' : '' }}>
      @if ($logo_id)
        {!! wp_get_attachment_image($logo_id, ['',20]) !!}
      @else
        {{ get_bloginfo('name') }}
      @endif
    </a>
  </div>

  <div class="open-buttons">
    <button id="compact-settings" class="compact-settings" command="show-modal" commandfor="settings-menu" aria-label="{{ __('Open Settings', 'sage') }}">
      <svg width="25" height="25" viewBox="0 0 35 35" role="img">
        <title>{{ __('Site Settings', 'sage') }}</title>
        <path d="M17.878,35h-.472c-.129,0-.233,0-.33,0-.351-.009-.619-.021-.867-.04-.127-.009-.255-.023-.378-.037l-.156-.017-1.269-4.222,0,0h0l-.006-.014c-.406-.092-.818-.206-1.224-.337s-.821-.285-1.19-.442l-.008.006c-.025-.011-.05-.02-.074-.028s-.054-.019-.081-.031L8.291,32.492c-.07-.04-.14-.081-.212-.125-.235-.142-.479-.3-.726-.465s-.491-.338-.706-.5-.44-.337-.681-.536c-.123-.1-.244-.207-.362-.31l-.034-.03,1.509-4.154c-.273-.306-.535-.628-.777-.955s-.475-.674-.695-1.037H5.579c-.014-.024-.031-.048-.045-.069s-.035-.052-.051-.079l-4.442.122c-.079-.178-.169-.386-.254-.6-.108-.274-.211-.554-.305-.833S.3,22.37.221,22.081c-.076-.27-.148-.555-.215-.847l0-.006a.032.032,0,0,1,0-.008l3.707-2.488c-.038-.381-.058-.776-.062-1.173H3.626c0-.481.019-.9.057-1.284l-.026-.017c0-.02,0-.041,0-.059s0-.042,0-.063L0,13.679c.068-.292.129-.532.192-.757.075-.266.163-.55.263-.844s.2-.56.305-.833c.068-.172.145-.345.218-.512l.041-.094L5.5,10.76A13.605,13.605,0,0,1,7.169,8.5l-.011-.034,0-.006,0-.006L5.68,4.359l.1-.089c.052-.046.1-.093.159-.137.242-.2.465-.374.681-.536s.449-.326.706-.5.49-.322.726-.465c.077-.047.157-.091.234-.135l.123-.069,3.56,2.684a14.228,14.228,0,0,1,2.676-.836l1.266-4.2.123-.013c.05-.006.1-.012.151-.015.283-.021.566-.035.865-.042h.544c.129,0,.234,0,.329,0,.351.009.619.021.868.04.124.009.249.023.37.036L19.325.1l1.269,4.222H20.6l.006.014c.406.092.818.206,1.223.337s.821.285,1.19.442l.008-.006c.025.011.051.02.075.029s.054.019.08.031l3.526-2.661c.067.038.134.078.212.125.237.143.481.3.726.465s.489.336.706.5.444.34.681.535c.118.1.234.2.347.3l.049.042L27.921,8.626c.273.306.534.627.777.955s.475.674.695,1.037h.028c.014.023.03.046.045.068s.036.052.051.079l4.442-.122c.079.177.17.387.255.6.108.273.211.554.305.833s.179.555.26.842.149.557.215.847a.035.035,0,0,0,0,.007.03.03,0,0,1,0,.007l-3.708,2.488c.038.382.058.777.062,1.173h.021c0,.482-.019.9-.057,1.284l.026.017c0,.019,0,.04,0,.059s0,.042,0,.063L35,21.321c-.068.294-.13.535-.192.757-.074.265-.163.549-.263.844-.094.28-.2.56-.305.833-.067.17-.143.341-.216.507l-.044.1L29.5,24.24A13.635,13.635,0,0,1,27.831,26.5l.011.034,0,.006,0,.005,1.486,4.1-.1.086,0,0c-.049.044-.105.094-.16.139-.241.2-.463.373-.681.536s-.447.324-.706.5-.49.322-.726.465c-.077.047-.157.092-.234.135h0l-.12.068-3.56-2.683a14.214,14.214,0,0,1-2.676.836l-1.266,4.2-.119.013c-.051.006-.1.012-.155.016-.281.021-.572.035-.865.043ZM17.5,9.249A8.257,8.257,0,0,0,14.3,25.1,8.25,8.25,0,0,0,20.7,9.9,8.157,8.157,0,0,0,17.5,9.249Z" fill="#333"/>
      </svg>
    </button>

    @if (has_nav_menu('compact_navigation'))
      <button id="open-side-menu" class="open-side-menu button" command="show-modal" commandfor="side-menu" aria-label="{{ __('Open Menu', 'sage') }}">
        <svg viewBox="0 0 10 8" width="20" height="16" role="img">
          <title>{{ __('Open Menu', 'sage') }}</title>
          <path d="M1 1h8M1 4h 8M1 7h8" stroke="#fff" stroke-width="1" stroke-linecap="round"></path>
        </svg>
      </button>
    @endif
  </div>

  @if (has_nav_menu('compact_navigation'))
    <dialog id="side-menu" class="side-menu is-offcanvas from-right side-menu" closedby="any">
      <a class="side-menu-logo" href="{{ home_url('/') }}" rel="home"{{ is_front_page() ? ' aria-current="page"' : '' }}>
        @if ($logo_alt_id)
          {!! wp_get_attachment_image($logo_alt_id, ['',80]) !!}
        @elseif ($logo_id)
          {!! wp_get_attachment_image($logo_id, ['',80]) !!}
        @else
          {{ get_bloginfo('name') }}
        @endif
      </a>
      {!! \App\compact_nav() !!}

      @if (has_nav_menu('compact_buttons'))
        {!! \App\compact_btns_nav() !!}
      @endif

      {{-- Social links if available --}}
      {{-- @if (has_social_links())
        <div class="social-links">
          @include('template-parts.main-social')
        </div>
      @endif --}}

      <button class="close" command="close" commandfor="side-menu" title="{{ __('Close', 'sage') }}" aria-label="{{ __('Close', 'sage') }}">&times;</button>
    </dialog>
  @endif
</div>
{{-- END Compact Menu --}}
