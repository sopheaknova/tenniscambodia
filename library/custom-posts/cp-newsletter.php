<?php
/*
*****************************************************
* Newsletter custom post
*
* CONTENT:
* - 1) Actions and filters
* - 2) Creating a custom post
* - 3) Custom post list in admin
*****************************************************
*/





/*
*****************************************************
*      1) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		//Registering CP
		add_action( 'init', 'sp_newsletter_cp_init' );
		//CP list table columns
		add_action( 'manage_posts_custom_column', 'sp_newsletter_cp_custom_column' );

	//FILTERS
		//CP list table columns
		add_filter( 'manage_edit-newsletter_columns', 'sp_newsletter_cp_columns' );




/*
*****************************************************
*      2) CREATING A CUSTOM POST
*****************************************************
*/
	/*
	* Custom post registration
	*/
	if ( ! function_exists( 'sp_newsletter_cp_init' ) ) {
		function sp_newsletter_cp_init() {
			global $cp_menu_position;

			/*if ( $smof_data['sp_newsticker_revisions'] )
				$supports[] = 'revisions';*/
			$labels = array(
				'name'               => __( 'Newsletters', 'sptheme_admin' ),
				'singular_name'      => __( 'Newsletter', 'sptheme_admin' ),
				'add_new'            => __( 'Add New', 'sptheme_admin' ),
				'all_items'          => __( 'All Newsletters', 'sptheme_admin' ),
				'add_new_item'       => __( 'Add New Newsletter', 'sptheme_admin' ),
				'new_item'           => __( 'Add New Newsletter', 'sptheme_admin' ),
				'edit_item'          => __( 'Edit Newsletter', 'sptheme_admin' ),
				'view_item'          => __( 'View Newsletter', 'sptheme_admin' ),
				'search_items'       => __( 'Search Newsletter', 'sptheme_admin' ),
				'not_found'          => __( 'No Newsletter found', 'sptheme_admin' ),
				'not_found_in_trash' => __( 'No Newsletter found in trash', 'sptheme_admin' ),
				'parent_item_colon'  => __( 'Parent Newsletter', 'sptheme_admin' ),
			);	

			$role     = 'post'; // page
			$slug     = 'newsletter';
			$supports = array('title', 'thumbnail'); // 'title', 'editor', 'thumbnail'

			$args = array(
				'labels' 				=> $labels,
				'rewrite'               => array( 'slug' => $slug ),
				'menu_position'         => $cp_menu_position['menu_newsletter'],
				'menu_icon'           	=> 'dashicons-media-document',
				'supports'              => $supports,
				'capability_type'     	=> $role,
				'query_var'           	=> true,
				'hierarchical'          => false,
				'public'                => true,
				'show_ui'               => true,
				'show_in_nav_menus'	    => false,
				'publicly_queryable'	=> true,
				'exclude_from_search'   => false,
				'has_archive'			=> false,
				'can_export'			=> true
			);
			register_post_type( 'newsletter' , $args );
		}
	} 


/*
*****************************************************
*      3) CUSTOM POST LIST IN ADMIN
*****************************************************
*/
	/*
	* Registration of the table columns
	*
	* $Cols = ARRAY [array of columns]
	*/
	if ( ! function_exists( 'sp_newsletter_cp_columns' ) ) {
		function sp_newsletter_cp_columns( $columns ) {
			
			$columns = array(
				'cb'                   	=> '<input type="checkbox" />',
				'newsletter_thumbnail'	=> __( 'Thumbnail', 'sptheme_admin' ),
				'title'                	=> __( 'Company Name', 'sptheme_admin' ),
				'date'		 			=> __( 'Date updated', 'sptheme_admin' )
			);

			return $columns;
		}
	}

	/*
	* Outputting values for the custom columns in the table
	*
	* $Col = TEXT [column id for switch]
	*/
	if ( ! function_exists( 'sp_newsletter_cp_custom_column' ) ) {
		function sp_newsletter_cp_custom_column( $column ) {
			global $post;
			
			switch ( $column ) {
				case "newsletter_thumbnail":
					echo get_the_post_thumbnail( $post->ID, array(50, 50) );
				break;

				default:
				break;
			}
		}
	} // /sp_newsletter_cp_custom_column

	
	