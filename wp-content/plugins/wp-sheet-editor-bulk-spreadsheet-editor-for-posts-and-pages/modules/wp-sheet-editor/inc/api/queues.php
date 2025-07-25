<?php defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WPSE_Queues' ) ) {

	class WPSE_Queues {

		private static $instance = null;
		var $directory           = null;
		var $secret_key          = null;

		private function __construct() {
		}

		function file_expiration_hours() {
			// Expire in 7 days
			return apply_filters( 'vg_sheet_editor/queues/file_expiration_hours', 24 * 7 );
		}

		function maybe_create_directories() {
			if ( ! is_dir( $this->directory ) ) {
				wp_mkdir_p( $this->directory );
			}
			if ( ! file_exists( $this->directory . '/index.html' ) ) {
				file_put_contents( $this->directory . '/index.html', '' );
			}
			if ( ! file_exists( $this->directory . '/.htaccess' ) ) {
				file_put_contents( $this->directory . '/.htaccess', 'deny from all' );
			}
		}

		function delete_old_files() {
			$files = VGSE()->helpers->get_files_list( $this->directory, '.txt' );
			foreach ( $files as $file ) {
				$expiration_hours = (int) $this->file_expiration_hours();
				if ( file_exists( $file ) && ( time() - filemtime( $file ) > $expiration_hours * 3600 ) ) {
					unlink( $file );
				}
			}
		}

		function get_job_file( $job_id ) {
			$file_name = str_replace( array( '.', '/', '\\', ':' ), '', wp_normalize_path( sanitize_file_name( $job_id . '-' . $this->secret_key ) ) );
			$file_path = wp_normalize_path( $this->directory . '/' . $file_name . '.txt' );
			if ( ! file_exists( $file_path ) ) {
				file_put_contents( $file_path, '' );
			}
			return $file_path;
		}

		/**
		 * Deprecated. No need to remove rows from the queue file because we read the queue file by position
		 *
		 * @param  string  $job_id
		 * @param  integer $number
		 * @deprecated version
		 * @return void
		 */
		function mark_tasks_as_processed( $job_id, $number = 10 ) {
			return true;
		}

		function get_tasks_for_processing( $job_id, $number = 10, $file_position = 0 ) {

			$out       = array(
				'lines'         => array(),
				'file_position' => 0,
			);
			$file_path = $this->get_job_file( $job_id );
			if ( ! file_exists( $file_path ) ) {
				return $out;
			}

			// Open the file
			$batch_lines = VGSE()->helpers->get_lines_from_file( $file_path, $number, $file_position );
			foreach ( $batch_lines['lines'] as $index => $line ) {
				$batch_lines['lines'][ $index ] = json_decode( $line, true );
			}
			return $batch_lines;
		}

		function count_tasks( $job_id ) {

			$file_path = $this->get_job_file( $job_id );
			if ( ! file_exists( $file_path ) ) {
				return false;
			}
			return VGSE()->helpers->count_lines_in_file( $file_path );
		}

		function queue_exists( $job_id ) {

			$file_path = $this->get_job_file( $job_id );
			if ( ! file_exists( $file_path ) ) {
				return false;
			}

			$first_line = $this->get_tasks_for_processing( $job_id, 1 );
			return ! empty( $first_line['lines'] );
		}

		function entry( $task, $job_id ) {
			$this->bulk_entry( array( $task ), $job_id );
			return $this;
		}

		function bulk_entry( $tasks, $job_id ) {
			$file_path = $this->get_job_file( $job_id );
			if ( ! file_exists( $file_path ) ) {
				return $this;
			}
			foreach ( $tasks as $task ) {
				file_put_contents( $file_path, json_encode( $task ) . PHP_EOL, FILE_APPEND );
			}
			return $this;
		}

		function init() {
			// We use the secret key to add extra security to the file names
			$this->secret_key = get_option( 'vgse_secret_key', 'O0oGtcI8Zc' );
			$this->directory  = apply_filters( 'vg_sheet_editor/queues/directory', WP_CONTENT_DIR . '/uploads/wp-sheet-editor/queues' );
			do_action( 'wpse_delete_old_csvs', array( $this, 'delete_old_files' ) );
			if ( is_admin() ) {
				$this->maybe_create_directories();
				add_action( 'admin_init', array( $this, 'delete_old_files' ) );
			}
		}

		/**
		 * Creates or returns an instance of this class.
		 */
		static function get_instance() {
			if ( null == WPSE_Queues::$instance ) {
				WPSE_Queues::$instance = new WPSE_Queues();
				WPSE_Queues::$instance->init();
			}
			return WPSE_Queues::$instance;
		}

		function __set( $name, $value ) {
			$this->$name = $value;
		}

		function __get( $name ) {
			return $this->$name;
		}
	}

}

if ( ! function_exists( 'WPSE_Queues_Obj' ) ) {

	/**
	 * @return WPSE_Queues
	 */
	function WPSE_Queues_Obj() {
		return WPSE_Queues::get_instance();
	}

}
WPSE_Queues_Obj();
