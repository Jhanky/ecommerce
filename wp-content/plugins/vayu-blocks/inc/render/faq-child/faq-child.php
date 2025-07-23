<?php
if (!defined('ABSPATH')) {
    exit;
}
  
class Vayu_blocks_faq_child {

    private $attr;
    private $content;

    public function __construct($attr,$content) {
        $this->attr = $attr;
        $this->content = $content;
    }

    //Render
    public function render() {
        ob_start();
        echo $this->render_faq_child();
        return ob_get_clean();
    }

  	private function render_faq_child() {
		$attributes = $this->attr;
		$OBJ_STYLE = new VAYUBLOCKS_RESPONSIVE_STYLE($attributes);
		$uniqueId = $attributes['uniqueId'] ?? 'vb-faq-child-' . wp_rand();

		$meta = $attributes['faqMeta'] ?? [];
		$showtype = $meta['showtype'] ?? 'accordation';
		$collpaseall = $meta['collapseall'] ?? 'false';
		$expandfirst = $meta['expandfirst'] ?? false;
		$enabletoggle = $meta['enabletoggle'] ?? false;
		$collapse = (int) $collpaseall;
		$isFirstChild = $meta['isFirstChild'] ?? false;

		$iconactive = $meta['activeprintedIcon'] ?? '';
		$iconinactive = $meta['inactiveprintedIcon'] ?? '';

		$activeIcon = vayu_blocks_get_icon_svg($iconactive);
		$inactiveIcon =vayu_blocks_get_icon_svg($iconinactive);

		$click = $meta['click'] ?? 'both';

		// Initial icon on load
		$iconHtml = ($expandfirst && $isFirstChild) ? $activeIcon : $inactiveIcon;

		if(!$collapse){
			$iconHtml = $activeIcon;
		}

		$classhover = '';
		if (!empty($attributes['animationData']['effect']['effectHover'])) {
			$classhover = 'vayu-blocks-image-hover';
		}

		$animated = $attributes['className'] ?? '';
		$extraAnim = !empty($attributes['advAnimation']['className']) ? $attributes['advAnimation']['className'] : '';

		$classes = ['vb-faq-child-wrapper', 'vb-faq-child-wrapper' . $uniqueId];

		// Open/closed logic
		if ($showtype === 'accordation') {
			if(!$collapse){
				$classes[] = 'open';
				$classes[] = 'colpaseopen';
			}else{
				if ($expandfirst && $isFirstChild) {
					$classes[] = 'open';
				} else {
					$classes[] = 'closed';
				}
			}
		}

		// Grid layout logic
		if ($showtype === 'grid') {
			$classes[] = 'vb-grid-layout';
		}

		if (!empty($classhover)) {
			$classes[] = $classhover;
		}
		if (!empty($animated) && $animated !== 'none') {
			$classes[] = $animated;
		}
		if (!empty($extraAnim)) {
			$classes[] = $extraAnim;
		}

		$finalClass = implode(' ', array_filter($classes));

		$faq_child_html = '<div class="vb-faq-child-content">';
			$faq_child_html .= $this->content;

			// Add icon span for accordation mode
			if ($showtype !== 'grid' && (!empty($activeIcon) || !empty($inactiveIcon))) {
				$faq_child_html .= '<span class="vb-faq-icon" 
					data-active-icon="' . esc_attr($activeIcon) . '" 
					data-inactive-icon="' . esc_attr($inactiveIcon) . '">' . $iconHtml . '</span>';
			}

		$faq_child_html .= '</div>';

		$data_attributes = [
			'class' => $finalClass,
			'data-showtype' => $showtype,
			'data-expandfirst' => $expandfirst ? 'true' : 'false',
			'data-is-first-child' => $isFirstChild ? 'true' : 'false',
			'data-collapseall' => $collapse,
			'data-enabletoggle' => $enabletoggle ? 'true' : 'false',
			'data-click' => $click,
		];

		// Return outer wrapper
		return '<div id="' . esc_attr($uniqueId) . '" ' . get_block_wrapper_attributes($data_attributes) . '>' . $faq_child_html . '</div>';
	}

}

function vayu_block_faq_child_render($attr,$content) {

    if ((new VAYUBLOCKS_DISPLAY_CONDITION($attr))->display()) {
        return ;
    }
    $default_attributes = include('defaultattributes.php');
    $attr = array_merge($default_attributes, $attr);
    $faq_child = new Vayu_blocks_faq_child($attr,$content);

    return $faq_child->render();
    
} 