<?php
namespace WowDiviCarouselLite;

defined( 'ABSPATH' ) || die();

class Admin_Dashboard {

	const MODULES_NONCE = 'wdcl_save_admin';

	public function __construct() {
		if( !wdcl_has_pro() ) {
			add_action( 'admin_menu', array( __CLASS__, 'add_menu' ), 21 );
		}
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ), 21 );
		add_filter( 'plugin_action_links_' . plugin_basename( WDCL_PLUGIN_FILE ), array( __CLASS__, 'add_action_links' ) );
	}

	public static function add_menu() {
		add_menu_page(
			__( 'WowCarousel', 'wdcl-wow-divi-carousel-lite' ),
			__( 'WowCarousel', 'wdcl-wow-divi-carousel-lite' ),
			'manage_options',
			'wow-divi-carousel-lite',
			array( __CLASS__, 'render_main' ),
			wdcl_white_svg_icon(),
			111
		);

	}

	public static function add_action_links( $links ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			return $links;
		}

		$links = array_merge(
			$links,
			array(
				sprintf(
					'<a target="_blank" style="color:#e2498a; font-weight: bold;" href="%s">%s</a>',
					'https://divipeople.com/plugins/wow-carousel/',
					esc_html__( 'Get Pro', 'wdcl-wow-divi-carousel-lite' )
				),
			)
		);

		return $links;
	}

	public static function enqueue_scripts() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		wp_enqueue_style(
			'wdcl-admin',
			WDCL_PLUGIN_ASSETS . 'admin/css/admin.css'
		);

		wp_enqueue_script(
			'wdcl-admin-js',
			WDCL_PLUGIN_ASSETS . 'admin/js/admin.js',
			array( 'jquery' ),
			WDCL_PLUGIN_VERSION,
			true
		);

		wp_localize_script( 
			'wdcl-admin-js', 
			'dismissible_notice', 
			array( 
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'wdcl-dismiss-notice' ),
				'action'  => 'wdcl-dismiss-notice',
			) 
		);

	}

	private static function get_all_modules() {

		$modules_map = array(

			'image-carousel'   => array(
				'demo'    => 'https://demo.divipeople.com/plugins/wow-carousel/wow-image-carousel/',
				'title'   => __( 'Image Carousel', 'wdcl-wow-divi-carousel-lite' ),
				'is_free' => true,
			),

			'logo-carousel'    => array(
				'demo'    => 'https://demo.divipeople.com/plugins/wow-carousel/wow-logo-carousel/',
				'title'   => __( 'Logo Carousel', 'wdcl-wow-divi-carousel-lite' ),
				'is_free' => true,
			),

			'content-carousel' => array(
				'demo'    => 'https://demo.divipeople.com/plugins/wow-carousel/wow-content-carousel/',
				'title'   => __( 'Content Carousel', 'wdcl-wow-divi-carousel-lite' ),
				'is_free' => false,
			),

			'card-carousel'    => array(
				'demo'    => 'https://demo.divipeople.com/plugins/wow-carousel/wow-card-carousel/',
				'title'   => __( 'Card Carousel', 'wdcl-wow-divi-carousel-lite' ),
				'is_free' => false,
			),

			'team-carousel'    => array(
				'demo'    => 'https://demo.divipeople.com/plugins/wow-carousel/wow-team-carousel/',
				'title'   => __( 'Team Carousel', 'wdcl-wow-divi-carousel-lite' ),
				'is_free' => false,
			),

			'testimonial'      => array(
				'demo'    => 'https://demo.divipeople.com/plugins/wow-carousel/wow-testimonial-carousel/',
				'title'   => __( 'Testimonial Carousel', 'wdcl-wow-divi-carousel-lite' ),
				'is_free' => false,
			),

			'divi-library'     => array(
				'demo'    => 'https://demo.divipeople.com/plugins/wow-carousel/wow-smart-slider/',
				'title'   => __( 'Divi Library Carousel', 'wdcl-wow-divi-carousel-lite' ),
				'is_free' => false,
			),

			'post-carousel'    => array(
				'demo'    => 'https://demo.divipeople.com/plugins/wow-carousel/wow-post-carousel/',
				'title'   => __( 'Post Carousel', 'wdcl-wow-divi-carousel-lite' ),
				'is_free' => false,
			),

			'twitter-feed'     => array(
				'demo'    => 'https://demo.divipeople.com/plugins/wow-carousel/wow-twitter-feed/',
				'title'   => __( 'Twitter Feed', 'wdcl-wow-divi-carousel-lite' ),
				'is_free' => true,
			),

			'product-carousel' => array(
				'demo'    => 'https://demo.divipeople.com/plugins/wow-carousel/wow-woocommerce-products/',
				'title'   => __( 'Product Carousel', 'wdcl-wow-divi-carousel-lite' ),
				'is_free' => false,
			),

			'google-reviews'   => array(
				'demo'    => 'https://demo.divipeople.com/plugins/wow-carousel/wow-google-review/',
				'title'   => __( 'Google Review', 'wdcl-wow-divi-carousel-lite' ),
				'is_free' => false,
			),

			'instagram-feed'   => array(
				'demo'    => 'https://demo.divipeople.com/plugins/wow-carousel/wow-instagram-feed/',
				'title'   => __( 'Instagram Feed', 'wdcl-wow-divi-carousel-lite' ),
				'is_free' => false,
			),

		);

		return $modules_map;
	}

	public static function get_modules() {

		$modules_map = self::get_all_modules();

		return $modules_map;
	}

	private static function load_template( $template ) {
		$file = WDCL_PLUGIN_DIR . 'templates/admin/admin-' . $template . '.php';
		if ( is_readable( $file ) ) {
			include $file;
		}
	}

	public static function render_main() {
		self::load_template( 'main' );
	}

}

new Admin_Dashboard();
