<?php
/**
 * Plugin Name:     WPeMatico Boilerplate
 * Plugin URI:      @todo
 * Description:     WPeMatico Add-on starter point Boilerplate plugin 
 * Version:         1.0.1
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

	// Plugin version
	if(!defined('BOILERPLATE_VER')) {
		define('BOILERPLATE_VER', '1.0.1' );
	}
	
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
                self::$instance = new self();
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
         * @access      public
         * @since       1.0.0
         * @return      void
         */
       public static function setup_constants() {
			// Plugin root file
			if(!defined('BOILERPLATE_ROOT_FILE')) {
				define('BOILERPLATE_ROOT_FILE', __FILE__ );
			}
            // Plugin path
			if(!defined('BOILERPLATE_DIR')) {
				define('BOILERPLATE_DIR', plugin_dir_path( __FILE__ ) );
			}
            // Plugin URL
			if(!defined('BOILERPLATE_URL')) {
				define('BOILERPLATE_URL', plugin_dir_url( __FILE__ ) );
			}
			if(!defined('BOILERPLATE_STORE_URL')) {
				define('BOILERPLATE_STORE_URL', 'https://etruel.com'); 
			} 
			if(!defined('BOILERPLATE_ITEM_NAME')) {
				define('BOILERPLATE_ITEM_NAME', 'WPeMatico Boilerplate'); 
			} 
        }


        /**
         * Include necessary files
         *
         * @access      public
         * @since       1.0.0
         * @return      void
         */
         public static function includes() {
            // Include scripts
			
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
         * @access      public
         * @since       1.0.0
         * @return      void
         *
         */
         public static function hooks() {
            // Register settings
            add_filter( 'wpematico_settings_extensions', array(__CLASS__, 'settings' ), 1 );
			add_filter( 'wpematico_plugins_updater_args', array(__CLASS__, 'add_updater'), 10, 1);
           
        }
		
		public static function add_updater($args) {
			if (empty($args['boilerplate'])) {
				$args['boilerplate'] = array();
				$args['boilerplate']['api_url'] = BOILERPLATE_STORE_URL;
				$args['boilerplate']['plugin_file'] = BOILERPLATE_ROOT_FILE;
				$args['boilerplate']['api_data'] = array(
														'version' 	=> BOILERPLATE_VER, 				// current version number
														'item_name' => BOILERPLATE_ITEM_NAME, 	// name of this plugin
														'author' 	=> 'Esteban Truelsegaard'  // author of this plugin
													);
					
			}
			return $args;
		}
        /**
         * Internationalization
         *
         * @access      public
         * @since       1.0.0
         * @return      void
         */
         public static function load_textdomain() {
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
        public static function settings( $settings ) {
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
//Boilerplate_load();
add_action( 'plugins_loaded', 'Boilerplate_load',999);

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
