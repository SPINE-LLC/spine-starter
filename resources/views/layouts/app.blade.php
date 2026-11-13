{{--
  The document shell. The matched view renders inside main#main, after wp_head()
  and the header, so hooks and generated IDs run in the order a classic theme runs
  them. A view that used @extends would render before wp_head().
--}}
@php(do_action('get_header', null, []))
<!doctype html>
<html class="no-js" @php(language_attributes())>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php(wp_head())
  </head>

  <body @php(body_class())>
    @php(wp_body_open())

    <div id="app">
      <a id="skip-link" class="sr-only focus:not-sr-only" href="#main">
        {{ __('Skip to content', 'sage') }}
      </a>

      @include('sections.header')

      <main id="main" class="main is-layout-constrained">
        @include($content)
      </main>

      @php(do_action('get_footer', null, []))
      @include('sections.footer')
    </div>

    @php(wp_footer())
  </body>
</html>
