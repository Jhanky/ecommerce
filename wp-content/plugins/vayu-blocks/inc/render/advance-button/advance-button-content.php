<?php

function vayu_blocks_get_border_value($border, $side = 'top', $property = 'width') {
    if (!is_array($border) || !isset($border['Desktop'])) {
        return null;
    }

    // Mixed case
    if (isset($border['Desktop'][$side]) && is_array($border['Desktop'][$side]) && isset($border['Desktop'][$side][$property])) {
        return $border['Desktop'][$side][$property];
    }

    // Non-mixed case
    if (isset($border['Desktop'][$property])) {
        return $border['Desktop'][$property];
    }

    return null;
}

function vayu_blocks_advance_button_render( $attributes ) {

    $uniqueID = $attributes['uniqueID'] ?? '';
    $content = $attributes['content'] ?? 'Button';

    $url = $attributes['post']['url'] ?? '';
    $opensInNewTab = $attributes['post']['opensInNewTab'] ?? false;
    $markAsNofollow = $attributes['post']['markAsNofollow'] ?? false;

    $iconHTML = $attributes['iconCopy']; // Optional: render from $attributes['icon'] or $attributes['iconName']

    $btnBorder = $attributes['btnBorder'] ?? null;
    $btnBorderHover = $attributes['btnBorderHover'] ?? null;

    $buttonColor = $attributes['color'] ?? '';
    $hoverColor = $attributes['hoverColor'] ?? '';
    $bgColor = $attributes['btnBackground']['color'] ?? '';
    $bgGradient = $attributes['btnBackground']['gradient'] ?? '';
    $hoverBgColor = $attributes['btnBackgroundHover']['color'] ?? '';
    $hoverBgGradient = $attributes['btnBackgroundHover']['gradient'] ?? '';
    $animationClass = $attributes['advAnimation']['className'] ?? '';
    $effectClass = $attributes['animationData']['background']['value'] ?? 'none';
    $effectTrigger = $attributes['animationData']['background']['type'] ?? 'onhvr';
    
  // Check if the 'btnBorderRadius' and 'btnBorderRadiusHover' exist before accessing
$btnRadius_top_left = isset($attributes['btnBorderRadius']['Desktop']['topLeft']) ? $attributes['btnBorderRadius']['Desktop']['topLeft'] : null;
$btnRadius_top_right = isset($attributes['btnBorderRadius']['Desktop']['topRight']) ? $attributes['btnBorderRadius']['Desktop']['topRight'] : null;
$btnRadius_bottom_left = isset($attributes['btnBorderRadius']['Desktop']['bottomLeft']) ? $attributes['btnBorderRadius']['Desktop']['bottomLeft'] : null;
$btnRadius_bottom_right = isset($attributes['btnBorderRadius']['Desktop']['bottomRight']) ? $attributes['btnBorderRadius']['Desktop']['bottomRight'] : null;

// For Border Radius Hover, check if it exists before accessing
$btnRadiusHover_top_left = isset($attributes['btnBorderRadiusHover']['Desktop']['topLeft']) ? $attributes['btnBorderRadiusHover']['Desktop']['topLeft'] : null;
$btnRadiusHover_top_right = isset($attributes['btnBorderRadiusHover']['Desktop']['topRight']) ? $attributes['btnBorderRadiusHover']['Desktop']['topRight'] : null;
$btnRadiusHover_bottom_left = isset($attributes['btnBorderRadiusHover']['Desktop']['bottomLeft']) ? $attributes['btnBorderRadiusHover']['Desktop']['bottomLeft'] : null;
$btnRadiusHover_bottom_right = isset($attributes['btnBorderRadiusHover']['Desktop']['bottomRight']) ? $attributes['btnBorderRadiusHover']['Desktop']['bottomRight'] : null;

    

    // Button styles as inline CSS variables
    $styleVars = [
        // '--animation-box-button' => $attributes['animationData']['background']['bg'] ?? '',
        '--button-color' => $buttonColor,
        '--button-hvr-color' => $hoverColor,
        '--button-background' => $bgColor,
        '--button-gradient' => $bgGradient,
        '--button-hvr-background' => $hoverBgColor,
        '--button-hvr-gradient' => $hoverBgGradient,
        
        '--btnRadius-top-left' => $btnRadius_top_left,
        '--btnRadius-top-right' => $btnRadius_top_right,
        '--btnRadius-bottom-left' => $btnRadius_bottom_left,
        '--btnRadius-bottom-right' => $btnRadius_bottom_right,

        '--btnRadiusHover-top-left' => $btnRadiusHover_top_left,
        '--btnRadiusHover-top-right' => $btnRadiusHover_top_right,
        '--btnRadiusHover-bottom-left' => $btnRadiusHover_bottom_left,
        '--btnRadiusHover-bottom-right' => $btnRadiusHover_bottom_right,
    ];

    $styleInline = '';
    foreach ( $styleVars as $key => $val ) {
        if ( ! empty( $val ) ) {
            $styleInline .= $key . ':' . esc_attr( $val ) . ';';
        }
    }

    $buttonClasses = implode( ' ', array_filter([
        'th-button',
        'th-button-inside',
        $animationClass,
        $effectClass !== 'none' ? $effectClass : '',
        "effect-trigger-$effectTrigger"
    ]));

    $iconToggle = $attributes['iconToggle'] ?? false;


    $textContent = esc_html( $content );
    $textSpan = "<span class='vayu-btn-text'>{$textContent}</span>";

    $iconSpan = $iconToggle ? "<span class='vayu-icon'>{$iconHTML}</span>" : '';

    $innerButton = $iconSpan . $textSpan;

    // Use <a> or <div>
    $buttonElement = '';
    if ( ! empty( $url ) ) {
        $target = $opensInNewTab ? ' target="_blank"' : '';
        $rel = $markAsNofollow ? ' rel="nofollow noreferrer noopener"' : '';
        $buttonElement = "<a href=\"" . esc_url( $url ) . "\" class=\"$buttonClasses\" style=\"$styleInline\"$target$rel>$innerButton</a>";
    } else {
        $buttonElement = "<div class=\"$buttonClasses\" style=\"$styleInline\">$innerButton</div>";
    }

    return "<div class=\"th-button-wrapper{$uniqueID}\">{$buttonElement}</div>";
}
