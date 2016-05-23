<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 * @author     Your Name <email@example.com>
 */
class Plugin_Name_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

        // Enqueue twbs Bootsrap stylesheet
        wp_enqueue_style('twbs-bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css', array(), $this->version, 'all');
        // Enqueue twbs Bootsrap stylesheet
        wp_enqueue_style('fa-css', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css', array(), $this->version, 'all');
        // Bootsrap carousel plugin
		wp_enqueue_style( 'bs-carousel-admin-css', plugin_dir_url( __FILE__ ) . 'css/bs_carousel.css', array(), $this->version, 'all' );
        // Lightbox css
        wp_enqueue_style('lightbox-css', plugin_dir_url(__FILE__).'css/lightbox.min.css', array(), $this->version, 'all');
        // Plugin specific css
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/BMC_style-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

    // Enqueue twbs Bootsrap javaScript
    wp_enqueue_script('twbs-bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js', array('jquery'), $this->version, true);
    // Bootsrap carousel plugin
	wp_enqueue_script( 'bs-carousel-admin-js', plugin_dir_url( __FILE__ ) . 'js/bs_carousel.js', array( 'jquery' ), $this->version, true );
    //LightBox js
    wp_enqueue_script('lightbox-js', plugin_dir_url(__FILE__).'js/lightbox.min.js', array('jquery'), $this->version, true);
    // Plugin specific js
	wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/BMC_style-public.js', array( 'jquery' ), $this->version, true );

	}

    /**
     * BMC-style1
     *
     * Shortcode definition for BMC-style1
     *
     * @return HTML html code for shortcode
     */
    public function bootstrap_multi_carousel_style1_shortcode(){
        $slideUrlArrayValues = get_option('slide_url_only_array');
        ob_start(); ?>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="carousel carousel-showmanymoveone slide" id="carouselABC">
                    <div class="carousel-inner">
                        <?php
                        foreach (json_decode(stripslashes($slideUrlArrayValues)) as $key=>$slideUrl) {
                        ?>
                            <div class="item <?php if($key == 0) echo "active"; ?>">
                                <div class="col-xs-12 col-sm-4 col-md-2">
                                    <a href="<?php echo $slideUrl;?>" data-lightbox="BMC_images">
                                        <img src="<?php echo $slideUrl;?>" class="img-responsive">
                                    </a>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <a class="left carousel-control" href="#carouselABC" data-slide="prev"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></a>
                    <a class="right carousel-control" href="#carouselABC" data-slide="next"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * BMC-style2
     *
     * Shortcode definition for BMC-style2
     *
     * @return HTML html code for shortcode
     */
    public function bootstrap_multi_carousel_style2_shortcode(){
        ob_start(); ?>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="carousel carousel-showmanymoveone slide" id="carouselABC">
                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="col-xs-12 col-sm-4 col-md-2"><a href="#"><img src="http://placehold.it/500/0054A6/fff/&amp;text=A" class="img-responsive"></a></div>
                        </div>
                        <div class="item">
                            <div class="col-xs-12 col-sm-4 col-md-2"><a href="#"><img src="http://placehold.it/500/002d5a/fff/&amp;text=B" class="img-responsive"></a></div>
                        </div>
                        <div class="item">
                            <div class="col-xs-12 col-sm-4 col-md-2"><a href="#"><img src="http://placehold.it/500/d6d6d6/333&amp;text=C" class="img-responsive"></a></div>
                        </div>
                        <div class="item">
                            <div class="col-xs-12 col-sm-4 col-md-2"><a href="#"><img src="http://placehold.it/500/002040/eeeeee&amp;text=D" class="img-responsive"></a></div>
                        </div>
                        <div class="item">
                            <div class="col-xs-12 col-sm-4 col-md-2"><a href="#"><img src="http://placehold.it/500/0054A6/fff/&amp;text=E" class="img-responsive"></a></div>
                        </div>
                        <div class="item">
                            <div class="col-xs-12 col-sm-4 col-md-2"><a href="#"><img src="http://placehold.it/500/002d5a/fff/&amp;text=F" class="img-responsive"></a></div>
                        </div>
                        <div class="item">
                            <div class="col-xs-12 col-sm-4 col-md-2"><a href="#"><img src="http://placehold.it/500/eeeeee&amp;text=G" class="img-responsive"></a></div>
                        </div>
                        <div class="item">
                            <div class="col-xs-12 col-sm-4 col-md-2"><a href="#"><img src="http://placehold.it/500/40a1ff/002040&amp;text=H" class="img-responsive"></a></div>
                        </div>
                    </div>
                    <a class="left carousel-control" href="#carouselABC" data-slide="prev"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></a>
                    <a class="right carousel-control" href="#carouselABC" data-slide="next"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
        <?php
    }


}
