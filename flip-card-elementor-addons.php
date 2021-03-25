<?php
/**
 *
 * @link              https://codember.com/
 * @since             1.0
 * @package           Flip Card Addons For Elementor
 *
 * @wordpress-plugin
 * Plugin Name:       Flip Card Addons For Elementor
 * Plugin URI:        https://codember.com/
 * Description: 	  An Ultimate Addons For Elementor
 * Version:           1.1
 * Author:            Codember
 * Author URI:        https://codember.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: 	  flip_card_addons_elementor
 * Tested up to:      5.5

 */


	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	/**
	 * @since 1.0
	 */

	final class Flip_Card_Addons_Elementor {
		/**
		 * @since 1.0
		 * @var string The plugin version.
		 */
		const VERSION = '1.0';

		/**
		 * Minimum Elementor Version
		 *
		 * @since 1.0
		 * @var string Minimum Elementor version required to run the plugin.
		 */
		const MINIMUM_ELEMENTOR_VERSION = '2.0.0';


		/**
		 * Minimum PHP Version
		 *
		 * @since 1.2.0
		 * @var string Minimum PHP version required to run the plugin.
		 */
		const MINIMUM_PHP_VERSION = '7.0';

		/**
		 * Constructor
		 *
		 * @since 1.0.0
		 * @access public
		 */

		public function __construct() {

			// Load translation
			add_action( 'init', array( $this, 'i18n' ) );

			// Init Plugin
			add_action( 'plugins_loaded', array( $this, 'init' ) );
		}

		/**
		 * Load Textdomain
		 *
		 * Load plugin localization files.
		 * Fired by `init` action hook.
		 *
		 * @since 1.0
		 * @access public
		 */
		public function i18n() {
			load_plugin_textdomain( 'flip_card_addons_elementor' );
		}

		/**
		 * Initialize the plugin
		 *
		 * Fired by `plugins_loaded` action hook.
		 *
		 * @since 1.2.0
		 * @access public
		 */

		public function init() {

			// Check if Elementor installed and activated
			if ( ! did_action( 'elementor/loaded' ) ) {
				add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
				return;
			}


			// Check for required Elementor version
			if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
				add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
				return;
			}

			// Check for required PHP version
			if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
				add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
				return;
			}

			// Once we get here, We have passed all validation checks so we can safely include our plugin
			require_once( 'plugin.php' );
		}

		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have Elementor installed or activated.
		 *
		 * @since 1.0.0
		 * @access public
		 */

		public function admin_notice_missing_main_plugin() {
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}


			$message = sprintf(
				/* translators: 1: Plugin name 2: Elementor */
				esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'flip_card_addons_elementor' ),
				'<strong>' . esc_html__( 'Waze Map For Elementor', 'flip_card_addons_elementor' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'flip_card_addons_elementor' ) . '</strong>'
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}


	}