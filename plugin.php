<?php
/**
 * Plugin Name: Arconix Testimonials
 * Plugin URI: http://arconixpc.com/plugins/arconix-testimonials
 * Description: Arconix Testimonials is a plugin which makes it easy for you to display customer feedback on your site
 *
 * Version: 1.2.0
 *
 * Author: John Gardner
 * Author URI: http://arconixpc.com/
 *
 * License: GNU General Public License v2.0
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 */

/**
 * Arconix Testimonials
 *
 * This is the base class which sets the version, loads dependencies and gets the plugin running
 *
 * @since 1.2.0
 */
class Arconix_Testimonials {

    /**
     * Plugin version.
     *
     * @since 1.2.0
     *
     * @var string plugin version
     */
    private $version;

    /**
     * The directory path to the plugin file's includes folder.
     *
     * @since   1.2.0
     * @access  private
     * @var     string      $dir    The directory path to the includes folder
     */
    private $inc;

    /**
     * Initialize the class and set its properties.
     *
     * @since   1.2.0
     */
    public function __construct() {
        $this->version = '1.2.0';
        $this->inc = trailingslashit( plugin_dir_path( __FILE__ ) . '/includes' );
        $this->load_dependencies();
        $this->load_admin();

        add_action( 'init', array( $this, 'metabox_init' ), 9999 );
    }

    /**
     * Conditionally load the metabox class
     *
     * @since   2.0.0
     */
    public function metabox_init() {
        if ( ! class_exists( 'cmb_Meta_Box' ) )
            require_once( $this->inc . 'metabox/init.php');
    }

    /**
     * Load the required dependencies for the plugin.
     *
     * - Admin loads the backend functionality
     * - Public provides front-end functionality
     * - Widgets loads the widget functionality
     * - Metabox loads the helper class for metabox creation
     * - Dashboard Glancer loads the helper class for the admin dashboard
     *
     * @since   1.2.0
     */
    private function load_dependencies() {
        require_once( $this->inc . 'class-arconix-testimonials-admin.php' );
        require_once( $this->inc . 'class-arconix-testimonials-public.php' );
        require_once( $this->inc . 'class-arconix-testimonials-widgets.php' );

        if ( ! class_exists( 'Gamajo_Dashboard_Glancer' ) )
            require_once( $this->inc . 'class-gamajo-dashboard-glancer.php' );
    }

    /**
     * Loads the admin functionality
     *
     * @since   1.2.0
     */
    private function load_admin() {
        new Arconix_Testimonials_Admin( $this->get_version() );
    }

    /**
     * Return the current version of the plugin
     *
     * @since   1.2.0
     * @return  string   Returns plugin version
     */
    public function get_version() {
        return $this->version;
    }

}

/** Vroom vroom */
add_action( 'plugins_loaded', 'arconix_testimonials_run' );
function arconix_testimonials_run() {
    new Arconix_Testimonials;
}