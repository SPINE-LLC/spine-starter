<?php

namespace App\Providers;

use Roots\Acorn\Sage\SageServiceProvider;

class ThemeServiceProvider extends SageServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        // Sage adds the page slug as a body class, which on a page named "search" is
        // "search", the class WordPress gives search results.
        remove_filter('body_class', $this->app['sage']->filter('body_class'), 10);
    }
}
