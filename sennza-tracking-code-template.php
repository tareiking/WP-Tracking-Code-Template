<?php

/**
 * Plugin name: Sennza Tracking Code Template
 * Description: Adds a page template which can be used to add custom tracking codes to your WordPress site
 * Author:		Sennza P/L
 */

if (!class_exists('Sennza_Tracking_Code_Template')) {

	class Sennza_Tracking_Code_Template
	{

		/**
		 * A Unique Identifier
		 */
		protected $plugin_slug;

		/**
		 * A reference to an instance of this class.
		 */
		private static $instance;

		/**
		 * The array of templates that this plugin tracks.
		 */
		protected $templates;

		/**
		 * Returns an instance of this class.
		 */
		public static function get_instance() {

			if (null == self::$instance) {
				self::$instance = new Sennza_Tracking_Code_Template();
			}

			return self::$instance;
		}

		/**
		 * Initializes the plugin by setting filters and administration functions.
		 */
		private function __construct() {

			// Add ACF to theme setup
			add_filter( 'after_setup_theme', array( $this, 'load_acf' ) );

			// Check whether we are using the template
			add_action( 'after_setup_theme', array( $this, 'use_template' ) );

			// Enqueue Header Codes
			add_action( 'wp_head', array( $this, 'enqueue_header_code' ) );

			// Footer Codes
			add_action( 'wp_footer', array( $this, 'enqueue_footer_code' ) );

			// ACF Location filter example
			// add_filter( 'stct_display_options', array( $this, 'change_acf_location') );

		}

		/**
		 * Adds our template to the pages cache in order to trick WordPress
		 * into thinking the template file exists where it doens't really exist.
		 *
		 */
		function use_template(){
			/**
			 * stct_use_template filter
			 *
			 * Enable usage of tracking-code.php template within plugin
			 *
			 * Usage: add_filter( 'stct_use_template', __return_false() );
			 */

			$default_use_template = true;

			$use_template = apply_filters( 'stct_use_template', $default_use_template );

			if ( $use_template ) {

				$this->templates = array();

				// Add a filter to the attributes metabox to inject template into the cache.
				add_filter('page_attributes_dropdown_pages_args', array( $this, 'register_project_templates' ) );

				// Add a filter to the save post to inject out template into the page cache
				add_filter('wp_insert_post_data', array( $this, 'register_project_templates' ) );

				// Add a filter to the template include to determine if the page has our
				// template assigned and return it's path
				add_filter('template_include', array( $this, 'view_project_template' ) );

				// Add your templates to this array.
				$this->templates = array( 'tracking-code.php' => 'Tracking Code Template', );

			}
		}

		public function register_project_templates($atts) {

			// Create the key used for the themes cache
			$cache_key = 'page_templates-' . md5(get_theme_root() . '/' . get_stylesheet());

			// Retrieve the cache list.
			// If it doesn't exist, or it's empty prepare an array
			$templates = wp_get_theme()->get_page_templates();
			if (empty($templates)) {
				$templates = array();
			}

			// New cache, therefore remove the old one
			wp_cache_delete($cache_key, 'themes');

			// Now add our template to the list of templates by merging our templates
			// with the existing templates array from the cache.
			$templates = array_merge($templates, $this->templates);

			// Add the modified cache to allow WordPress to pick it up for listing
			// available templates
			wp_cache_add($cache_key, $templates, 'themes', 1800);

			return $atts;
		}

		/**
		 * Checks if the template is assigned to the page
		 */
		public function view_project_template($template) {

			global $post;

			if (!isset($this->templates[get_post_meta($post->ID, '_wp_page_template', true) ])) {

				return $template;
			}

			$file = plugin_dir_path(__FILE__) . get_post_meta($post->ID, '_wp_page_template', true);

			// Just to be safe, we check if the file exist first
			if (file_exists($file)) {
				return $file;
			} else {
				echo $file;
			}

			return $template;
		}
		/**
		 * Load the ACF fields for tracking
		 * @todo include ACF
		 */
		function load_acf(){
				require_once( plugin_dir_path( __FILE__ ) . 'inc/acf.php' );
		}

		/**
		 * Add conversion codes to page headers
		 */
		function enqueue_header_code() {

			global $post;
			// Check we have content in our header scripts area
			if ( get_field('header_code' ) ):
				echo the_field( 'header_code' );
			endif;
		}

		/**
		 * Add conversion codes to page footers
		 */
		function enqueue_footer_code() {

			global $post;
			// Check we have content in our header scripts area
			if ( get_field('other_codes' ) ):
				echo the_field( 'other_codes' );
			endif;

		}

		/**
		 * Change the ACF location array which controls visibility
		 *
		 * This example shows meta boxes on all pages.
		 */
		function change_acf_location( $acf_location ) {

			$acf_location =	array (
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'post',
							'order_no' => 0,
							'group_no' => 0,
						);

			return $acf_location;
		}

	}
}

add_action('plugins_loaded', array( 'Sennza_Tracking_Code_Template', 'get_instance' ) );
