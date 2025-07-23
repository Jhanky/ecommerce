<?php

 if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

function vayu_swiper_slider_style($attr){

	if ((new VAYUBLOCKS_DISPLAY_CONDITION($attr))->display()) {
        return ;
    }

    $OBJ_STYLE = new VAYUBLOCKS_RESPONSIVE_STYLE($attr);

    $css = '';

    if(isset( $attr['uniqueId'] )){

		$wrapper = ".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']}";

	    $css .= $OBJ_STYLE->advanceStyle($wrapper);

        /*******************/ 
        // slide option
		/*******************/ 

		if(isset($attr['swipeStartGap'])){
			$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .swipe-slider-content{";
			$css .= "max-width: {$attr['swipeStartGap']['Desktop']};";
			$css .="}";
		}else{
			$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .swipe-slider-content{";
			$css .= "max-width:1140px;";
			$css .="}";
		}
		
		if (isset($attr['swipeslideWidth'])){
			$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .swipe-carousel .slide-item{";
			$css .= "width: {$attr['swipeslideWidth']['Desktop']};";
			$css .="}";
	    }else{
			$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .swipe-carousel .slide-item{";
			$css .= "width:300px;";
			$css .="}";
		}

        if (isset($attr['swipeslideGap'])) {
			$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .swipe-carousel .slide-item{";
			$css .= "margin-right: {$attr['swipeslideGap']['Desktop']};";
			$css .="}";
		}else{
			$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .swipe-carousel .slide-item{";
			$css .= "margin-right:10px;";
			$css .="}";
		}

        /**************************/ 
        // slide navigation option
		/***************************/ 

		if(isset($attr['swipeNavSize'])){
			$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .scroll-button span{";
			$css .= "height: {$attr['swipeNavSize']['Desktop']}px;
			         width: {$attr['swipeNavSize']['Desktop']}px;
					 font-size:{$attr['swipeNavSize']['Desktop']}px;";
			$css .="}";
		}

		if(isset($attr['swipeNavPostion'])){
			$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .scroll-button.left{";
			$css .= "left: {$attr['swipeNavPostion']['Desktop']}px;";
			$css .="}";
			$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .scroll-button.right{";
			$css .= "right: {$attr['swipeNavPostion']['Desktop']}px;";
			$css .="}";
		}

		//navcolor

		if(isset($attr['navcolor'])){
		$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .scroll-button span{";
		$css .= isset( $attr['navcolor'] ) ? "color:{$attr['navcolor']};" : '';
		$css .="}";
		}

		$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .scroll-button{";
		$css .= isset( $attr['navbgcolor'] ) ? "background:{$attr['navbgcolor']};" : '';
		$css .= $OBJ_STYLE->borderRadiusShadow('naviconsBorder','naviconsRadius','','Desktop');
		$css .="}"; 
	
		/**************************/ 
        // slide pagination option
		/***************************/ 
		if(isset($attr['swipePagiSize'])){
			$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .pagination-container .pagination-dot{";
			$css .= "width:{$attr['swipePagiSize']['Desktop']}px;height: {$attr['swipePagiSize']['Desktop']}px;";
			$css .="}";
		}

		//pagicolor
		if(isset($attr['pagicolor'])){
			$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .pagination-dot{";
			$css .= isset( $attr['pagicolor'] ) ? "background:{$attr['pagicolor']};" : '';
			$css .="}";
			}
			if(isset($attr['pagiActivecolor'])){
			$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .pagination-dot.active{";
			$css .= isset( $attr['pagiActivecolor'] ) ? "background:{$attr['pagiActivecolor']};" : '';
			$css .="}";
		    }

      //tablet view
      $css .= "@media only screen and (min-width: 768px) and (max-width: 1023px){";
	
	     /*******************/ 
        // slide option Tablet
		/*******************/ 

		if(isset($attr['swipeStartGap'])){
			$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .swipe-slider-content{";
			$css .= "max-width: {$attr['swipeStartGap']['Tablet']};";
			$css .="}";
		}
		
		if (isset($attr['swipeslideWidth']) || isset($attr['swipeslideGap'])){
			$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .swipe-carousel .slide-item{";
			if (isset($attr['swipeslideWidth'])) {
				$css .= "width: {$attr['swipeslideWidth']['Tablet']};";
			}
			if (isset($attr['swipeslideGap'])) {
				$css .= "margin-right: {$attr['swipeslideGap']['Tablet']};";
			}
			$css .="}";
	    }

       

        /**************************/ 
        // slide navigation option
		/***************************/ 

		if(isset($attr['swipeNavSize'])){
			$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .scroll-button span{";
			$css .= "height: {$attr['swipeNavSize']['Tablet']}px;
			         width: {$attr['swipeNavSize']['Tablet']}px;
					 font-size:{$attr['swipeNavSize']['Tablet']}px;";
			$css .="}";
		}

		if(isset($attr['swipeNavPostion'])){
			$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .scroll-button.left{";
			$css .= "left: {$attr['swipeNavPostion']['Tablet']}px;";
			$css .="}";
			$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .scroll-button.right{";
			$css .= "right: {$attr['swipeNavPostion']['Tablet']}px;";
			$css .="}";
		}

		$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .scroll-button{";
		$css .= $OBJ_STYLE->borderRadiusShadow('naviconsBorder','naviconsRadius','','Tablet');
		$css .="}"; 
	
		/**************************/ 
        // slide pagination option
		/***************************/ 
		if(isset($attr['swipePagiSize'])){
			$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .pagination-container .pagination-dot{";
			$css .= "width:{$attr['swipePagiSize']['Tablet']}px;height: {$attr['swipePagiSize']['Tablet']}px;";
			$css .="}";
		}

	  
	  $css .="}";//tablet end

	  //mobile view
      $css .= "@media only screen and (max-width: 767px){";

	    /*******************/ 
        // slide option Tablet
		/*******************/ 

		if(isset($attr['swipeStartGap'])){
			$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .swipe-slider-content{";
			$css .= "max-width: {$attr['swipeStartGap']['Mobile']};";
			$css .="}";
		}
		
		if (isset($attr['swipeslideWidth']) || isset($attr['swipeslideGap'])){
			$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .swipe-carousel .slide-item{";
			if (isset($attr['swipeslideWidth'])) {
				$css .= "width: {$attr['swipeslideWidth']['Mobile']};";
			}
			if (isset($attr['swipeslideGap'])) {
				$css .= "margin-right: {$attr['swipeslideGap']['Mobile']};";
			}
			$css .="}";
	    }

       

        /**************************/ 
        // slide navigation option
		/***************************/ 

		if(isset($attr['swipeNavSize'])){
			$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .scroll-button span{";
			$css .= "height: {$attr['swipeNavSize']['Mobile']}px;
			         width: {$attr['swipeNavSize']['Mobile']}px;
					 font-size:{$attr['swipeNavSize']['Mobile']}px;";
			$css .="}";
		}

		if(isset($attr['swipeNavPostion'])){
			$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .scroll-button.left{";
			$css .= "left: {$attr['swipeNavPostion']['Mobile']}px;";
			$css .="}";
			$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .scroll-button.right{";
			$css .= "right: {$attr['swipeNavPostion']['Mobile']}px;";
			$css .="}";
		}

		$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .scroll-button{";
		$css .= $OBJ_STYLE->borderRadiusShadow('naviconsBorder','naviconsRadius','','Mobile');
		$css .="}"; 
	
		/**************************/ 
        // slide pagination option
		/***************************/ 
		if(isset($attr['swipePagiSize'])){
			$css .=".wp-block-vayu-blocks-swipe-slider.{$attr['uniqueId']} .pagination-container .pagination-dot{";
			$css .= "width:{$attr['swipePagiSize']['Mobile']}px;height: {$attr['swipePagiSize']['Mobile']}px;";
			$css .="}";
		}
	  $css .="}";

	  if (isset($attr['advResponsive']['Desktop']) && $attr['advResponsive']['Desktop'] === true) {
					$css .= "@media only screen and (min-width: 1024px) { .{$attr['uniqueId']} { display: none; } }";
				}

				if (isset($attr['advResponsive']['Tablet']) && $attr['advResponsive']['Tablet'] === true
				) {
					$css .= "@media only screen and (min-width: 768px) and (max-width: 1023px) { .{$attr['uniqueId']} { display: none; } }";
				}

				if (
					isset($attr['advResponsive']['Mobile']) &&
					$attr['advResponsive']['Mobile'] === true
				) {
					$css .= "@media only screen and (max-width: 767px) { .{$attr['uniqueId']} { display: none; } }";
				}


    }

    return $css;

}