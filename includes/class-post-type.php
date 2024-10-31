<?php
/*
| -------------------------------------------
| Manage post type
|
| Add post type, Create metabox, Save metabox data
| -------------------------------------------
*/
class Post_Type {

	/**
	 * Constructor for the Post_Type class
	 */
	public function __construct() {

		$this->create_post_type();

		$this->create_taxonomy();

		add_action( 'add_meta_boxes_pathshala', [ $this, 'create_metaboxes' ] );

		add_action( 'save_post_pathshala', [ $this, 'save_metabox' ], 20, 2 );

	}

	/**
	 * Register a pathshala post type.
	 *
	 * @return  void
	 */
	private function create_post_type() {
		$labels = [
			'name'               => _x( 'Courses', 'post type general name', 'pathshala' ),
			'singular_name'      => _x( 'Course', 'post type singular name', 'pathshala' ),
			'menu_name'          => _x( 'Courses', 'admin menu', 'pathshala' ),
			'name_admin_bar'     => _x( 'Course', 'add new on admin bar', 'pathshala' ),
			'add_new'            => _x( 'Add New Course', 'book', 'pathshala' ),
			'add_new_item'       => __( 'Add New Course', 'pathshala' ),
			'new_item'           => __( 'New Course', 'pathshala' ),
			'edit_item'          => __( 'Edit Course', 'pathshala' ),
			'view_item'          => __( 'View Course', 'pathshala' ),
			'all_items'          => __( 'All Courses', 'pathshala' ),
			'search_items'       => __( 'Search Courses', 'pathshala' ),
			'parent_item_colon'  => __( 'Parent Courses:', 'pathshala' ),
			'not_found'          => __( 'No Course found.', 'pathshala' ),
			'not_found_in_trash' => __( 'No Course found in Trash.', 'pathshala' ),
		];

		$args = [
			'labels'             => $labels,
			'description'        => __( 'Description of Courses.', 'pathshala' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => [ 'slug' => 'Courses' ],
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => [ 'title', 'editor', 'thumbnail' ],
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-calendar',
		];

		register_post_type( 'pathshala', $args );
	}


	/**
	 * Add pathshala_category custom taxonomy
	 *
	 * @return  void
	 */
	private function create_taxonomy() {
		$category_labels = [
			'name'              => _x( 'Categories', 'taxonomy general name', 'pathshala' ),
			'singular_name'     => _x( 'Category', 'taxonomy singular name', 'pathshala' ),
			'search_items'      => __( 'Search Categories', 'pathshala' ),
			'all_items'         => __( 'All Categories', 'pathshala' ),
			'parent_item'       => __( 'Parent Category', 'pathshala' ),
			'parent_item_colon' => __( 'Parent Category:', 'pathshala' ),
			'edit_item'         => __( 'Edit Category', 'pathshala' ),
			'update_item'       => __( 'Update Category', 'pathshala' ),
			'add_new_item'      => __( 'Add New Category', 'pathshala' ),
			'new_item_name'     => __( 'New Category Name', 'pathshala' ),
			'menu_name'         => __( 'Categories', 'pathshala' ),
		];

		$category_args = [
			'hierarchical'      => true,
			'labels'            => $category_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'Course-categories' ),
			'show_in_rest'      => true,
		];

		$tag_labels = [
			'name'              => _x( 'Tags', 'taxonomy general name', 'pathshala' ),
			'singular_name'     => _x( 'Tag', 'taxonomy singular name', 'pathshala' ),
			'search_items'      => __( 'Search Tags', 'pathshala' ),
			'all_items'         => __( 'All Tags', 'pathshala' ),
			'parent_item'       => __( 'Parent Tag', 'pathshala' ),
			'parent_item_colon' => __( 'Parent Tag:', 'pathshala' ),
			'edit_item'         => __( 'Edit Tag', 'pathshala' ),
			'update_item'       => __( 'Update Tag', 'pathshala' ),
			'add_new_item'      => __( 'Add New Tag', 'pathshala' ),
			'new_item_name'     => __( 'New Tag Name', 'pathshala' ),
			'menu_name'         => __( 'Tags', 'pathshala' ),
		];

		$tag_args = [
			'hierarchical'      => true,
			'labels'            => $tag_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'Course-tags' ),
			'show_in_rest'      => true,
		];

