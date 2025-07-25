<?php
 return array(
     'vayu-blocks' => array(
        'name' => esc_html__('Vayu Blocks', 'th-all-in-one-woo-cart'),
        'img' => 'icon-128x128.png',
        'admin_link' =>   'vayu-blocks',
        'details' => esc_url('https://themehunk.com/vayu-blocks/'),
        'active_filename' => 'vayu-blocks/vayu-blocks.php',
    ),
    'th-advance-product-search' => array(
        'name' => esc_html__('TH Advance Product Search', 'th-all-in-one-woo-cart'),
        'img' => 'icon-128x128.gif',
        'admin_link' =>   'th-advance-product-search',
        'details' => esc_url('https://themehunk.com/th-product-compare-plugin/'),
        'active_filename' => 'th-advance-product-search/th-advance-product-search.php',
        'pro-plugin' => array(
            'init' => 'th-advance-product-search-pro/th-advance-product-search-pro.php',
            'admin_link' => 'th-advance-product-search-pro',
            'docs' => esc_url('https://themehunk.com/docs/th-advance-product-search/'),
        )
    ),

    'th-all-in-one-woo-cart' => array(
        'name' => esc_html__('Th All In One Woo Cart', 'th-all-in-one-woo-cart'),
        'img' => 'icon-128x128.gif',
        'details' => esc_url('https://themehunk.com/th-all-in-one-woo-cart/'),
        'admin_link' =>   'th-all-in-one-woo-cart',
        'active_filename' => 'th-all-in-one-woo-cart/th-all-in-one-woo-cart.php',
        'pro-plugin' => array(
            'init' => 'th-all-in-one-woo-cart-pro/th-all-in-one-woo-cart-pro.php',
            'admin_link' => 'taiowc-pro',
            'docs' => esc_url('https://themehunk.com/docs/th-all-in-one-woo-cart/')
        )
    ),

    'th-product-compare' => array(
        'name' => esc_html__('Th Product Compare', 'th-all-in-one-woo-cart'),
        'img' => 'icon-128x128.gif',
        'details' => esc_url('https://themehunk.com/th-product-compare-plugin/'),
        'active_filename' => 'th-product-compare/th-product-compare.php',
        'admin_link' =>   'th-product-compare',
        'pro-plugin' => array(
            'init' => 'th-product-compare-pro/th-product-compare-pro.php',
            'admin_link' => 'th-product-compare',
            'docs' => esc_url('https://themehunk.com/docs/th-product-compare/'),
        )
    ),

    'th-variation-swatches' => array(
        'name' => esc_html__('TH Variation Swatches', 'th-all-in-one-woo-cart'),
        'img' => 'icon-128x128.gif',
        'details' => esc_url('https://themehunk.com/th-variation-swatches/'),
        'active_filename' => 'th-variation-swatches/th-variation-swatches.php',
        'admin_link' =>   'th-variation-swatches',
        'pro-plugin' => array(
            'init' => 'th-variation-swatches-pro/th-variation-swatches-pro.php',
            'admin_link' => 'th-variation-swatches',
            'docs' => esc_url('https://themehunk.com/docs/th-variation-swatches-plugin/'),
        )
    ),
    'lead-form-builder' => array(
        'name' => esc_html__('Lead Form Builder', 'th-all-in-one-woo-cart'),
        'img' => 'icon-128x128.png',
        'details' => esc_url('https://themehunk.com/product/lead-form-builder-pro/'),
        'active_filename' => 'lead-form-builder/lead-form-builder.php',
        'admin_link' =>   'wplf-plugin-menu',
        'pro-plugin' => array(
            'init' => 'lead-form-builder-pro/init.php',
            'admin_link' => 'wplf-plugin-menu',
            'docs' => esc_url('https://themehunk.com/docs/lead-form-builder-pro/'),
        )
    ),
    'wp-popup-builder' => array(
        'name' => esc_html__('WP Popup Builder – Popup Forms & Newsletter', 'th-all-in-one-woo-cart'),
        'img' => 'icon-128x128.png',
        'details' => esc_url('https://themehunk.com/wp-popup-builder-pro/'),
        'active_filename' => 'wp-popup-builder/wp-popup-builder.php',
        'admin_link' =>   'wppb',
        'pro-plugin' => array(
            'init' => 'wp-popup-builder-pro/wp-popup-builder.php',
            'admin_link' => 'wppb',
            'docs' => esc_url('https://themehunk.com/docs/wp-popup-builder-pro/'),
        )
    ),
);
