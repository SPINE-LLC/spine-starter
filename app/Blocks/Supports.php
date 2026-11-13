<?php

namespace App\Blocks;

/**
 * Gives every block all of core's style controls, so editors can style any block from its settings.
 *
 * The editor reads block supports from the server's block definitions, so this filter covers both
 * the editor and the front end.
 */
class Supports
{
    /**
     * Style supports for every block.
     *
     * Layout and block gap stay with the container blocks that declare them, because adding layout
     * support changes a block's rendered classes.
     */
    private const SUPPORTS = [
        'color' => ['background' => true, 'text' => true, 'gradients' => true, 'link' => true, 'heading' => true, 'button' => true],
        'typography' => [
            'fontSize' => true,
            'lineHeight' => true,
            'textAlign' => true,
            'textColumns' => true,
            'textIndent' => true,
            'fitText' => true,
            '__experimentalFontFamily' => true,
            '__experimentalFontStyle' => true,
            '__experimentalFontWeight' => true,
            '__experimentalLetterSpacing' => true,
            '__experimentalTextTransform' => true,
            '__experimentalTextDecoration' => true,
            '__experimentalWritingMode' => true,
        ],
        'spacing' => ['margin' => true, 'padding' => true],
        'dimensions' => ['aspectRatio' => true, 'height' => true, 'minHeight' => true, 'minWidth' => true, 'width' => true],
        '__experimentalBorder' => ['color' => true, 'radius' => true, 'style' => true, 'width' => true],
        'shadow' => true,
        'background' => ['backgroundImage' => true, 'backgroundSize' => true, 'gradient' => true],
        'position' => ['sticky' => true, 'fixed' => true],
        'filter' => ['duotone' => true],
    ];

    public function boot(): void
    {
        add_filter('register_block_type_args', [$this, 'addSupports'], 10, 2);
    }

    /**
     * Adds the style supports a block doesn't declare.
     *
     * A block keeps every value it declares, including a feature it turns off, and keeps its own
     * control where it has an attribute of the feature's name, such as Cover's minimum height. A
     * group the block serializes itself, such as Button's typography on its link, gets nothing
     * new, because the block wouldn't print it. Blocks without a wrapper of their own turn off
     * Additional CSS, so they get nothing.
     *
     * Navigation prints its wrapper attributes on two elements, and Spine Toolkit's renderers
     * print none, so those blocks get nothing either.
     *
     * @param  array<string, mixed>  $args
     * @return array<string, mixed>
     */
    public function addSupports(array $args, string $block_name): array
    {
        $supports = $args['supports'] ?? [];
        if (($supports['customCSS'] ?? true) === false || $block_name === 'core/navigation' || str_starts_with($block_name, 'spine-toolkit/')) {
            return $args;
        }

        foreach (self::SUPPORTS as $group => $features) {
            if (in_array($group, ['dimensions', 'typography'], true)) {
                $features = array_filter($features, fn (string $feature): bool => ! isset($args['attributes'][lcfirst(str_replace('__experimental', '', $feature))]), ARRAY_FILTER_USE_KEY);
            }
            $declared = $supports[$group] ?? null;
            if ($declared === null) {
                $supports[$group] = $features;
            } elseif (is_array($declared) && is_array($features) && ! isset($declared['__experimentalSkipSerialization'])) {
                $supports[$group] = $declared + $features;
            }
        }
        $args['supports'] = $supports;

        return $args;
    }
}