		register_taxonomy( 'pathshala_category', [ 'pathshala' ], $category_args );
		register_taxonomy( 'pathshala_tag', [ 'pathshala' ], $tag_args );
	}

	/**
	 * Metaboxes of `pathshala` post type
	 */
	public function create_metaboxes() {

		add_meta_box(
			'Course-details',
			'Course Details',
			[ $this, 'render_details_metabox' ],
			'pathshala',
			'advanced',
			'default'
		);

	}

	/**
	 * Renders the meta box of Course details.
	 */
	public function render_details_metabox( $post ) {
		$meta = get_post_custom( $post->ID );

//		var_dump($meta);
		$course_attachment = ! isset( $meta['pathshala_course_attachment'][0] ) ? '' : $meta['pathshala_course_attachment'][0];
//		$saved = get_post_meta( $post->ID, 'pathshala_course_attachment', true );
		$course_video_url = ! isset( $meta['course_video_url'][0] ) ? '' : $meta['course_video_url'][0];

		wp_nonce_field( basename( __FILE__ ), 'Course_details_fields' );
	?>

	<table class="form-table">
		<tr>
			<td class="Course_meta_box_td" colspan="2">
				<label for="pathshala_course_attachment"><?php _e( 'Course Attachment', 'pathshala' ); ?>
				</label>
			</td>
			<td colspan="4">
                <input type="url" class="large-text" name="pathshala_course_attachment" id="pathshala_course_attachment" value="<?php echo esc_attr( $course_attachment ); ?>">
                <button type="button" class="button" id="events_video_upload_btn" data-media-uploader-target="#pathshala_course_attachment"><?php _e( 'Upload Attachment', 'pathshala' )?></button>
			</td>
		</tr>

		<tr>
			<td class="Course_meta_box_td" colspan="2">
				<label for="course_video_url"><?php _e( 'Course Video URL', 'pathshala' ); ?>
				</label>
			</td>
			<td colspan="4">
				<input type="text" id="course_video_url" name="course_video_url" class="regular-text" value="<?php echo $course_video_url; ?>">
				<p class="description"><?php _e( 'Video URL', 'pathshala' ); ?></p>
			</td>
		</tr>
	</table>

	<?php

	}

	/**
	 * Save metabox data
	 */
	public function save_metabox( $post_id ) {

		global $post;

		// Verify nonce
		if ( ! isset( $_POST['Course_details_fields'] ) || ! wp_verify_nonce( $_POST['Course_details_fields'], basename(__FILE__) ) ) {
			return $post_id;
		}

		// Check if not an autosave.
		if ( wp_is_post_autosave( $post_id ) ) {
			return;
		}

		// Check if not a revision.
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		// Check permissions
		if ( ! current_user_can( 'edit_post', $post->ID ) ) {
			return $post_id;
		}

		$meta['pathshala_course_attachment'] = ( isset( $_POST['pathshala_course_attachment'] ) ? sanitize_text_field( $_POST['pathshala_course_attachment'] ) : '' );
		$meta['course_video_url'] = ( isset( $_POST['course_video_url'] ) ? sanitize_text_field( $_POST['course_video_url'] ) : '' );

		foreach ( $meta as $key => $value ) {
			update_post_meta( $post->ID, $key, $value );
		}

	}

}

function pathshala_load_media_script( $hook ) {
	global $typenow;
	if( $typenow == 'pathshala' ) {
		wp_enqueue_media();
		wp_register_script( 'meta-box-image', PATHSHALA_ROOT_URL . 'admin/js/media-uploader.js', array( 'jquery' ) );
		wp_localize_script( 'meta-box-image', 'meta_image',
			array(
				'title' => __( 'Choose or Upload Media', 'events' ),
				'button' => __( 'Use this media', 'events' ),
			)
		);
		wp_enqueue_script( 'meta-box-image' );
	}
}
add_action( 'admin_enqueue_scripts', 'pathshala_load_media_script', 10, 1 );
