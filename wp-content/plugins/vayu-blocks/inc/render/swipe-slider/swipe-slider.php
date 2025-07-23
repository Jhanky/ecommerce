<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function vayu_block_swipe_slider_render($attributes, $content, $block) {

    // print_r($attributes);
    if ((new VAYUBLOCKS_DISPLAY_CONDITION($attributes))->display()) {
        return '';
    }

    $navigation = '';

    $swipeNavIconLeft = isset($attributes['swipeNavIconLeft']) ? $attributes['swipeNavIconLeft'] : '';
    $swipeNavIconRight = isset($attributes['swipeNavIconRight']) ? $attributes['swipeNavIconRight'] : '';
    $swipeNav = isset($attributes['swipeNav']) ? $attributes['swipeNav'] : 'arrowdots';
    $data_nav = $swipeNav;
    if ($swipeNav === 'arrow' || $swipeNav === 'arrowdots' || $swipeNav === '') {
        switch ($swipeNavIconLeft) {
            case 'arrowLeft':
                $left_icon = '<span class="dashicons dashicons-arrow-left-alt"></span>';
                break;
            case 'arrowRight':
                $left_icon = '<span class="dashicons dashicons-arrow-right-alt"></span>';
                break;
            case 'chevronLeft':
                $left_icon = '<span class="dashicons dashicons-arrow-left"></span>';
                break;
            case 'chevronRight':
                $left_icon = '<span class="dashicons dashicons-arrow-right"></span>';
                break;
            default:
                $left_icon = '<span class="dashicons dashicons-arrow-left-alt"></span>';
        }

        switch ($swipeNavIconRight) {
            case 'arrowLeft':
                $right_icon = '<span class="dashicons dashicons-arrow-left-alt"></span>';
                break;
            case 'arrowRight':
                $right_icon = '<span class="dashicons dashicons-arrow-right-alt"></span>';
                break;
            case 'chevronLeft':
                $right_icon = '<span class="dashicons dashicons-arrow-left"></span>';
                break;
            case 'chevronRight':
                $right_icon = '<span class="dashicons dashicons-arrow-right"></span>';
                break;
            default:
                $right_icon = '<span class="dashicons dashicons-arrow-right-alt"></span>';
        }

        $navigation .= !empty($left_icon) ? '<button class="scroll-button left">' . $left_icon . '</button>' : '';
        $navigation .= !empty($right_icon) ? '<button class="scroll-button right">' . $right_icon . '</button>' : '';
    }

    $wrapclassnames = $attributes['uniqueId'] . ' swipe-scroll-wrapper swipe-feature-slider-wrapper';
    $innerclass = 'swiper-wrapper swipe-carousel';
    $id = $attributes['uniqueId'];

    $wrapper_attributes = get_block_wrapper_attributes(array('class' => trim($wrapclassnames)));
    return sprintf(
        '<div id="%5$s" %1$s>
         <div class="swipe-slider-content">
         <div class="%2$s" data-nav="%6$s">%3$s</div>
         %4$s
         </div>
         </div>',
        $wrapper_attributes,
        $innerclass,
        $content,
        $navigation,
        $id,
        esc_attr($data_nav)
    );
}