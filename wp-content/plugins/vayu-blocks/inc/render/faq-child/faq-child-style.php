<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}

function generate_inline_faq_child_styles($attr) {

    if ((new VAYUBLOCKS_DISPLAY_CONDITION($attr))->display()) {
        return '';
    }

    $css = '';

    $default_attributes = include('defaultattributes.php');
    $attr = array_merge($default_attributes, $attr);  
    $uniqueId = $attr['uniqueId'];

    $OBJ_STYLE = new VAYUBLOCKS_RESPONSIVE_STYLE($attr);

    $wrapper = '.vb-faq-child-wrapper' . esc_attr($uniqueId);
    
    $container = '.vb-faq-child-content';

    $icon = '.vb-faq-icon';

    $css .= $OBJ_STYLE->advanceStyle( $wrapper );

    return $css;
}