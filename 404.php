<?php

/*
 * Spine Toolkit serves some of its 404s with get_template_part( '404' ), which loads
 * this file directly instead of going through the template hierarchy.
 */

use function Roots\view;

echo view('layouts.app', ['content' => '404'])->render();
