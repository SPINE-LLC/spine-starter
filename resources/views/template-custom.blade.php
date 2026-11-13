{{--
  Template Name: Custom Template
--}}

@while(have_posts()) @php(the_post())
  @include('partials.page-header')
  @include('partials.content-page')
@endwhile
