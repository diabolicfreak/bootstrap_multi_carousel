<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */
class Plugin_Name_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-name-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        wp_enqueue_media();
		wp_enqueue_script( 'angularjs-js', 'https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'bootstrap-multi-carousel-admin-js', plugin_dir_url( __FILE__ ) . 'js/bootstrap-multi-carousel-admin.js', array( 'jquery' ), $this->version, true );
        // Make 'slides_array' available within 'bootstrap-multi-carousel-admin-js'
        $slides = get_option('slides_array');
        // wp_die($slides);
        $slides = str_replace("\\","", $slides);
        wp_localize_script('bootstrap-multi-carousel-admin-js', 'slides_array', $slides);
	}

/**
 * Register menus on the admin side
 * @return [type] [description]
 */
    public function bootstrap_multi_carousel_create_menu() {
        add_menu_page(
            'Bootstrap Multi Carousel Plugin',
            'Bootstrap Multi Carousel',
            'manage_options',
            'bootstrap_multi_carousel_main_menu',
            array($this, 'bootstrap_multi_carousel_main_menu_page'),
            'dashicons-images-alt2',
            4
        );
        add_action('admin_init', array($this, 'bootstrap_multi_carousel_settings'));
    }
    //Register settings
    public function bootstrap_multi_carousel_settings() {
        register_setting(
            'bootstrap_multi_carousel_settings_group',
            'bootstrap_multi_carousel_options',
            array($this, 'bootstrap_multi_carousel_sanitize_options')
        );
    }
    // Sanitize input function
    function bootstrap_multi_carousel_sanitize_options($input){
        return $input;
    }
    //Register page definition
    public function bootstrap_multi_carousel_main_menu_page(){
        ?>

        <div class="wrap" ng-app="BMCAdmin">
            <h2>Zircon Carousel Plugin Option</h2>
            <form action="options.php" method="post" ng-controller="BMCAdminController">
                <!-- <?php settings_fields('acme-footer-settings-slides-group') ?> -->
                <!-- <?php $bootstrap_multi_carousel_options = get_option('bootstrap_multi_carousel_options') ?> -->
                <table class="form-table">
                    <tr valign="top" ng-repeat="slide in slides">
                        <th scope="row">
                            Slide url - {{$index+1}}
                        </th>
                        <td>
                            <input type="text" name="acme_footer_slides[{{slide.order}}]" ng-model="slide.url">
                            <button type="button" name="button" class="button" ng-click="imageUpload(slide)">Upload Slide</button>
                            <button type="button" name="button" class="button" ng-click="deleteSlide(slide)">Delete Slide</button>
                        </td>
                    </tr>

                    <tr valign="top">
                        <td>
                            <button type="button" name="button" class="button" ng-click="addSlide()">Add new slide</button>
                        </td>
                    </tr>

                    <tr valign="top">
                        <td>
                            <button type="button" name="button" class="button button-primary" ng-click="submitformhandler()">Save Changes</button>
                        </td>
                    </tr>

                </table>
            </form>
        </div>

        <?php
    }

    public function bootstrap_multi_carousel_ajax_save_BMCslides() {
        // $option = $_POST['option'];
        // $new_value = $_POST['new_value'];
        // $slideUrlArrayKey = $_POST['slide_url_array_key'];
        $slides_array = $_POST['slides_array'];
        $slideUrlArrayValues = $_POST['slide_url_only_array'];
        update_option( 'slides_array', $slides_array );
        update_option( 'slide_url_only_array', $slideUrlArrayValues );
    }

}
