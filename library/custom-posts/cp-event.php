<?php
/*
*****************************************************
* Event custom post
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
		add_action( 'init', 'sp_event_cp_init' );
		//CP list table columns
		add_action( 'manage_posts_custom_column', 'sp_event_cp_custom_column' );

	//FILTERS
		//CP list table columns
		add_filter( 'manage_edit-event_columns', 'sp_event_cp_columns' );




/*
*****************************************************
*      2) CREATING A CUSTOM POST
*****************************************************
*/
	/*
	* Custom post registration
	*/
	if ( ! function_exists( 'sp_event_cp_init' ) ) {
		function sp_event_cp_init() {
			global $cp_menu_position;

			/*if ( $smof_data['sp_newsticker_revisions'] )
				$supports[] = 'revisions';*/
			$labels = array(
				'name'               => __( 'Events', 'sptheme_admin' ),
				'singular_name'      => __( 'Event', 'sptheme_admin' ),
				'add_new'            => __( 'Add New', 'sptheme_admin' ),
				'all_items'          => __( 'All Events', 'sptheme_admin' ),
				'add_new_item'       => __( 'Add New Event', 'sptheme_admin' ),
				'new_item'           => __( 'Add New Event', 'sptheme_admin' ),
				'edit_item'          => __( 'Edit Event', 'sptheme_admin' ),
				'view_item'          => __( 'View Event', 'sptheme_admin' ),
				'search_items'       => __( 'Search Event', 'sptheme_admin' ),
				'not_found'          => __( 'No Event found', 'sptheme_admin' ),
				'not_found_in_trash' => __( 'No Event found in trash', 'sptheme_admin' ),
				'parent_item_colon'  => __( 'Parent Event', 'sptheme_admin' ),
			);	

			$role     = 'post'; // page
			$slug     = 'event';
			$supports = array('title', 'editor'); // 'title', 'editor', 'thumbnail'

			$args = array(
				'labels' 				=> $labels,
				'rewrite'               => array( 'slug' => $slug ),
				'menu_position'         => $cp_menu_position['menu_event'],
				'menu_icon'           	=> 'dashicons-calendar',
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
			register_post_type( 'event' , $args );
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
	if ( ! function_exists( 'sp_event_cp_columns' ) ) {
		function sp_event_cp_columns( $columns ) {
			
			$columns = array(
				'cb'                   	=> '<input type="checkbox" />',
				'title'                	=> __( 'Name', 'sptheme_admin' ),
				'event_date'		 	=> __( 'Date/Time', 'sptheme_admin' ),
				'event_location'		=> __( 'Location', 'sptheme_admin' )
			);

			return $columns;
		}
	}

	/*
	* Outputting values for the custom columns in the table
	*
	* $Col = TEXT [column id for switch]
	*/
	if ( ! function_exists( 'sp_event_cp_custom_column' ) ) {
		function sp_event_cp_custom_column( $column ) {
			global $post;
			
			switch ( $column ) {
				case "event_date":
					$event_start_date = explode( ' ', get_post_meta( $post->ID, 'sp_event_start_date', true ) );
					$event_end_date = explode( ' ', get_post_meta( $post->ID, 'sp_event_end_date', true ) );
					$out = 'from ' . date("d F Y", strtotime($event_start_date[0]));
					$out .= ' to ' . date("d F Y", strtotime($event_end_date[0])) . '<address>' . $event_start_date[1] . ' to ' . $event_end_date[1] . '</address>';
					echo $out;
				break;

				case "event_location":
					echo get_post_meta( $post->ID, 'sp_event_location', true );
				break;
				
				default:
				break;
			}
		}
	} // /sp_event_cp_custom_column

	
	