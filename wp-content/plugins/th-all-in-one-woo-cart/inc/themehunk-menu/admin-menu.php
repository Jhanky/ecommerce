<?php
if (!function_exists('themehunk_admin_menu')) {
  include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
  define('THEMEHUNK_PURL', plugin_dir_url(__FILE__));
  define('THEMEHUNK_PDIR', plugin_dir_path(__FILE__));

    add_action( 'wp_ajax_themehunk_activeplugin','themehunk_activeplugin');
    add_action('admin_menu',  'taiowc_admin_menu');
    add_action( 'admin_enqueue_scripts', 'taiowc_admin_scripts');

      if ( !function_exists('themehunk_activeplugin') ) {
        function themehunk_activeplugin(){
            if ( !is_user_logged_in() || ! current_user_can( 'administrator' ) ) {
               wp_die( - 1, 403 );
           }
          if (! isset( $_REQUEST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['nonce'] ) ), 'taiowc_admin_nonce' )
          ){
             wp_die( - 1, 403 );
          }
          if ( ! current_user_can( 'install_plugins' ) || ! isset( $_POST['init'] ) || ! sanitize_text_field(wp_unslash($_POST['init'])) ) {
           wp_send_json_error(
             array(
               'success' => false,
               'message' => __( 'No plugin specified', 'th-all-in-one-woo-cart' ),
             )
           );
         }
         $plugin_init = ( isset( $_POST['init'] ) ) ? sanitize_text_field( wp_unslash($_POST['init']) ) : '';
         $activate = activate_plugin( $plugin_init);
         if ( is_wp_error( $activate ) ) {
           wp_send_json_error(
             array(
               'success' => false,
               'message' => $activate->get_error_message(),
             )
           );
         }
         wp_send_json_success(
           array(
             'success' => true,
             'message' => __( 'Plugin Successfully Activated', 'th-all-in-one-woo-cart' ),
           )
         );
           }
       }

    function taiowc_admin_menu(){
            add_menu_page(__('ThemeHunk', 'th-all-in-one-woo-cart'), __('ThemeHunk', 'th-all-in-one-woo-cart'), 'manage_options', 'themehunk-plugins', 'taiowc_plugins',  THEMEHUNK_PURL . '/th-option/assets/images/ico.png', 59);
        }

    function taiowc_plugins(){

      if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'You do not have sufficient permissions to access this page.','th-all-in-one-woo-cart' ) );
        }

        include_once THEMEHUNK_PDIR . "/th-option/th-option.php";
        $obj = new themehunk_plugin_option();
        $obj->tab_page();
    }

function taiowc_admin_scripts( $hook ) {

    if ($hook === 'toplevel_page_themehunk-plugins'  ) {

      wp_enqueue_style( 'themehunk-plugin-css', THEMEHUNK_PURL . '/th-option/assets/css/started.css', array(), TAIOWC_VERSION );
      
      wp_enqueue_script('themehunk-plugin-js', THEMEHUNK_PURL . '/th-option/assets/js/th-options.js',array( 'jquery', 'updates' ),TAIOWC_VERSION, true);

      wp_localize_script(
          'themehunk-plugin-js', 'TAIOWCAdmin', array(
            'nonce'         => wp_create_nonce( 'taiowc_admin_nonce' ),
          )
      );

    }
  }

}