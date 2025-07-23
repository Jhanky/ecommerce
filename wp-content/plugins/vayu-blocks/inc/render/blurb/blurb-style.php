<?php 

 if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 


function vayu_blurb_style($attr){

	
    if ((new VAYUBLOCKS_DISPLAY_CONDITION($attr))->display()) {
        return '';
    }

    $css = "";

	 // THESE  4 LINES to be add to implement NEW Advance tab styles
	 $uniqueId = $attr['uniqueId'];
	 $OBJ_STYLE = new VAYUBLOCKS_RESPONSIVE_STYLE($attr);
	 $wrapper = "#{$attr['uniqueId']}.wp-block-vayu-blocks-blurb";
	 $css .= $OBJ_STYLE->advanceStyle($wrapper);
	 // THESE  4 LINES to be add to implement NEW Advance tab styles
       
    return $css;

}