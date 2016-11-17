<?php
/**
 * Plugin Name:     WPeMatico Boilerplate
 * Plugin URI:      @todo
 * Description:     WPeMatico Add-on starter point Boilerplate plugin 
 * Version:         1.0.0
 * Author:          etruel
 * Author URI:      http://www.netmdp.com
 * Text Domain:     boilerplate
 *
 * @package         etruel\Boilerplate
 * @author          Esteban Truelsegaard
 * @copyright       Copyright (c) 2016
 *
 *
 * - Find all instances of @todo in the plugin and update the relevant
 *   areas as necessary.
 *
 * - All functions that are not class methods MUST be prefixed with the
 *   plugin name, replacing spaces with underscores. NOT PREFIXING YOUR
 *   FUNCTIONS CAN CAUSE PLUGIN CONFLICTS!
 */


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'Boilerplate' ) ) {

    /**
     * Main Boilerplate class
     *
     * @since       1.0.0
     */
    class Boilerplate {

        /**
         * @var         Boilerplate $instance The one true Boilerplate
         * @since       1.0.0
         */
        private static $instance;


        /**
         * Get active instance
         *
         * @access      public
         * @since       1.0.0
         * @return      object self::$instance The one true Boilerplate
         */
        public static function instance() {
            if( !self::$instance ) {
                self::$instance = new Boilerplate();
                self::$instance->setup_constants();
                self::$instance->includes();
                self::$instance->load_textdomain();
                self::$instance->hooks();
            }

            return self::$instance;
        }


        /**
         * Setup plugin constants
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         */
        private function setup_constants() {
            // Plugin version
            define( 'BOILERPLATE_VER', '1.0.0' );

            // Plugin path
            define( 'BOILERPLATE_DIR', plugin_dir_path( __FILE__ ) );

            // Plugin URL
            define( 'BOILERPLATE_URL', plugin_dir_url( __FILE__ ) );
			
			if(!defined( 'BOILERPLATE_STORE_URL' ) ) define( 'BOILERPLATE_STORE_URL', 'https://etruel.com' ); 
			if(!defined( 'BOILERPLATE_ITEM_NAME' ) ) define( 'BOILERPLATE_ITEM_NAME', 'WPeMatico Boilerplate' ); 
        }


        /**
         * Include necessary files
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         */
        private function includes() {
            // Include scripts
			if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) 
				if( file_exists( WPEMATICO_PLUGIN_DIR . 'app/lib/Plugin_Updater.php' ) )
					require_once ( WPEMATICO_PLUGIN_DIR . 'app/lib/Plugin_Updater.php' );
				else require_once ( BOILERPLATE_DIR . 'includes/Plugin_Updater.php' );
			require_once BOILERPLATE_DIR . 'includes/etruel_licenses_handler.php';
			require_once BOILERPLATE_DIR . 'includes/scripts.php';
			require_once BOILERPLATE_DIR . 'includes/settings.php';
            require_once BOILERPLATE_DIR . 'includes/plugin_functions.php';
            require_once BOILERPLATE_DIR . 'includes/functions.php';
            require_once BOILERPLATE_DIR . 'includes/campaign_edit.php';
            require_once BOILERPLATE_DIR . 'includes/processing.php';

            // require_once BOILERPLATE_DIR . 'includes/shortcodes.php';
            // require_once BOILERPLATE_DIR . 'includes/widgets.php';
        }


        /**
         * Run action and filter hooks
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         *
         */
        private function hooks() {
            // Register settings
            add_filter( 'wpematico_settings_extensions', array( $this, 'settings' ), 1 );

            // Handle licensing
            // @todo        Replace the Plugin Name and Your Name with your data
            if( class_exists( 'EDD_License' ) ) {
                $license = new EDD_License( __FILE__, BOILERPLATE_STORE_URL, BOILERPLATE_VER, 'Esteban Truelsegaard' );
            }
        }


        /**
         * Internationalization
         *
         * @access      public
         * @since       1.0.0
         * @return      void
         */
        public function load_textdomain() {
            // Set filter for language directory
            $lang_dir = BOILERPLATE_DIR . '/languages/';
            $lang_dir = apply_filters( 'boilerplate_languages_directory', $lang_dir );

            // Traditional WordPress plugin locale filter
            $locale = apply_filters( 'plugin_locale', get_locale(), 'boilerplate' );
            $mofile = sprintf( '%1$s-%2$s.mo', 'boilerplate', $locale );

            // Setup paths to current locale file
            $mofile_local   = $lang_dir . $mofile;
            $mofile_global  = WP_LANG_DIR . '/boilerplate/' . $mofile;

            if( file_exists( $mofile_global ) ) {
                // Look in global /wp-content/languages/boilerplate/ folder
                load_textdomain( 'boilerplate', $mofile_global );
            } elseif( file_exists( $mofile_local ) ) {
                // Look in local /wp-content/plugins/boilerplate/languages/ folder
                load_textdomain( 'boilerplate', $mofile_local );
            } else {
                // Load the default language files
                load_plugin_textdomain( 'boilerplate', false, $lang_dir );
            }
        }


        /**
         * Add settings
         *
         * @access      public
         * @since       1.0.0
         * @param       array $settings The existing EDD settings array
         * @return      array The modified EDD settings array
         */
        public function settings( $settings ) {
            $new_settings = array(
                array(
                    'id'    => 'boilerplate_settings',
                    'name'  => '<strong>' . __( 'Plugin Name Settings', 'boilerplate' ) . '</strong>',
                    'desc'  => __( 'Configure Plugin Name Settings', 'boilerplate' ),
                    'type'  => 'header',
                )
            );

            return array_merge( $settings, $new_settings );
        }
    }
} // End if class_exists check


/**
 * The main function responsible for returning the one true Boilerplate
 * instance to functions everywhere
 *
 * @since       1.0.0
 * @return      \Boilerplate The one true Boilerplate
 *
 * @todo        Inclusion of the activation code below isn't mandatory, but
 *              can prevent any number of errors, including fatal errors, in
 *              situations where your extension is activated but EDD is not
 *              present.
 */
function Boilerplate_load() {
    if( !class_exists( 'WPeMatico' ) ) {
        if( !class_exists( 'WPeMatico_Extension_Activation' ) ) {
            require_once 'includes/class.extension-activation.php';
        }

        $activation = new WPeMatico_Extension_Activation( plugin_dir_path( __FILE__ ), basename( __FILE__ ) );
        $activation = $activation->run();
    } else {
        return Boilerplate::instance();
    }
}
add_action( 'plugins_loaded', 'Boilerplate_load' );


/**
 * The activation hook is called outside of the singleton because WordPress doesn't
 * register the call from within the class, since we are preferring the plugins_loaded
 * hook for compatibility, we also can't reference a function inside the plugin class
 * for the activation function. If you need an activation function, put it here.
 *
 * @since       1.0.0
 * @return      void
 */
function boilerplate_activation() {
    /* Activation functions here */
}
register_activation_hook( __FILE__, 'boilerplate_activation' );
