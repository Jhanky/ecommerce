<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}

function generate_inline_faq_styles($attr) {

    if ((new VAYUBLOCKS_DISPLAY_CONDITION($attr))->display()) {
        return '';
    }

    $css = '';

    $default_attributes = include('defaultattributes.php');
    $attr = array_merge($default_attributes, $attr);  
    $uniqueId = $attr['uniqueId'];

    $OBJ_STYLE = new VAYUBLOCKS_RESPONSIVE_STYLE($attr);

    $wrapper = '.vb-faq-wrapper-front' . esc_attr($uniqueId);
    
    $container = '.vb-faq-inner';

    $css .= $OBJ_STYLE->advanceStyle( $wrapper );

    $css .= "$wrapper $container {";
        if (isset($attr['rowgap']['Desktop'])) {
            $css .= "gap: {$attr['rowgap']['Desktop']};";
        } else {
            $css .= "gap: 10px;";
        }

        $css .="overflow:hidden;";

        $alignment = $attr['iconalignment'] === 'left' ? 'inline-end' : (
            $attr['iconalignment'] === 'right' ? 'inline-start' : 'center'
        );
        $css .= "--icon-alignment: $alignment;";


    $css .= "}";

    $css .= "$wrapper .vb-faq-child-wrapper {";

        if (isset($attr['containerbg'])) {
            $css .= "background: {$attr['containerbg']};";
        }

        $css .= $OBJ_STYLE->borderRadiusShadow('contBorder','contBorderRadius','contDropShadow','Desktop');

    $css .= "}";

    $css .= "$wrapper .vb-faq-child-wrapper:hover {";

        if (isset($attr['containerbghvr'])) {
            $css .= "background: {$attr['containerbghvr']};";
        }

        $css .= $OBJ_STYLE->borderRadiusShadow('contBorder','contBorderRadius','contDropShadow','Desktop','Hover','Hover');

    $css .= "}";

    $css .= "$wrapper .vb-faq-icon svg{";
        if (!empty($attr['iconsize']['Desktop'])) {
            $css .= "width: {$attr['iconsize']['Desktop']};";
        }else{
            $css .= "width: 36px;";
        }
        $css .= "color: inherit;";
    $css .= "}";

    $css .= "$wrapper .vb-faq-icon {";

        if (isset($attr['icontop']['Desktop'])) {
            $css .= "top: {$attr['icontop']['Desktop']};";
        }else{
             $css .= "top: 13px;";
        }

        if (isset($attr['iconleft']['Desktop'])) {
            $css .= "left: {$attr['iconleft']['Desktop']};";
        }else{
             $css .= "left: 92%;";
        }

        $css .= $OBJ_STYLE->dimensions('iconPadding','padding');

        if (!empty($attr['iconbg'])) {
            $css .= "background: {$attr['iconbg']};";
        }

        if (!empty($attr['iconcolor'])) {
            $css .= "color: {$attr['iconcolor']};";
        }else{
            $css .= "color: black;";
        }

        if (!empty($attr['iconcolor'])) {
            $css .= "fill: {$attr['iconcolor']};";
        }else{
            $css .= "fill: black;";
        }

        $css .= $OBJ_STYLE->borderRadiusShadow('iconBorder','iconBorderRadius','iconDropShadow','Desktop');

    $css .= "}";

    $css .= "$wrapper .open .vb-faq-icon {";
        if (!empty($attr['iconactivecolor'])) {
            $css .= "color: {$attr['iconactivecolor']};";
        }
        if (!empty($attr['iconactivecolor'])) {
            $css .= "fill: {$attr['iconactivecolor']};";
        }
    $css .= "}";

    $css .= "$wrapper .vb-faq-icon:hover {";
        if (!empty($attr['iconbghvr'])) {
            $css .= "background: {$attr['iconbghvr']};";
        }

        if (!empty($attr['iconcolorhvr'])) {
            $css .= "color: {$attr['iconcolorhvr']};";
        }

        if (!empty($attr['iconcolorhvr'])) {
            $css .= "fill: {$attr['iconcolorhvr']};";
        }
    $css .= "}";

    $css .= "$wrapper.vb-type-grid .vb-faq-inner{";
        $css .= "display: grid;";
        $css .= "grid-template-columns: repeat(2, auto);";
        if (isset($attr['rowgap']['Desktop'])) {
            $css .= "row-gap: {$attr['rowgap']['Desktop']};";
        } else {
            $css .= "row-gap: 10px;";
        }
        $css .= "column-gap:10px;";
    $css .= "}";

    //  Tablet Media Query
    $css .= "@media (min-width: 768px) and (max-width: 1024px) {";
        $css .= "$wrapper $container {";
            if (isset($attr['rowgap']['Tablet'])) {
                $css .= "gap: {$attr['rowgap']['Tablet']};";
            }
        $css .= "}";

        $css .= "$wrapper .vb-faq-wrapper-front.vb-type-grid .vb-faq-inner {";
            if (isset($attr['rowgap']['Tablet'])) {
                $css .= "row-gap: {$attr['rowgap']['Tablet']};";
            }
        $css .= "}";

        $css .= "$wrapper .vb-faq-child-wrapper {";
            $css .= $OBJ_STYLE->borderRadiusShadow('contBorder','contBorderRadius','contDropShadow','Tablet');
        $css .= "}";

        $css .= "$wrapper .vb-faq-child-wrapper:hover {";
            $css .= $OBJ_STYLE->borderRadiusShadow('contBorder','contBorderRadius','contDropShadow','Tablet','Hover','Hover');
        $css .= "}";

        $css .= "$wrapper .vb-faq-icon svg{";
            if (!empty($attr['iconsize']['Tablet'])) {
                $css .= "width: {$attr['iconsize']['Tablet']};";
            }
        $css .= "}";

        $css .= "$wrapper .vb-faq-icon {";

            if (isset($attr['icontop']['Tablet'])) {
                $css .= "top: {$attr['icontop']['Tablet']};";
            }

            if (isset($attr['iconleft']['Tablet'])) {
                $css .= "left: {$attr['iconleft']['Tablet']};";
            }

            $css .= $OBJ_STYLE->dimensions('iconPadding','padding', 'Tablet');
            $css .= $OBJ_STYLE->borderRadiusShadow('iconBorder','iconBorderRadius','iconDropShadow','Tablet');

        $css .= "}";
    $css .= "}";

    //  Mobile Media Query
    $css .= "@media (max-width: 767px) {";
        $css .= "$wrapper $container {";
            if (isset($attr['rowgap']['Mobile'])) {
                $css .= "gap: {$attr['rowgap']['Mobile']};";
            }
        $css .= "}";

        $css .= "$wrapper .vb-faq-icon svg{";
            if (!empty($attr['iconsize']['Mobile'])) {
                $css .= "width: {$attr['iconsize']['Mobile']};";
            }
        $css .= "}";

        $css .= "$wrapper .vb-faq-child-wrapper {";
            $css .= $OBJ_STYLE->borderRadiusShadow('contBorder','contBorderRadius','contDropShadow','Mobile');
        $css .= "}";

        $css .= "$wrapper .vb-faq-child-wrapper:hover {";
            $css .= $OBJ_STYLE->borderRadiusShadow('contBorder','contBorderRadius','contDropShadow','Mobile','Hover','Hover');
        $css .= "}";

        $css .= "$wrapper .vb-faq-icon {";

            if (isset($attr['icontop']['Mobile'])) {
                $css .= "top: {$attr['icontop']['Mobile']};";
            }

            if (isset($attr['iconleft']['Mobile'])) {
                $css .= "left: {$attr['iconleft']['Mobile']};";
            }

            $css .= $OBJ_STYLE->dimensions('iconPadding','padding', 'Mobile');

            $css .= $OBJ_STYLE->borderRadiusShadow('iconBorder','iconBorderRadius','iconDropShadow','Mobile');

        $css .= "}";

        $css .= "$wrapper .vb-faq-wrapper-front.vb-type-grid .vb-faq-inner {";
            if (isset($attr['rowgap']['Mobile'])) {
                $css .= "row-gap: {$attr['rowgap']['Mobile']};";
            }
        $css .= "}";

    $css .= "}";

    return $css;
}