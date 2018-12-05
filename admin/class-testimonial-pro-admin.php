<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link      https://digitalcenturysf.com/
 * @since      1.0.0
 *
 * @package    Testimonial_Pro
 * @subpackage Testimonial_Pro/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Testimonial_Pro
 * @subpackage Testimonial_Pro/admin
 * @author     digitalcenturysf <digitalcenturysf@gmail.com>
 */
class Testimonial_Pro_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $testimonial_pro    The ID of this plugin.
	 */
	private $testimonial_pro;

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
	 * @param      string    $testimonial_pro       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $testimonial_pro, $version ) {

		$this->testimonial_pro = $testimonial_pro;
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
		 * defined in Testimonial_Pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Testimonial_Pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->testimonial_pro, plugin_dir_url( __FILE__ ) . 'css/testimonial-pro-admin.css', array(), $this->version, 'all' );

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
		 * defined in Testimonial_Pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Testimonial_Pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->testimonial_pro, plugin_dir_url( __FILE__ ) . 'js/testimonial-pro-admin.js', array( 'jquery' ), $this->version, false );

	}


    /**
     * Support post thumbnail 
     * @since    1.0.0
     */
    public function testimonial_pro_thumbnail_support() {
        if ( ! current_theme_supports( 'post-thumbnails' ) ) {
            add_theme_support( 'post-thumbnails' );
        } 
    }

 
	/**
	 * Register Post Type for Testimonial Pro
	 *
	 * @since    1.0.0
	 */
	public function testimonial_pro_post_type() {

		$labels_Testimonial_pro = array(
			'name'               => _x( 'Testimonials', 'Post Type General Name', $this->testimonial_pro ),
			'singular_name'      => _x( 'Testimonial', 'Post Type Singular Name', $this->testimonial_pro ),
			'menu_name'          => __( 'Testimonials', $this->testimonial_pro ),
			'parent_item_colon'  => __( 'Parent Testimonial:', $this->testimonial_pro ),
			'all_items'          => __( 'All Testimonials', $this->testimonial_pro ),
			'view_item'          => __( 'View Testimonials', $this->testimonial_pro ),
			'add_new_item'       => __( 'Add New Testimonial', $this->testimonial_pro ),
			'add_new'            => __( 'Add Testimonial', $this->testimonial_pro ),
			'edit_item'          => __( 'Edit Testimonial', $this->testimonial_pro ),
			'update_item'        => __( 'Update Testimonial', $this->testimonial_pro ),
			'search_items'       => __( 'Search Testimonials', $this->testimonial_pro ),
			'not_found'          => __( 'Not found', $this->testimonial_pro ),
			'not_found_in_trash' => __( 'Not found in Trash', $this->testimonial_pro ),
		);

		$args_Testimonial_pro   = array(
			'label'               => __( 'Testimonial', $this->testimonial_pro ),
			'description'         => __( 'Testimonial Display', $this->testimonial_pro ),
			'labels'              => $labels_Testimonial_pro,
			'supports'            => array( 'editor','thumbnail' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'menu_icon'           => 'dashicons-editor-quote',
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
		);
		register_post_type( 'testimonial_pro', $args_Testimonial_pro );
 
	}

	/**
	 * Register Categories for Testimonial Pro
	 *
	 * @since    1.0.0
	 */
	public function testimonial_pro_categories() {

		$testimonial_pro_cats_args = array(
			'hierarchical'   => true,
			'label'          => 'Categories',
			'show_ui'        => true,
			'query_var'      => true,
			'rewrite'        => true,
			'singular_label' => 'Categories'
		);
		register_taxonomy('testimonial_pro_cats', array('testimonial_pro'), $testimonial_pro_cats_args);
 
	}

	/**
	 * Register Columns for Testimonial Pro Admin View
	 *
	 * @since    1.0.0
	 */ 
	public function testimonial_pro_columns_register() {

		add_filter( 'manage_testimonial_pro_posts_columns', array($this, 'testimonial_pro_columns_head'), 10, 1);
		add_action('manage_testimonial_pro_posts_custom_column', array($this, 'testimonial_pro_columns_content'), 10, 2);

	}

	/**
	 * Register Columns head for Testimonial Pro Admin View
	 *
	 * @since    1.0.0
	 */ 
	public function testimonial_pro_columns_head($columns) {
	   $columns = array(
	      'cb' => $columns['cb'],
	      'tpro_full_name' => __( 'Full Name' ),
	      'tpro_email' => __( 'Email' ),
	      'tpro_company' => __( 'Company' ),
	      'tpro_thumbnail' => __( 'Thumbnail' ), 
	      'date' => $columns['date'], 
	    ); 
	    return $columns;
	}


	/**
	 * Register Columns content for Testimonial Pro Admin View
	 *
	 * @since    1.0.0
	 */ 
	public function testimonial_pro_columns_content($column_name, $post_id) { 

		$fieldValues = get_post_meta( $post_id, '_testimonialprometa', true ); 

		$client_name    = !empty( $fieldValues['client_name'] ) ? $fieldValues['client_name'] : '';
		$email = !empty( $fieldValues['email'] ) ? $fieldValues['email'] : '';
		$company_name = !empty( $fieldValues['company_name'] ) ? $fieldValues['company_name'] : '';
		$company_website= !empty( $fieldValues['company_website'] ) ? $fieldValues['company_website'] : ''; 

		if ( 'tpro_full_name' === $column_name ) {
		    if ( ! $client_name ) {
		      esc_html_e( 'n/a',$this->testimonial_pro );  
		    } else {
		      echo esc_html($client_name);
		    }
		}
		if ( 'tpro_email' === $column_name ) { 

		    if ( ! $email ) {
		      esc_html_e( 'n/a',$this->testimonial_pro );  
		    } else {
		      echo esc_html($email);
		    }
		}
		if ( 'tpro_company' === $column_name ) { 

		    if ( ! $company_name ) {
		      esc_html_e( 'n/a',$this->testimonial_pro );  
		    } else {
		    	echo '<a href="'.esc_url($company_website).'" target="_blanks">'.esc_html($company_name).'</a>';
		    }
		}
	    if ( 'tpro_thumbnail' === $column_name ) {
		    echo get_the_post_thumbnail( $post_id, array(80, 80) );
		}
		  
	}

	/**
	 * Register Columns content for Testimonial Pro Admin View
	 *
	 * @since    1.0.0
	 */ 
	public function testimonial_pro_add_meta_boxes() { 
	    add_meta_box( 'food_meta_box', __( 'Client Details', $this->testimonial_pro ), array($this,'testimonial_pro_metabox_display'), 'testimonial_pro', 'normal', 'low' );
	}


	/**
	 * Add metabox for custom post type
	 *
	 * @since    1.0.0
	 */
	public function testimonial_pro_metabox_display( $post) {

 
		$fieldValues = get_post_meta( $post->ID, '_testimonialprometa', true );

		wp_nonce_field( 'testimonial_pro', 'testimonial_pro[nonce]' );

		echo '<div id="testimonialpro_metabox_wrapper">';

		$client_name    = isset( $fieldValues['client_name'] ) ? $fieldValues['client_name'] : '';
		$email = isset( $fieldValues['email'] ) ? $fieldValues['email'] : '';
		$company_name = isset( $fieldValues['company_name'] ) ? $fieldValues['company_name'] : '';
		$company_website= isset( $fieldValues['company_website'] ) ? $fieldValues['company_website'] : ''; 
		?>

		<div class="inside">
			<table class="options">
				<tbody>
					<tr>
						<td colspan="2">
							<p>To add a photo or logo, use the Featured Image option.</p>
						</td>
					</tr>
					<tr>
						<th>
							<label for="client_name"><?php esc_html_e( 'Full Name', $this->testimonial_pro ); ?></label>
						</th>
						<td>
							<div class="text">
								<input id="client_name" type="text" class="custom-input" name="testimonial_pro[client_name]" value="<?php echo esc_attr($client_name); ?>">                        
							</div>
						</td>
					</tr>
					<tr>
						<th>
							<label for="email"><?php esc_html_e( 'Email', $this->testimonial_pro ); ?></label>
						</th>
						<td>
							<div class="email">
								<input id="email" type="email" class="custom-input" name="testimonial_pro[email]" value="<?php echo esc_attr($email); ?>">                        
							</div>
						</td>
					</tr>
					<tr>
						<th>
							<label for="company_name"><?php esc_html_e( 'Company Name', $this->testimonial_pro ); ?></label>
						</th>
						<td>
							<div class="text">
								<input id="company_name" type="text" class="custom-input" name="testimonial_pro[company_name]" value="<?php echo esc_attr($company_name); ?>">                        
							</div>
						</td>
					</tr>
					<tr>
						<th>
							<label for="company_website"><?php esc_html_e( 'Company Website', $this->testimonial_pro ); ?></label>
						</th>
						<td>
							<div class="url">
								<div class="input-url">
									<input id="company_website" type="url" class="custom-input" name="testimonial_pro[company_website]" value="<?php echo esc_attr($company_website); ?>" size="" placeholder="http://">        
								</div> 
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<?php
		echo '</div>';


	}


	/**
	 * Determines whether or not the current user has the ability to save meta data associated with this post.
	 *
	 * Save testimonialpro Meta Field
	 *
	 * @param        int $post_id //The ID of the post being save
	 * @param         bool //Whether or not the user has the ability to save this post.
	 */
	public function testimonial_pro_save_post_metaboxes( $post_id, $post ) {

		$post_type = 'testimonial_pro';

		// If this isn't a 'book' post, don't update it.
		if ( $post_type != $post->post_type ) {
			return;
		}

		if ( ! empty( $_POST['testimonial_pro'] ) ) {

			$postData = $_POST['testimonial_pro'];

			$saveableData = array();

			if ( $this->user_can_save( $post_id, 'testimonial_pro', $postData['nonce'] ) ) {
 
				$saveableData['client_name']        = sanitize_text_field( $postData['client_name'] );
				$saveableData['email']       = sanitize_text_field( $postData['email'] );
				$saveableData['company_name']     = $postData['company_name'];
				$saveableData['company_website']     = $postData['company_website'];
				$saveableData['custom_tag_three']   = $postData['custom_tag_three'];

				update_post_meta( $post_id, '_testimonialprometa', $saveableData );
			}
		}
	}// End  Meta Save  

	/**
	 * Determines whether or not the current user has the ability to save meta data associated with this post.
	 *
	 * user_can_save
	 *
	 * @param        int $post_id // The ID of the post being save
	 * @param        bool /Whether or not the user has the ability to save this post.
	 *
	 * @since 1.0
	 */
	public function user_can_save( $post_id, $action, $nonce ) {

		$is_autosave    = wp_is_post_autosave( $post_id );
		$is_revision    = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $nonce ) && wp_verify_nonce( $nonce, $action ) );

		// Return true if the user is able to save; otherwise, false.
		return ! ( $is_autosave || $is_revision ) && $is_valid_nonce;

	}




}
