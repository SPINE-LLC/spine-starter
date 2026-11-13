<?php

/*
 * Sage's template_include filter sends every request here with the matched view.
 * A theme view renders inside the layout. Anything else, such as WordPress's own
 * embed template, renders as WordPress would have included it.
 */

use function Roots\view;

if (is_file(app('sage.view'))) {
    include app('sage.view');

    return;
}

echo view('layouts.app', ['content' => app('sage.view')] + app('sage.data'))->render();
