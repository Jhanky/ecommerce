<?php
if (!defined('ABSPATH')) {
    exit;
}
  
class Vayu_blocks_lottie {

    private $attr;
    private $content;

    public function __construct($attr,$content) {
        $this->attr = $attr;
        $this->content = $content;
    }

    //Render
    public function render() {
        ob_start();

        echo $this->render_lottie();

        return ob_get_clean();
    }

    private function render_lottie() {
        $attributes = $this->attr;
        $OBJ_STYLE = new VAYUBLOCKS_RESPONSIVE_STYLE($attributes);
      	$uniqueId        = $attributes['uniqueId'] ?? 'vb-lottie-' . wp_rand();
        
        $lottie_url = esc_url($attributes['lottieUrl'] ?? '');
        $start      = intval($attributes['start'] ?? 0);
        $end        = intval($attributes['end'] ?? ($attributes['totaltime'] ?? 100));
        $loop       = !empty($attributes['loop']) ? 'true' : 'false';
        $autoplay   = !empty($attributes['autoplay']) ? 'true' : 'false';
        $trigger    = esc_attr($attributes['trigger']['type'] ?? 'none');
        $top      = intval($attributes['trigger']['top'] ?? 0);
        $bottom      = intval($attributes['trigger']['bottom'] ?? 0);
        $speed      = ($attributes['speed'] ?? 1);
        $direction = (!empty($attributes['direction']) && $attributes['direction'] === true) ? '-1' : '1';

        $lottie_html = '';

        if (!empty($attributes['link']) && !empty($attributes['link']['url'])) {
            $link_url     = esc_url($attributes['link']['url']);
            $link_id      = esc_attr(!empty($attributes['link']['id']) ? $attributes['link']['id'] : 'default-id');
            $link_title   = esc_attr(!empty($attributes['link']['title']) ? $attributes['link']['title'] : 'Default Title');
            $link_target  = !empty($attributes['link']['opensInNewTab']) ? '_blank' : '_self';
            $link_rel     = !empty($attributes['link']['opensInNewTab']) ? 'noopener noreferrer' : '';
        
            $lottie_html .= '<a href="' . $link_url . '" id="' . $link_id . '" title="' . $link_title . '" target="' . $link_target . '" rel="' . $link_rel . '">';
        }

            $lottie_html .= '<div class="vb-lottie-container">';
                $lottie_html .= '<div 
                    id="' . esc_attr($uniqueId) . '" 
                    class="vb-lottie-frontend" 
                    data-lottie="' . $lottie_url . '" 
                    data-speed="' . $speed . '" 
                    data-direction="' . $direction . '"
                    data-start="' . $start . '" 
                    data-end="' . $end . '" 
                    data-loop="' . $loop . '" 
                    data-autoplay="' . $autoplay . '" 
                    data-trigger="' . $trigger . '"
                    data-top="' . $top . '" 
                    data-bottom="' . $bottom . '" 
                ></div>';
            $lottie_html .= '</div>';

        if (!empty($attributes['link']) && !empty($attributes['link']['url'])) {
            $lottie_html .= '</a>';
        }

        $classhover='';
        
        if (isset($attributes['animationData']['effect']['effectHover']) && $attributes['animationData']['effect']['effectHover']) {
            $classhover = 'vayu-blocks-image-hover';
        }

        $animated = $attributes['className']?? '';
        $classes = ['vb-lottie-wrapper' . $uniqueId];

        if (!empty($classhover)) {
            $classes[] = $classhover;
        }
        
        if (!empty($animated) && $animated !== 'none') {
            $classes[] = $animated;
        }

        if ( ! empty( $attributes['advAnimation'] ) && ! empty( $attributes['advAnimation']['className'] ) ) {
            $classes[] = $attributes['advAnimation']['className'];
        }
                
        $finalClass = implode(' ', $classes);

        $lottie_html .= $OBJ_STYLE->renderVideo('advBackground');
        $dataAttributes = $OBJ_STYLE->follower();

        return '<div id="' . esc_attr($uniqueId) . '" ' . $dataAttributes . ' ' . get_block_wrapper_attributes([
            'class' => $finalClass
        ]) . '>' . $lottie_html . '</div>';

    }
}

function vayu_block_lottie_render($attr,$content) {

    if ((new VAYUBLOCKS_DISPLAY_CONDITION($attr))->display()) {
        return ;
    }
    $default_attributes = include('defaultattributes.php');
    $attr = array_merge($default_attributes, $attr);
    $lottie = new Vayu_blocks_lottie($attr,$content);

    return $lottie->render();
    
} 