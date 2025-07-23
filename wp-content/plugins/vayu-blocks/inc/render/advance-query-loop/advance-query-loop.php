<?php 

if ( ! defined( 'ABSPATH' ) ) {
   exit;
} 

add_filter('rest_post_query', function ($args, $request) {
    if (!empty($request['orderby']) && $request['orderby'] === 'comment_count') {
        // Ensure the context is relevant (e.g., specific block usage)
        if ($request->get_param('block_context') === 'vayu-blocks/advance-query-loop') {
            $args['orderby'] = 'comment_count';
        }elseif ($request['orderby'] === 'rand') {
            $args['orderby'] = 'rand'; 
        }
    }
    return $args;
}, 10, 2);


add_filter('rest_post_collection_params', function ($params) {
    $params['orderby']['enum'][] = 'comment_count';
    $params['orderby']['enum'][] = 'rand';
    return $params;
});

function vayu_advance_loop_style($attr){


    $OBJ_STYLE = new VAYUBLOCKS_RESPONSIVE_STYLE($attr);

    $css = "";

	$wrapper = "#{$attr['uniqueId']}.wp-block-vayu-blocks-advance-query-loop";

	$css .= $OBJ_STYLE->advanceStyle($wrapper);
    
    if (isset($attr['advResponsive']['Desktop']) && $attr['advResponsive']['Desktop'] === true) {
					$css .= "@media only screen and (min-width: 1024px) { .{$attr['uniqueId']} { display: none; } }";
				}

				if (
					isset($attr['advResponsive']['Tablet']) &&
					$attr['advResponsive']['Tablet'] === true
				) {
					$css .= "@media only screen and (min-width: 768px) and (max-width: 1023px) { .{$attr['uniqueId']} { display: none; } }";
				}

				if (
					isset($attr['advResponsive']['Mobile']) &&
					$attr['advResponsive']['Mobile'] === true
				) {
					$css .= "@media only screen and (max-width: 767px) { .{$attr['uniqueId']} { display: none; } }";
				}

    return $css;

}