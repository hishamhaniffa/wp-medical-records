<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://laccadive.io/
 * @since      1.0.0
 *
 * @package    Wp_Medical_Records
 * @subpackage Wp_Medical_Records/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Medical_Records
 * @subpackage Wp_Medical_Records/admin
 * @author     Laccadive IO <muhammad@laccadive.io>
 */
class Wp_Medical_Records_Admin {

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

		add_action('admin_menu', array($this, 'wpmr_setup_menu' ) );
 
		add_action( 'all_admin_notices', array($this, 'wpmr_admin_tabs' ) );

		add_action( 'admin_head',  array($this, 'menu_highlight' ) );

		// add_shortcode('test',  array($this, 'form_creation' ) );
	}

	public function wpmr_setup_menu(){
		add_menu_page( 'Main Menu Page', 'Medical Records', 'manage_options', 
		'wpmr-main', 'wpmr_home' );
		// add_submenu_page( 'wpmr-main', 'Patients', 'Patients', 
		// 'manage_options', 'edit.php?post_type=patients' );
		global $submenu;
		$submenu['wpmr-main'][] = array( 'Patients', true, 'edit.php?post_type=patients' );
		$submenu['wpmr-main'][] = array( 'Episodes', true, 'edit.php?post_type=episodes' );
		$submenu['wpmr-main'][] = array( 'Visits', true, 'edit.php?post_type=visits' );

	}
	
	public function wpmr_admin_tabs() {
		$cs = get_current_screen()->id;
		if($cs == 'edit-patients'|| $cs == 'patients' || $cs == 'edit-episodes' || $cs == 'edit-visits') {
			?>
			<h1 class="nav-tab-wrapper">
				<a href="post-new.php?post_type=patients" class="nav-tab <?php if($cs == 'patients') echo 'nav-tab-active'; else echo ''; ?> nav-tab-1">New Patient</a>
				<a href="edit.php?post_type=patients" class="nav-tab <?php if($cs == 'edit-patients') echo 'nav-tab-active'; else echo ''; ?>  nav-tab-2">Patients</a>
				<a href="edit.php?post_type=episodes" class="nav-tab <?php if($cs == 'edit-episodes') echo 'nav-tab-active'; else echo ''; ?> nav-tab-3">Episodes</a>
				<a href="edit.php?post_type=visits" class="nav-tab <?php if($cs == 'edit-visits') echo 'nav-tab-active'; else echo ''; ?> nav-tab-4">Visits</a>
			</h1>
			<?php
		}
	}
	 
	public function menu_highlight(){
		global $parent_file, $submenu_file, $post_type;
		
		switch ( $post_type ) {
			case 'patients':
				$parent_file = 'wpmr-main'; 
				$submenu_file = 'edit.php?post_type=patients';
				break;
			case 'episodes':
				$parent_file = 'wpmr-main'; 
				$submenu_file = 'edit.php?post_type=episodes';
				break;
			case 'visits':
				$parent_file = 'wpmr-main'; 
				$submenu_file = 'edit.php?post_type=visits';
				break;
		}
	}

	public function form_creation(){
		?>
		<form>
		First name: <input type="text" name="firstname"><br>
		Last name: <input type="text" name="lastname"><br>
		Date: <input type="text" name="date"><br>
		Time: <input type="text" name="time"><br>
		Message: <textarea name="message"></textarea><br />
		<input type="submit" value="Submit" />
		</form>
		<?php
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
		 * defined in Wp_Medical_Records_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Medical_Records_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-medical-records-admin.css', array(), $this->version, 'all' );

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
		 * defined in Wp_Medical_Records_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Medical_Records_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-medical-records-admin.js', array( 'jquery' ), $this->version, false );

	}

}
