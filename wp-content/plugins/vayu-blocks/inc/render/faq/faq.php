<?php
if (!defined('ABSPATH')) {
    exit;
}
  
class Vayu_blocks_faq {

    private $attr;
    private $content;

    public function __construct($attr,$content) {
        $this->attr = $attr;
        $this->content = $content;
    }

    //Render
    public function render() {
        ob_start();
        echo $this->render_faq();
        return ob_get_clean();
    }

    private function render_faq() {
        $attributes = $this->attr;
        $OBJ_STYLE = new VAYUBLOCKS_RESPONSIVE_STYLE($attributes);
        $uniqueId = $attributes['uniqueId'] ?? 'vb-faq-' . wp_rand();

        $classhover = '';
        $animated = $attributes['className'] ?? '';
        $showtype = $attributes['showtype'] ?? 'accordation';
        $schemaEnabled = $attributes['enableschema'] ?? false;

        // Base container class
        $containerClass = 'vb-faq-wrapper-front vb-faq-wrapper-front' . esc_attr($uniqueId);
        $containerClass .= ' ' . ($showtype === 'accordation' ? 'vb-type-accordation' : 'vb-type-grid');

        if (!empty($attributes['animationData']['effect']['effectHover'])) {
            $classhover = 'vayu-blocks-image-hover';
        }

        $wrapperClasses = [$containerClass];

        if (!empty($classhover)) {
            $wrapperClasses[] = $classhover;
        }
        if (!empty($animated) && $animated !== 'none') {
            $wrapperClasses[] = $animated;
        }
        
        if (!empty($attributes['advAnimation']['className'])) {
            $wrapperClasses[] = $attributes['advAnimation']['className'];
        }

        $finalClass = implode(' ', array_filter($wrapperClasses));

        // Wrap inner content (children)
        $faq_html = '<div class="vb-faq-inner">';
            $faq_html .= $this->content;
        $faq_html .= '</div>';

        // Output
        return '<div id="' . esc_attr($uniqueId) . '" ' . get_block_wrapper_attributes([
            'class' => $finalClass
        ]) . '>' . $faq_html . '</div>';
    }

}

function vayu_block_faq_render($attr,$content) {

    if ((new VAYUBLOCKS_DISPLAY_CONDITION($attr))->display()) {
        return ;
    }
    $default_attributes = include('defaultattributes.php');
    $attr = array_merge($default_attributes, $attr);
    $faq = new Vayu_blocks_faq($attr,$content);

    return $faq->render();
    
} 