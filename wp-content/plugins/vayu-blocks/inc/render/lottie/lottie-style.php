<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}

function generate_inline_lottie_styles($attr) {

    if ((new VAYUBLOCKS_DISPLAY_CONDITION($attr))->display()) {
        return '';
    }

    $css = '';

    $default_attributes = include('defaultattributes.php');
    $attr = array_merge($default_attributes, $attr);  
    $uniqueId = $attr['uniqueId'];

    $OBJ_STYLE = new VAYUBLOCKS_RESPONSIVE_STYLE($attr);

    $wrapper = '.vb-lottie-wrapper' . esc_attr($uniqueId);
    
    $container = '.vb-lottie-container';

    $inline = '.vb-lottie-frontend';

    $css .= $OBJ_STYLE->advanceStyle( $wrapper );

    $alignmentDesktop = $attr['alignment']['Desktop'] ?? 'center';
    $alignmentTablet  = $attr['alignment']['Tablet'] ?? $alignmentDesktop;
    $alignmentMobile  = $attr['alignment']['Mobile'] ?? $alignmentTablet;
    $rotation = isset($attr['rotation']) ? $attr['rotation'] : 0;

    $css .= "$wrapper $container {";
        $css .= "width: 100%;";
        $css .= "height: 100%;";
        $css .= "display: flex;";
        $css .= "align-items: center;";
        $css .= "justify-content: $alignmentDesktop;";
        $css .= "transform: rotate({$rotation}deg);";
    $css .= "}";

    $filter       = isset($attr['filter']) ? $attr['filter'] : [];
    $hoverFilter  = isset($attr['hoverfilter']) ? $attr['hoverfilter'] : [];
    $opacity      = isset($attr['opacity']) ? $attr['opacity'] : 1;
    $opacityHover = isset($attr['opacityhvr']) ? $attr['opacityhvr'] : $opacity;
    $width        = isset($attr['width']['Desktop']) ? $attr['width']['Desktop'] : '100%';
    $widthTablet  = $attr['width']['Tablet'] ?? $widthDesktop;
    $widthMobile  = $attr['width']['Mobile'] ?? $widthTablet;
    $transition   = $attr['transition'] ?? 1;

    $getFilterVal = function($source, $key, $unit = '', $default = 0) {
        return isset($source[$key]) ? $source[$key] . $unit : $default . $unit;
    };

    // 🔹 Normal Style
    $css .= "$wrapper $container $inline {";
        $css .= "width: $width;";
        $css .= "height: auto;";
        $css .= "opacity: $opacity;";
        $css .= "filter: ";
        $css .= "blur(" . $getFilterVal($filter, 'blur', 'px') . ") ";
        $css .= "brightness(" . $getFilterVal($filter, 'brightness', '%', 100) . ") ";
        $css .= "contrast(" . $getFilterVal($filter, 'contrast', '%', 100) . ") ";
        $css .= "saturate(" . $getFilterVal($filter, 'saturation', '%', 100) . ") ";
        $css .= "hue-rotate(" . $getFilterVal($filter, 'hue', 'deg', 0) . ");";
        $css .= "transition: all {$transition}s ease;";
        $css .= $OBJ_STYLE->borderFrame('frameData','Desktop');
        $css .= $OBJ_STYLE->borderRadiusShadow('', '', 'dropshadow', 'Desktop');
        $css .= "box-sizing:border-box;";
        if ( isset($attr['background']) && $attr['background'] !== '' ) {
            $css .= "background: " . esc_attr($attr['background']) . ";";
        }
        $css .= "display:flex;";
		$css .= "align-items:center;";
		$css .= "justify-content:center;";
    $css .= "}";

    // 🔹 Hover Style
    $css .= "$wrapper $container $inline:hover {";
        $css .= "opacity: $opacityHover;";
        $css .= "filter: ";
        $css .= "blur(" . $getFilterVal($hoverFilter, 'blur', 'px', $getFilterVal($filter, 'blur', 'px')) . ") ";
        $css .= "brightness(" . $getFilterVal($hoverFilter, 'brightness', '%', $getFilterVal($filter, 'brightness', '', 100)) . ") ";
        $css .= "contrast(" . $getFilterVal($hoverFilter, 'contrast', '%', $getFilterVal($filter, 'contrast', '', 100)) . ") ";
        $css .= "saturate(" . $getFilterVal($hoverFilter, 'saturation', '%', $getFilterVal($filter, 'saturation', '', 100)) . ") ";
        $css .= "hue-rotate(" . $getFilterVal($hoverFilter, 'hue', 'deg', $getFilterVal($filter, 'hue', '', 0)) . ");";
        if ( isset($attr['backgroundhvr']) && $attr['backgroundhvr'] !== '' ) {
            $css .= "background: " . esc_attr($attr['backgroundhvr']) . ";";
        }
    $css .= "}";

    // 🔹 Tablet Media Query
    $css .= "@media (min-width: 768px) and (max-width: 1024px) {";
        $css .= "$wrapper $container $inline {";
            $css .= "width: $widthTablet;";
            $css .= $OBJ_STYLE->borderFrame('frameData','Tablet'); 
            $css .= $OBJ_STYLE->borderRadiusShadow('', '', 'boxshadow', 'Tablet');
        $css .= "}";

        $css .= "$wrapper $container {";
            $css .= "justify-content: $alignmentTablet;";
        $css .= "}";
    $css .= "}";

    // 🔹 Mobile Media Query
    $css .= "@media (max-width: 767px) {";
        $css .= "$wrapper $container $inline {";
            $css .= "width: $widthMobile;";
            $css .= $OBJ_STYLE->borderFrame('frameData','Mobile'); 
            $css .= $OBJ_STYLE->borderRadiusShadow('', '', 'boxshadow', 'Mobile');
        $css .= "}";

        $css .= "$wrapper $container {";
            $css .= "justify-content: $alignmentMobile;";
        $css .= "}";
    $css .= "}";

    return $css;
}